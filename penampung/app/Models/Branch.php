<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}