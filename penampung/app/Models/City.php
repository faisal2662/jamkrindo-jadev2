<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;


    protected $table = 'm_kota';

    protected $guarded = ['kd_kota'];
    protected $primaryKey = 'kd_kota';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    /**
     * Get all of the comments for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Regional(): HasMany
    {
        return $this->hasMany(Regional::class, 'kd_kota', 'kd_kota');
    }

    /**
     * Get the Provinsi associated with the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Provinsi(): HasOne
    {
        return $this->hasOne(Province::class, 'kd_provinsi', 'kd_provinsi');
    }
}