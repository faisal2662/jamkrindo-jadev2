<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;
use App\Models\AuditTrails;

class Smtp extends Model
{
    use HasFactory;
    protected $guarded = ['id_smtp'];

    protected $primaryKey = 'id_smtp';

    protected $table = 'm_smtp';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
} 