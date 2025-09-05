<?php

namespace App\Models\Auditing;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Auditable trait for models that want to be audited. Data is stored in the audit_logs table.
 */
trait Auditable
{
    /**
     * Registers event hooks for the model so we can store audit logs for each event.
     */
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->audit('created', $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (! empty($changes)) {
                $model->audit('updated', $changes, $model->getOriginal());
            }
        });

        static::deleted(function ($model) {
            $model->audit('deleted', null, $model->getAttributes());
        });
    }

    /**
     * Records an audit log for the specified event on the model.
     */
    protected function audit(string $event, ?array $new = null, ?array $old = null)
    {
        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'event' => $event,
            'old_values' => $old,
            'new_values' => $new,
            'user_id' => Auth::id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }

    /**
     * The one to many relationship to fetch associated audit logs.
     */
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
