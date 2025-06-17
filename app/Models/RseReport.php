<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property string $report_type
 * @property string $status
 * @property string $price
 * @property string $payment_status
 * @property array<array-key, mixed>|null $analysis_criteria
 * @property string|null $report_content
 * @property array<array-key, mixed>|null $recommendations
 * @property array<array-key, mixed>|null $improvement_areas
 * @property \Illuminate\Support\Carbon|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read string $formatted_price
 * @property-read string $status_badge_color
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport completed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport paid()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereAnalysisCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereImprovementAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereReportContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseReport whereUserId($value)
 *
 * @mixin \Eloquent
 */
class RseReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'report_type',
        'status',
        'price',
        'payment_status',
        'analysis_criteria',
        'report_content',
        'recommendations',
        'improvement_areas',
        'delivered_at',
    ];

    protected $casts = [
        'analysis_criteria' => 'array',
        'recommendations' => 'array',
        'improvement_areas' => 'array',
        'delivered_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format((float) $this->price, 2).' €';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
