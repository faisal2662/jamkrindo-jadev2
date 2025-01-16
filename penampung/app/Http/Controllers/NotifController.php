<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notif;
use Illuminate\Http\Request;
use DataTables;
class NotifController extends Controller
{
    //

    public function index(){

        $notif = Notif::where('kd_user', auth()->user()->kd_user)->where('is_delete', 'N')->get();
        return view('notif.index');
    }

    public function datatable()
    {
        $notif = Notif::where('kd_user', auth()->user()->kd_user)->where('is_delete', 'N')->orderBY('created_date', 'desc')->get();
        $no = 1;
        $status = [
            'Info' => 'bi bi-info-circle text-primary',
            'Reject' => 'bi bi-x-circle text-danger',
            'Approve' => 'bi bi-check-circle text-success',
            'Delete' => 'bi bi-trash text-warning',
            'DeleteApprove' => 'bi bi-trash text-success',
            'DeleteReject' => 'bi bi-trash text-danger',
        ];
        foreach ($notif as $data) {
            # code...
            $data->no = $no++;
            $data->link = ' <i class="'. $status[$data->status] .'"></i> <a onclick="return read(event, '. $data->id .')" href="'. $data->tautan .'">Klik disini</a>';
            if($data->status_notif == 'FALSE'){
                $data->status = '<span class="badge bg-primary">Belum dibaca</span>';
                $data->waktu = Carbon::parse($data->created_date)->diffForHumans();
            }else{
                $data->waktu = Carbon::parse($data->created_date)->translatedFormat('d F Y H:i');
                $data->status = '<span class="badge bg-success">Sudah dibaca</span>';

            }

        }

        return datatables::of($notif)->escapecolumns([])->make(true);
    }

    public function read(Request $request)
    {
        $id = $request->id;
        $notif = Notif::find($id);
        $notif->status_notif = 'TRUE';
        $notif->update();
        return response()->json(['status' => 'success','tautan' => $notif->tautan], 200);
    }
}
