<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditTrails extends Model
{
    use HasFactory;

    protected $table = 't_audit_trails';

    protected $fillable = ['kd_user','action', 'model', 'before', 'after', 'ip_address', 'browser', 'platform', 'platform_version', 'device', 'created_date', 'created_by', 'updated_date', 'updated_by', 'deleted_date', 'deleted_by'];

    protected $primay_key= 'id_audit_trails';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get the user associated with the AuditTrails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'kd_user', 'kd_user');
    }

}
 