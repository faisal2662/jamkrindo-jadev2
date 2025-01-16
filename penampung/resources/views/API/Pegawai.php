<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    protected $table = 'tb_pegawai';

    protected $primaryKey = 'id_pegawai';

    public $timestamps = false;

    protected $fillable = [
        'kantor_pegawai',
        'id_bagian_kantor_pusat',
        'id_bagian_kantor_cabang',
        'id_bagian_kantor_wilayah',
        'status_pegawai',
        'sebagai_pegawai',
        'email',
        'id_posisi_pegawai',
        'employee_name',
        'employee_status',
        'primary_address',
        'gender',
        'empoyee_id',
        'birthday',
        'primary_phone',
        'primary_city',
        'company_code',
        'management_code',
        'management_name',
        'division_code',
        'division_name',
        'department_code',
        'department_name',
        'sub_department_code',
        'sub_department_name',
        'section_code',
        'section_name',
        'sub_section_code',
        'position_code',
        'position_name',
        'grade_code',
        'functional_code',
        'functional_name',
        'functional_code_atasan_satu',
        'functional_name_atasan_satu',
        'npp_atasan_satu',
        'name_atasan_satu',
        'functional_code_atasan_dua',
        'functional_name_atasan_dua',
        'npp_atasan_dua',
        'name_atasan_dua',
        'branch_code',
        'branch_name',
        'password',
        'foto_pegawai',
        'status_data',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by',
        'delete_pegawai'
    ];

    protected $hidden = [
        'password_pegawai'
    ];

    public function headOfficeSection()
    {
        return $this->belongsTo(BagianKantorPusat::class, 'id_bagian_kantor_pusat');
    }

    public function regionalOfficeSection()
    {
        return $this->belongsTo(BagianKantorWilayah::class, 'id_bagian_kantor_wilayah');
    }

    public function branchOfficeSection()
    {
        return $this->belongsTo(BagianKantorCabang::class, 'id_bagian_kantor_cabang');
    }

    public function headOffice()
    {
        return $this->belongsTo(KantorPusat::class, 'multi_pegawai', 'id_kantor_pusat');
    }

    public function regionalOffice()
    {
        return $this->belongsTo(KantorWilayah::class, 'multi_pegawai', 'id_kantor_wilayah');
    }

    public function branchOffice()
    {
        return $this->belongsTo(KantorCabang::class, 'multi_pegawai', 'id_kantor_cabang');
    }

    public function notifications()
    {
        return $this->hasMany(Notifikasi::class, 'id_pegawai');
    }

    public function position()
    {
        return $this->belongsTo(PosisiPegawai::class, 'id_posisi_pegawai');
    }
}
