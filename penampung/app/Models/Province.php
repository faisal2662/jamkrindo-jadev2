<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    protected $table = 'm_provinsi';

    protected $guarded = ['kd_provinsi'];

    protected $primaryKey = 'kd_provinsi';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    // }

    /**
     * Get all of the Regional for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Regional(): HasMany
    {
        return $this->hasMany(Regional::class, 'kd_provinsi', 'kd_provinsi');
    }

    /**
     * Get all of the City for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function City(): HasMany
    {
        return $this->hasMany(City::class, 'kd_provinsi', 'kd_provinsi');
    }
}