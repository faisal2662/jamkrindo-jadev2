<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}