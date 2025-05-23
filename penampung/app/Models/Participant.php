<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $table = 't_partisipasi';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get all of the Percakapan for the Pacticipant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Percakapan(): HasMany
    {
        return $this->hasMany(Percakapan::class, 'id', 'conversation_id');
    }
}