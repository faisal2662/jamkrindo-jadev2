<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KancaJamnation extends Model
{
    use HasFactory;

    protected $table = 'm_kanca_jamnation';

    protected $guarded = ['id'];

    protected $primaryKey = 'id';
}
