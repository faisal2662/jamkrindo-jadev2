<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KckJamnation extends Model
{
    use HasFactory;

    protected $table = 'm_kck_jamnation';

    protected $guarded = ['id'];

    protected $primaryKey = 'id';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
