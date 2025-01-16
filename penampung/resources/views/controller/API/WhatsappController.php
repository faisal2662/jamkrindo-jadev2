<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;

use App\Models\API\Pengaduan;

class WhatsappController extends Controller
{
    public static function send($to, $parameters)
    {
        return null;
        
        $setupWhatsapp = DB::table('tb_setup_whatsapp')
            ->where('is_delete', 'N')
            ->first();

        if (is_null($setupWhatsapp)) return null;

        $isActive = $setupWhatsapp->status_setup == 'TRUE';

        if ($isActive) {
            $client = new \GuzzleHttp\Client();
            $client->request(
                'POST',
                'https://graph.facebook.com/v17.0/140448322494530/messages',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer EAAJjZChMuG7gBO40fKyM618R6dhcMGEJZBbLXsLDnZBFLA1w4BjMYKdUM2ZA9qZCfZCUIDlYn4lkapxaCvwsYIo9xiXYfaa9h0CpSGFi9H8YIjHrZBrrbbgXMDRSrIKfqBFyv7ZAiZBzKZCrrr90TjAqsv48iII1cZBTjagALualZB2qYQ9bkwiO3ris8CS26ZBO8foj1',
                    ],
                    'json' => [
                        'messaging_product' => 'whatsapp',
                        'to' => self::fixPhoneNumber($to),
                        'type' => 'template',
                        'template' => [
                            'name' => 'helpdesk_utility',
                            'language' => [
                                'code' => 'id'
                            ],
                            'components' => [
                                [
                                    'type' => 'body',
                                    'parameters' => $parameters
                                ]
                            ]
                        ],
                    ]
                ]
            );
        }
    }

    public static function fixPhoneNumber($phoneNumber)
    {
        if (substr(trim($phoneNumber), 0, 2) == '62') {
            return trim($phoneNumber);
        }
        if (substr(trim($phoneNumber), 0, 1) == '0') {
            return '62'.substr(trim($phoneNumber), 1);
        }
        return $phoneNumber;
    }

    public static function sendComplaint($phones, $complaintId = null)
    {
        $complaint = Pengaduan::with(
                'employee',
                'headOfficeSection.headOffice',
                'branchOfficeSection.branchOffice',
                'regionalOfficeSection.regionalOffice',
            )
            ->where('tb_pengaduan.id_pengaduan', $complaintId)
            ->first();

        if (is_null($complaint)) return null;

        $officeName = '';
        $branchName = '';

        if ($complaint->id_bagian_kantor_pusat != 0) {
            $officeName = $complaint->headOfficeSection->headOffice->nama_kantor_pusat;
            $branchName = $complaint->headOfficeSection->nama_bagian_kantor_pusat;
        } else if ($complaint->id_bagian_kantor_cabang != 0) {
            $officeName = $complaint->branchOfficeSection->branchOffice->nama_kantor_cabang;
            $branchName = $complaint->branchOfficeSection->nama_bagian_kantor_cabang;
        } else {
            $officeName = $complaint->regionalOfficeSection->regionalOffice->nama_kantor_wilayah;
            $branchName = $complaint->regionalOfficeSection->nama_bagian_kantor_wilayah;
        }

        $parameters = [
            [
                'type' => 'text',
                'text' => $complaint->employee->nama_pegawai
            ],
            [
                'type' => 'text',
                'text' => 'P'.date('y').'-0000'.$complaint->id_pengaduan
            ],
            [
                'type' => 'text',
                'text' => $officeName .' - '.  $branchName
            ],
            [
                'type' => 'text',
                'text' => $complaint->nama_pengaduan
            ],
            [
                'type' => 'text',
                'text' => $complaint->keterangan_pengaduan
            ],
            [
                'type' => 'text',
                'text' => $complaint->klasifikasi_pengaduan ?? '-'
            ],
            [
                'type' => 'text',
                'text' => $complaint->status_pengaduan
            ]
        ];
        
        foreach ($phones as $phone) {
            self::send($phone, $parameters);
        }
    }
}
