<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;


class Branch extends Model
{
    use HasFactory;


    protected $table = 'm_cabang';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    protected $guarded = ['id_cabang'];

    protected $primaryKey = 'id_cabang';
    // protected static function booted()
    // {
    //     static::creating(function ($product) {
    //         $latestUser = Branch::orderBy('id_cabang', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id_cabang + 1 : 1;
    //         $product->kd_cabang = 'cabang' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }

    /**
     * Get the Wilayah associated with the Branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Wilayah(): HasOne
    {
        return $this->hasOne(Regional::class, 'id_kanwil', 'kd_wilayah');
    }


    public function Kota(): HasOne
    {
        return $this->hasOne(City::class, 'kd_kota', 'kd_kota');
    }

    public function Provinsi(): HasOne
    {
        return $this->hasOne(Province::class, 'kd_provinsi', 'kd_provinsi');
    }

    /**
     * Get all of the comments for the Branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Customer(): HasMany
    {
        return $this->hasMany(Customer::class, 'kd_cabang', 'id_cabang');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function($model){
    //         self::logAudit('create',$model, null, $model->toArray());
    //     });

    //     static::updating(function ($model){
    //         self::logAudit('update', $model, $model->getOriginal(), $model->getDirty());

    //     });

    //     static::deleting(function($model){
    //         self::logAudit('delete', $model, $model->toArray(), null);
    //     });
    // }

    // private static function logAudit($action, $model, $before, $after){
    //     try {
    //         $agent = new Agent();

    //         AuditTrails::create([
    //             'kd_user'           => auth()->user()->kd_user ?? 0,
    //             'action'            => $action,
    //             'model'             => get_class($model),
    //             'before'            => json_encode($before),
    //             'after'             => json_encode($after),
    //             'ip_address'        => request()->ip(),
    //             'browser'           => $agent->browser(),
    //             'browser_version'   => $agent->version($agent->browser()),
    //             'platform'          => $agent->platform(),
    //             'platform_version'  => $agent->version($agent->platform()),
    //             'device'            => $agent->device(),
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log error jika terjadi masalah saat menyimpan audit trail
    //         \Log::error('Error saving audit trail: ' . $e->getMessage());
    //     }
    // }
}
