<?php

namespace App\Http\Controllers;

use App\Models\AuditTrails;
use Jenssegers\Agent\Agent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function logAuditTrail($action, $model, $before, $after){
        $agent = new Agent();

    // Tangani jika model berupa objek atau string

        $modelName = is_object($model) ? get_class($model) : (is_string($model) ? $model : 'unknown');


        AuditTrails::create([
            'kd_user' => auth()->user()->kd_user ?? 0,
            'action' =>$action,
            'model' => $modelName,
            'before' => json_encode($before),
            'after' => json_encode($after),
            'ip_address' => request()->ip(),
            'browser'           => $agent->browser(),
            'browser_version'   => $agent->version($agent->browser()),
            'platform'          => $agent->platform(),
            'platform_version'  => $agent->version($agent->platform()),
            'device'            => $agent->device(),
        ]);
    }
}
