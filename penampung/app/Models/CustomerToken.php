<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerToken extends Model
{
    public $timestamps = false;
    protected $table = 'customer_token';

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(CustomerToken::class);
    }
}
