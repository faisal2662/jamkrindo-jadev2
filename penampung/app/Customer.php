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

class Customer extends Authenticatable
{
    // use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'm_customer';

    protected $guarded = ['id_customer'];

    protected $hidden = [
        'password_customer'
    ];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    protected $primaryKey = 'id_customer';
    protected static function booted()
    {
        static::creating(function ($customer) {
            $latestUser = Customer::orderBy('id_customer', 'desc')->first();
            $nextId = $latestUser ? $latestUser->id_customer + 1 : 1;
            $customer->kd_customer = 'customer' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Get the cabang associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'kd_cabang', 'kd_cabang');
    }

    /**
     * Get all of the Business for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Business(): HasMany
    {
        return $this->hasMany(
            Business::class,
            'kd_customer',
            'kd_customer'
        );
    }
}