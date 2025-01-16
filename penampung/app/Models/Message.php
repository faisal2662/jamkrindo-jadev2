<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;

class Message extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $table = 't_pesan';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    /**
     * Get the Chat associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Chat(): HasOne
    {
        return $this->hasOne(Percakapan::class, 'id', 'conversation_id');
    }

    /**
     * Get the Customer associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'send_id');
    }

    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'send_id');
    }

    /**
     * Boot the model and add event listeners for creating, updating, and deleting events.
     */
    // public static function boot()
    // {
    //     parent::boot();

    //     /**
    //      * Dengarkan event creating dan catat jejak audit.
    //      *
    //      * @param  \Illuminate\Database\Eloquent\Model  $model
    //      * @return void
    //      */
    //     static::creating(function($model){
    //         self::logAudit('create', $model, null, $model->toArray());
    //     });

    //     /**
    //      * Dengarkan event updating dan catat jejak audit.
    //      *
    //      * @param  \Illuminate\Database\Eloquent\Model  $model
    //      * @return void
    //      */
    //     static::updating(function ($model){
    //         self::logAudit('update', $model, $model->getOriginal(), $model->getDirty());
    //     });

    //     /**
    //      * Dengarkan event deleting dan catat jejak audit.
    //      *
    //      * @param  \Illuminate\Database\Eloquent\Model  $model
    //      * @return void
    //      */
    //     static::deleting(function($model){
    //         self::logAudit('delete', $model, $model->toArray(), null);
    //     });
    // }

    // /**
    //  * Catat jejak audit untuk aksi dan model yang diberikan.
    //  *
    //  * @param  string  $action
    //  * @param  \Illuminate\Database\Eloquent\Model  $model
    //  * @param  array|null  $before
    //  * @param  array|null  $after
    //  * @return void
    //  */
    // private static function logAudit($action, $model, $before, $after)
    // {
    //     $agent = new Agent();
    //     AuditTrails::create([
    //         'kd_user' => auth()->user()->kd_user ?? 0,
    //         'action' => $action,
    //         'model' => get_class($model),
    //         'before' => json_encode($before),
    //         'after' => json_encode($after),
    //         'ip_address' => request()->ip(),
    //         'browser' => $agent->browser(),
    //         'browser_version' => $agent->version($agent->browser()),
    //         'platform' => $agent->platform(),
    //         'platform_version' => $agent->version($agent->platform()),
    //         'device' => $agent->device(),
    //     ]);
    // }
}
