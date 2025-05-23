<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'm_berita';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    protected $primaryKey = 'id_berita';
}
