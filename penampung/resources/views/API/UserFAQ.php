<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class UserFAQ extends Model
{
    protected $table = 'tb_user_faq';

    protected $primaryKey = 'id_faq';

    public $timestamps = false;

    protected $fillable = [
        'pertanyaan_faq',
        'kantor',
        'id_bagian',
        'nama_faq',
        'email_faq',
        'tgl_faq',
        'updated_by',
        'updated_date',
        'deleted_date',
        'deleted_by',
        'delete_faq'
    ];
}
