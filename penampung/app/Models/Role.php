<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $table = "t_role";

    protected $primaryKey = "id_role";

    public $timestamps = false;

    public $increment = false;

    protected $fillable = [
        'id_role',
        'id_account',
        'id_menu',
        'can_access',
        'can_update',
        'can_delete',
        'can_create',
        'can_approve'
    ];
}
