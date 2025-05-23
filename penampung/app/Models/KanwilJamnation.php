<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Traits\LogSystemTrait;

class KanwilJamnation extends Model
{
    // use LogSystemTrait;
    use HasFactory;

    protected $table = 'm_kanwil_jamnation'; 

    protected $guarded = ['id'];

    // protected $primaryKey = 'id';

    // protected $fillable = [
    //     'id',
    //     'id_kanwil',
    //     'kode_uker',
    //     'nama_uker',
    //     'kelas_uker',
    //     'latitude',
    //     'longitude',
    //     'created_by',
    //     'created_date',
    //     'is_deleted'
    // ];
}
