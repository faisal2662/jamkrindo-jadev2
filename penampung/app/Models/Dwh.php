<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dwh extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'dwh_spd';

    protected $guarded = ['id'];


    protected $primaryKey = 'id';
}