<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Log;
use Mail;
use Auth;
use Validator;
use Exception;

use App\Models\API\UserFAQ;
use App\Models\API\KategoriFAQ;
use App\Models\API\BagianKantorPusat;
use App\Models\API\BagianKantorCabang;
use App\Models\API\BagianKantorWilayah;

class FAQControllerV2 extends Controller
{
    public function getFAQs()
    {
        return KategoriFAQ::select('id_kategori_faq', 'nama_kategori_faq')
            ->with([
                'faqs' => function ($query) {
                    $query->select(
                        'id_faq',
                        'id_kategori_faq',
                        'pertanyaan_faq',
                        'jawaban_faq'
                    );
                }
            ])
            ->where([
                'is_delete' => 'N'
            ])
            ->get();
    }

    public function storeFAQs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'kantor' => 'required',
            'bagian' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $date = Carbon::now();
        $branch = $request->bagian;
        $office = explode(',', $request->kantor);
        $office = $office[0];
        
        if ($office == 'Kantor Pusat') {
            $branchOffice = BagianKantorPusat::with('headOffice')->where('id_bagian_kantor_pusat', $branch)->where('delete_bagian_kantor_pusat', 'N')->first();
            $officeName = $branchOffice->nama_kantor_pusat;
            $branchName = $branchOffice->nama_bagian_kantor_pusat;
        } elseif ($office == 'Kantor Cabang') {
            $branchOffice = BagianKantorCabang::with('branchOffice')->where('id_bagian_kantor_cabang', $branch)->where('delete_bagian_kantor_cabang', 'N')->first();
            $officeName = $branchOffice->nama_kantor_cabang;
            $branchName = $branchOffice->nama_bagian_kantor_cabang;
        } else {
            $branchOffice = BagianKantorWilayah::with('regionalOffice')->where('id_bagian_kantor_wilayah', $branch)->where('delete_bagian_kantor_wilayah', 'N')->first();
            $officeName = $branchOffice->nama_kantor_wilayah;
            $branchName = $branchOffice->nama_bagian_kantor_wilayah;
        }

        try {
            UserFAQ::create([
                'pertanyaan_faq' => $request->pertanyaan,
                'kantor' => $office,
                'id_bagian' => $request->bagian,
                'nama_faq' => $request->nama,
                'email_faq' => $request->email,
                'updated_by' => '0',
                'updated_date' => $date,
                'deleted_date' => $date,
                'deleted_by' => 0,
                'delete_faq' => 0
            ]);
            
            $fromEmail = $request->email;
            $toEmail = 'ulumcyber@gmail.com';

            $data = [
                'pertanyaan' => $request->pertanyaan,
                'kantor' => $office,
                'bagian_kantor' => $officeName,
                'bagian' => $branchName,
                'nama' => $request->nama,
                'emai' => $request->email,
                'date' => $date
            ];

            try {
                Mail::send('pages.faq.email_jawaban', $data, function ($message) use ($toEmail, $fromEmail) {
                    $message
                        ->to($fromEmail)
                        ->subject('Pengaduan Baru (Pending)')
                        ->from(env('MAIL_FROM_ADDRESS'), 'Helpdesk - Jamkrindo');;
                });
            } catch (Exception $e) {
                Log::error($error);
                return $error;
            }

            return response()->json([
                'message' => 'success'
            ]);
        } catch (Exception $error) {
            Log::error($error);
            return $error;
        }
    }
}
