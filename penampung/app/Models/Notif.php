<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 't_notif';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get the user associated with the Notif
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'kd_user');
    }
}
