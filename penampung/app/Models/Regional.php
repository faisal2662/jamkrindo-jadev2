<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;

class Regional extends Model
{
    use HasFactory;

    protected $table = 'm_wilayah';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    protected $guarded = ['id_kanwil'];

    protected $primaryKey = 'id_kanwil';
    // protected static function booted()
    // {
    //     static::creating(function ($product) {
    //         $latestUser = Regional::orderBy('id_kanwil', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id_kanwil + 1 : 1;
    //         $product->kd_wilayah = 'region' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }

    /**
     * Get the user associated with the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Provinsi(): HasOne
    {
        return $this->hasOne(Province::class, 'kd_provinsi', 'kd_provinsi');
    }

    /**
     * Get the City associated with the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Kota(): HasOne
    {
        return $this->hasOne(City::class, 'kd_kota', 'kd_kota');
    }

    /**
     * Get all of the Branch for the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Branch(): HasMany
    {
        return $this->hasMany(Branch::class, 'kd_wilayah', 'id_kanwil');
    }

    /**
     * Get all of the user for the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'wilayah_perusahaan', 'id_kanwil');
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
    //         'kd_user' => auth()->user()->kd_user ,
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
