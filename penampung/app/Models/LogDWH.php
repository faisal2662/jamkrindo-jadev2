<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDWH extends Model
{
    use HasFactory;

    protected $table = 'dwh_audit_trails';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



}
