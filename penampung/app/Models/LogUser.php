<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUser extends Model
{
    use HasFactory;

    protected $table = 't_log_user';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



}
