<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customerChange extends Model
{
    use HasFactory;

    protected $table = 'tb_customer_changed';



    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    /**
     * Get the user associated with the UserChanged
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maker(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'kd_maker');
    }
    /**
     * Get the user associated with the UserChanged
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approve(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'kd_approve');
    }
    /**
     * Get the customer associated with the UserChanged
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'kd_customer');
    }


}
