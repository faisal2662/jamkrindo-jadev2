<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpCustomer extends Model
{
    use HasFactory;

    protected $table = 't_otps_customer';

    protected $guarded = ['id_otps'];
    protected $primaryKey = 'id_otps';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get the pegawai associated with the OTP
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'customer_id');
    }
}
