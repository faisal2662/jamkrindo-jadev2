<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class KategoriFAQ extends Model
{
    protected $table = 'tb_kategori_faq';

    protected $primaryKey = 'id_kategori_faq';

    public $timestamps = false;

    protected $fillable = [
        'nama_kategori_faq'
    ];

    public function faqs()
    {
        return $this->hasMany(FAQ::class, 'id_kategori_faq');
    }
}
