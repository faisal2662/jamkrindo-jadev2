<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class Solve extends Model
{
    protected $table = 'tb_solve';

    protected $primaryKey = 'id_solve';

    public $timestamps = false;

    protected $fillable = [
        'id_pengaduan',
        'id_pegawai',
        'keterangan_solve',
        'status_resolved',
        'solved_end',
        'created_by',
        'created_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
