<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\CustomResetPassword;

class User extends \Eloquent implements Authenticatable, CanResetPasswordContract
{
    use AuthenticableTrait;
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = 'm_users';
    protected $gurded = ['kd_user'];
    protected $primaryKey = 'kd_user';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wilayah(): HasOne
    {
        return $this->hasOne(Regional::class, 'id_kanwil', 'wilayah_perusahaan');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
   
    public function cabang(): HasOne
    {
        return $this->hasOne(Branch::class, 'id_cabang', 'id_branch');
    }
    public function kota(): HasOne
    {
        return $this->hasOne(City::class, 'kd_kota', 'primary_city');
    }
}
