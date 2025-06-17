<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $company_id
 * @property string|null $environmental_score
 * @property string|null $social_score
 * @property string|null $governance_score
 * @property string|null $ethics_score
 * @property string $global_score
 * @property string|null $rating_letter
 * @property array<array-key, mixed>|null $detailed_metrics
 * @property array<array-key, mixed>|null $data_sources
 * @property \Illuminate\Support\Carbon $last_updated
 * @property int $data_quality_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read string $rating_color
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereDataQualityScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereDataSources($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereDetailedMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereEnvironmentalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereEthicsScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereGlobalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereGovernanceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereLastUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereRatingLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereSocialScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RseScore whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class RseScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'environmental_score',
        'social_score',
        'governance_score',
        'ethics_score',
        'global_score',
        'rating_letter',
        'detailed_metrics',
        'data_sources',
        'last_updated',
        'data_quality_score',
    ];

    protected $casts = [
        'detailed_metrics' => 'array',
        'data_sources' => 'array',
        'last_updated' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function calculateGlobalScore(): float
    {
        $scores = collect([
            $this->environmental_score,
            $this->social_score,
            $this->governance_score,
            $this->ethics_score,
        ])->filter()->values();

        if ($scores->isEmpty()) {
            return 0;
        }

        return round($scores->average(), 2);
    }

    public function determineRatingLetter(): string
    {
        $score = $this->global_score;

        return match (true) {
            $score >= 90 => 'A+',
            $score >= 80 => 'A',
            $score >= 70 => 'B',
            $score >= 60 => 'C',
            $score >= 50 => 'D',
            default => 'E'
        };
    }

    public function getRatingColorAttribute(): string
    {
        return match ($this->rating_letter) {
            'A+' => 'text-green-600',
            'A' => 'text-green-500',
            'B' => 'text-yellow-500',
            'C' => 'text-orange-500',
            'D' => 'text-red-500',
            'E' => 'text-red-600',
            default => 'text-gray-500'
        };
    }

    public function getScoresByCategory(): array
    {
        return [
            'Environnement' => $this->environmental_score,
            'Social' => $this->social_score,
            'Gouvernance' => $this->governance_score,
            'Éthique' => $this->ethics_score,
        ];
    }
}
