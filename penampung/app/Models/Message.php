<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $table = 't_pesan';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';


    /**
     * Get the Chat associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Chat(): HasOne
    {
        return $this->hasOne(Percakapan::class, 'id', 'conversation_id');
    }

    /**
     * Get the Customer associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'send_id');
    }

    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'send_id');
    }
}