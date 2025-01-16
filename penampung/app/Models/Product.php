<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $table = 'm_produk';

    protected $guarded = ['kd_produk'];

    protected $primaryKey = 'kd_produk';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



    /**
     * Get the user associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function CategoryProduct(): HasOne
    {
        return $this->hasOne(CategoryProduct::class, 'kd_kategori_produk', 'kd_kategori_produk');
    }


    // protected static function booted()
    // {
    //     static::creating(function ($product) {
    //         $latestUser = Product::orderBy('id', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id + 1 : 1;
    //         $product->kd_produk = 'product' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }

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
