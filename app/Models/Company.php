<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $siren
 * @property string $name
 * @property string|null $sector
 * @property string|null $size
 * @property string $country
 * @property string|null $description
 * @property string|null $website
 * @property array<array-key, mixed>|null $contact_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $display_rank
 * @property-read string $formatted_size
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RseReport> $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\RseScore|null $rseScore
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RseScore> $rseScores
 * @property-read int|null $rse_scores_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company byScore($minScore = null, $maxScore = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company bySector($sector)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSiren($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 *
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'siren',
        'name',
        'sector',
        'size',
        'country',
        'description',
        'website',
        'contact_info',
    ];

    protected $casts = [
        'contact_info' => 'array',
    ];

    // Attributs dynamiques
    public $display_rank;

    public function rseScore(): HasOne
    {
        return $this->hasOne(RseScore::class)->latest('last_updated');
    }

    public function rseScores(): HasMany
    {
        return $this->hasMany(RseScore::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(RseReport::class);
    }

    public function getFormattedSizeAttribute(): string
    {
        return match ($this->size) {
            'micro' => 'Micro-entreprise',
            'small' => 'Petite entreprise',
            'medium' => 'Moyenne entreprise (ETI)',
            'large' => 'Grande entreprise',
            default => $this->size ?? 'Non défini'
        };
    }

    public function scopeByScore($query, $minScore = null, $maxScore = null)
    {
        return $query->whereHas('rseScore', function ($q) use ($minScore, $maxScore) {
            if ($minScore) {
                $q->where('global_score', '>=', $minScore);
            }
            if ($maxScore) {
                $q->where('global_score', '<=', $maxScore);
            }
        });
    }

    public function scopeBySector($query, $sector)
    {
        return $query->where('sector', $sector);
    }
}
