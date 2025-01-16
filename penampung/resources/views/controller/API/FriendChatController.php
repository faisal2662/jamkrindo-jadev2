<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use Auth;
use Session;
use Validator;
use Exception;
use App\Models\API\Kontak;
use App\Models\API\LogKontak;
use App\Models\API\Pengaduan;
use App\Models\API\Pegawai;
use App\Models\API\Chat;

use App\Http\Controllers\Chat as WebChatController;

class FriendChatController extends Controller
{
    public function getChats()
    {
        $employee = Auth::user();

        $contacts = Kontak::with([
                'chats' => function ($query) {
                    $query->with('employee.position')->orderBy('id_chat', 'DESC');
                }
            ])
            ->whereHas('complaint', function ($query) use ($employee) {
                $query->where([
                    'id_bagian_kantor_pusat' => $employee->id_bagian_kantor_pusat,
                    'id_bagian_kantor_wilayah' => $employee->id_bagian_kantor_wilayah,
                    'id_bagian_kantor_cabang' => $employee->id_bagian_kantor_cabang,
                    'delete_pengaduan' => 'N'
                ]);
            })
            ->orderBy('tb_kontak.id_kontak', 'DESC')
            ->get()
            ->map(function ($contact) {
                $contact['tgl'] = $contact->tgl_kontak;
                if (isset($contact->chats->first)) {
                    $contact['tgl'] = $contact->chats->first->tgl_chat;
                }
                return $contact;
            })
            ->sortByDesc(function ($contact) {
                return $contact->tgl;
            })
            ->values();

        return $contacts;
    }

    public function getChat($id)
    {
        $employee = Auth::user();

        $contact = Kontak::with([
                'chats' => function ($query) {
                    $query->with('employee.position')->orderBy('id_chat', 'DESC');
                }
            ])
            ->find($id);

        if ($contact == null) {
            return response()->json([
                'message' => 'Kontak tidak ditemukan.'
            ], 404);
        }

        Chat::where([
                'room_chat' => $contact->id_kontak,
                'status_chat' => 'Delivery',
                'delete_chat' => 'N'
            ])
            ->where('id_pegawai', '!=', $employee->id_pegawai)
            ->update([
                'status_chat' => 'Read'
            ]);

        LogKontak::where([
                'id_kontak' => $contact->id_kontak,
                'id_pegawai' => $employee->id_pegawai,
                'delete_log_kontak' => 'N'
            ])
            ->update([
                'status_log_kontak' => 'Read'
            ]);

        $logContacts = LogKontak::where([
                'id_pegawai' => $employee->id_pegawai,
                'ajax_log_kontak' => 'Run',
                'delete_log_kontak' => 'N'
            ])
            ->get();
        if ($logContacts->count() > 0) {
            LogKontak::where('delete_log_kontak', 'N')
                ->whereIn('id_log_kontak', $logContacts->pluck('id_log_kontak'))
                ->update([
                    'ajax_log_kontak' => 'Close'
                ]);
        }
        $logContacts = LogKontak::where([
                'id_pegawai' => $employee->id_pegawai,
                'song_log_kontak' => 'Play',
                'delete_log_kontak' => 'N'
            ])
            ->get();
        if ($logContacts->count() > 0) {
            LogKontak::where('delete_log_kontak', 'N')
                ->whereIn('id_log_kontak', $logContacts->pluck('id_log_kontak'))
                ->update([
                    'song_log_kontak' => 'Stop'
                ]);
        }

        return $contact;
    }

