<?php

namespace App\Models\Auditing;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Stores a log of all model changes.
 */
class AuditLog extends Model
{
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'event',
        'old_values',
        'new_values',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    protected $appends = [
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auditable()
    {
        return $this->morphTo();
    }

    public function getDescriptionAttribute(): string
    {
        return match ($this->event) {
            'created' => 'Created by ' . ($this->user?->name ?? 'Unknown'),
            'deleted' => 'Deleted by ' . ($this->user?->name ?? 'Unknown'),
            'updated' => 'Updated by ' . ($this->user?->name ?? 'Unknown'),
        };
    }
}
