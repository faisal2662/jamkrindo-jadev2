<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;

class Customer extends Authenticatable
{
    // use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'm_customer';

    protected $guarded = ['kd_customer'];

    protected $hidden = [
        'password_customer'
    ];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    protected $primaryKey = 'kd_customer';
    // protected static function booted()
    // {
    //     static::creating(function ($customer) {
    //         $latestUser = Customer::orderBy('id_customer', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id_customer + 1 : 1;
    //         $customer->kd_customer = 'customer' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }

    /**
     * Get the cabang associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id_cabang', 'kd_cabang');
    }

        /**
     * Get the cabang associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Province(): HasOne
    {
        return $this->hasOne(Province::class, 'kd_provinsi', 'company_province');
    }
    /**
     * Get the cabang associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function City(): HasOne
    {
        return $this->hasOne(City::class, 'nm_kota', 'company_city');
    }


    /**
     * Get all of the Business for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Business(): HasMany
    {
        return $this->hasMany(
            Business::class,
            'kd_customer',
            'kd_customer'
        );
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