    public function sendChat($id, Request $request)
    {
        $contact = Kontak::find($id);

        if ($contact == null) {
            return response()->json([
                'message' => 'Kontak tidak ditemukan.'
            ], 404);
        }

        $complaintId = intval(substr($contact->kode_pengaduan, 4));
        $complaint = Pengaduan::with([
                'headOfficeSection',
                'regionalOfficeSection',
                'branchOfficeSection',
            ])
            ->where([
                'id_pengaduan' => $complaintId,
                'delete_pengaduan' => 'N'
            ])
            ->first();

        if ($complaint == null) {
            return response()->json([
                'message' => 'Pengaduan tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'keterangan_chat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $employee = Auth::user();

        $requestController = new Request();
        Session::put('id_pegawai', $employee->id_pegawai);
        $requestController->replace([
            'kontak' => $id,
            'keterangan' => $request->keterangan_chat
        ]);
        $chatController = new WebChatController();
        $chatController->kirim_chat($requestController);

        try {
            $employeeIds = Pegawai::where(function ($query) use ($complaint) {
                    $query
                        ->where(function ($subQuery) use ($complaint) {
                            $subQuery
                                ->where([
                                    'kantor_pegawai' => $complaint->kantor_pengaduan,
                                    'id_bagian_kantor_pusat' => $complaint->id_bagian_kantor_pusat,
                                    'id_bagian_kantor_cabang' => $complaint->id_bagian_kantor_cabang,
                                    'id_bagian_kantor_wilayah' => $complaint->id_bagian_kantor_wilayah,
                                ])
                                ->whereHas('position', function ($query) {
                                    $query->whereIn('sebagai_posisi', ['Kepala Bagian Unit Kerja', 'Staf']);
                                });
                        })
                        // ->orWhere(function ($subQuery) use ($complaint) {
                        //     switch ($complaint->kantor_pengaduan) {
                        //         case 'Kantor Pusat':
                        //             $officeId = $complaint->headOfficeSection->id_kantor_pusat;
                        //             break;
                        //         case 'Kantor Cabang':
                        //             $officeId = $complaint->branchOfficeSection->id_kantor_cabang;
                        //             break;
                        //         default:
                        //             $officeId = $complaint->regionalOfficeSection->id_kantor_wilayah;
                        //     }
                        //     $subQuery
                        //         ->where([
                        //             'kantor_pegawai' => $complaint->kantor_pengaduan,
                        //             'multi_pegawai' => $officeId,
                        //         ])
                        //         ->whereHas('position', function ($query) {
                        //             $query->where('sebagai_posisi', 'Kepala Unit Kerja');
                        //         });
                        // })
                        ->orWhere('id_pegawai', $complaint->id_pegawai);
                        // ->orWhere(function ($subQuery) use ($complaint) {
                        //     switch ($complaint->kantor_pengaduan) {
                        //         case 'Kantor Pusat':
                        //             $officeId = $complaint->headOfficeSection->id_kantor_pusat;
                        //             break;
                        //         case 'Kantor Cabang':
                        //             $officeId = $complaint->branchOfficeSection->id_kantor_cabang;
                        //             break;
                        //         default:
                        //             $officeId = $complaint->regionalOfficeSection->id_kantor_wilayah;
                        //     }
                        //     $subQuery
                        //         ->where([
                        //             'kantor_pegawai' => $complaint->kantor_pengaduan,
                        //             'multi_pegawai' => $officeId,
                        //         ])
                        //         ->whereHas('position', function ($query) {
                        //             $query->where('sebagai_posisi', 'Kepala Unit Kerja');
                        //         });
                        // });
                })
                ->where([
                    ['id_pegawai', '!=', $employee->id_pegawai],
                    'status_pegawai' => 'Aktif',
                    'delete_pegawai' => 'N'
                ])
                ->pluck('id_pegawai');

            FirebaseMessagingController::sendMessageToManyEmployee(
                $employeeIds,
                $employee->nama_pegawai,
                $request->keterangan_chat,
                [
                    'screen' => '/chat-detail',
                    'id' => $contact->id_kontak
                ]
            );

            $contact = Kontak::with([
                    'chats' => function ($query) {
                        $query->with('employee.position')->orderBy('id_chat', 'DESC');
                    }
                ])
                ->find($id);

            return $contact;
        } catch (Exception $error) {
            Log::error($error);

            return $error;
        }
    }
}
