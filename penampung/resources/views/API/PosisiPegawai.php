<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class PosisiPegawai extends Model
{
    protected $table = 'tb_posisi_pegawai';

    protected $primaryKey = 'id_posisi_pegawai';

    public function Pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_posisi_pegawai');
    }
}
