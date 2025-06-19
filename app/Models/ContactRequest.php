<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'company_size',
        'sector',
        'current_score',
        'improvement_goals',
        'budget_range',
        'timeline',
        'message',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'current_score' => 'decimal:2',
    ];

    public function getCompanySizeLabel(): string
    {
        return match ($this->company_size) {
            'startup' => 'Startup (1-10 employés)',
            'small' => 'Petite entreprise (11-50 employés)',
            'medium' => 'Moyenne entreprise (51-250 employés)',
            'large' => 'Grande entreprise (250+ employés)',
            'micro' => 'Micro entreprise (< 10 employés)',
            default => (string) $this->company_size,
        };
    }

    public function getBudgetRangeLabel(): string
    {
        return match ($this->budget_range) {
            '5000-15000' => '5 000€ - 15 000€',
            '15000-50000' => '15 000€ - 50 000€',
            '50000-100000' => '50 000€ - 100 000€',
            '100000+' => '100 000€+',
            default => (string) $this->budget_range,
        };
    }

    public function getTimelineLabel(): string
    {
        return match ($this->timeline) {
            'immediate' => 'Immédiat (< 1 mois)',
            '1-3months' => '1-3 mois',
            '3-6months' => '3-6 mois',
            '6-12months' => '6-12 mois',
            default => (string) $this->timeline,
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'contacted' => 'Contacté',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'rejected' => 'Rejeté',
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByBudgetRange($query, $budgetRange)
    {
        return $query->where('budget_range', $budgetRange);
    }

    public function scopeByCompanySize($query, $size)
    {
        return $query->where('company_size', $size);
    }
}
