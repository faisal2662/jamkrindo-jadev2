<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;

    protected $table = 'm_data_usaha';

    protected $guarded = ['kd_usaha'];
    protected $primaryKey = 'kd_usaha';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



    // protected static function booted()
    // {
    //     static::creating(function ($usaha) {
    //         $latestUser = Business::orderBy('id_usaha', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id_usaha + 1 : 1;
    //         $usaha->kd_usaha = 'business' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }


    /**
     * Get the Customer associated with the Business
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'kd_customer');
    }

  /**
     * Get the City associated with the Business
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kota(): HasOne
    {
        return $this->hasOne(City::class, 'kd_kota', 'kota_usaha');
    }

    /**
     * Get the provinsi associated with the Business
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provinsi(): HasOne
    {
        return $this->hasOne(Province::class, 'kd_provinsi', 'provinsi_usaha');
    }
}