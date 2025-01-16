<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percakapan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 't_percakapan';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    /**
     * Get all of the comments for the Percakapan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    //public function Message(): HasMany
    //{
    //    return $this->hasMany(Message::class, 'id', 'conversation_id');
    //}

    /**
     * Get the Customer associated with the Percakapan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'kd_customer', 'kd_customer');
    }
    
    /**
     * Get the Branc associated with the Percakapan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id_cabang', 'kd_cabang');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id', 'id')->latestOfMany();
    }

    public function Message(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }
public function User(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'receive_id');
    }
  
}