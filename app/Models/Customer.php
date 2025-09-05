<?php

namespace App\Models;

use App\Models\Auditing\Auditable;
use App\Models\Filterable\Filterable;
use App\Models\Filterable\FilterDefinition;
use App\Models\Filterable\FilterOperator;
use App\Models\Scopes\OwnedByAuthenticatedUser;
use App\Models\Sortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Auditable, Filterable, HasFactory, HashableId, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'organisation',
        'job_title',
        'date_of_birth',
        'notes',
        'user_id',
    ];

    protected $appends = [
        'formatted_phone',
        'name_slug',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OwnedByAuthenticatedUser);
        static::creating(fn ($model) => $model->user_id ??= Auth::id());
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function getFilterableFields(): array
    {
        return [
            new FilterDefinition('email', 'email', FilterOperator::Like),
            new FilterDefinition('job_title', 'job_title', FilterOperator::Like),
            new FilterDefinition('name', 'name', FilterOperator::Like),
            new FilterDefinition('organisation', 'organisation', FilterOperator::Like),
            new FilterDefinition('phone', 'phone', FilterOperator::Like),
            new FilterDefinition('search', ['email', 'job_title', 'name', 'organisation', 'phone'], FilterOperator::Like),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function allowedSortableFields(): array
    {
        return [
            'name',
            'email',
            'phone',
            'organisation',
            'job_title',
            'date_of_birth',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get the phone number with a leading plus.
     */
    public function getFormattedPhoneAttribute(): string
    {
        $phone = $this->attributes['phone'] ?? '';

        return str_starts_with($phone, '+') || empty($phone) ? $phone : '+' . $phone;
    }

    /**
     * Get the name slug.
     */
    public function getNameSlugAttribute(): ?string
    {
        return ! empty($this->attributes['name']) ? Str::slug($this->attributes['name']) : null;
    }
}
