<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'tb_kontak';

    protected $primaryKey = 'id_kontak';

    public $timestamps = false;

    protected $fillable = [
        'created_pengaduan',
        'id_pengaduan',
        'kode_pengaduan',
        'nama_pengaduan',
        'dari_kontak',
        'kepada_kontak',
        'role_kontak',
        'keterangan_kontak',
        'tgl_kontak',
        'delete_kontak'
    ];

    protected $casts = [
        'tgl_kontak' => 'datetime'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'room_chat');
    }

    public function employee()
    {
        return $this->belongsTo(Pegawai::class, 'created_pengaduan');
    }

    public function complaint()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
    }
}
