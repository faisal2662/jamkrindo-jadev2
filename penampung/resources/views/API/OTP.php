<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'tb_otps';

    protected $guarded = ['id_otps'];
    
    protected $primaryKey = 'id_otps';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    public function employee()
    {
        return $this->hasOne(Pegawai::class, 'id_pegawai');
    }

}
