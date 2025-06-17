<?php

namespace App\Services;

use App\Models\Company;
use App\Models\RseScore;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RseDataService
{
    protected array $dataSources = [
        'portail_rse' => 'https://portail-rse.beta.gouv.fr/api',
        'ademe' => 'https://data.ademe.fr/api',
        'insee' => 'https://api.insee.fr/api',
        'data_gouv' => 'https://www.data.gouv.fr/api/1',
    ];

    public function fetchCompanyData(string $siren): array
    {
        $data = [];

        // Récupération des données de base via l'API INSEE
        $inseeData = $this->fetchInseeData($siren);
        if ($inseeData) {
            $data['basic_info'] = $inseeData;
        }

        // Récupération des données RSE via le Portail RSE
        $rseData = $this->fetchPortailRseData($siren);
        if ($rseData) {
            $data['rse_info'] = $rseData;
        }

        // Récupération des données environnementales ADEME
        $ademeData = $this->fetchAdemeData($siren);
        if ($ademeData) {
            $data['environmental_info'] = $ademeData;
        }

        return $data;
    }

    protected function fetchInseeData(string $siren): ?array
    {
        try {
            $response = Http::timeout(10)->get($this->dataSources['insee']."/etablissements/{$siren}");

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning("Erreur lors de la récupération des données INSEE pour SIREN {$siren}: ".$e->getMessage());
        }

        return null;
    }

    protected function fetchPortailRseData(string $siren): ?array
    {
        try {
            // Simulation d'appel API - à adapter selon l'API réelle
            $response = Http::timeout(10)->get($this->dataSources['portail_rse']."/entreprises/{$siren}");

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning("Erreur lors de la récupération des données RSE pour SIREN {$siren}: ".$e->getMessage());
        }

        return null;
    }

    protected function fetchAdemeData(string $siren): ?array
    {
        try {
            // Simulation d'appel API - à adapter selon l'API réelle
            $response = Http::timeout(10)->get($this->dataSources['ademe'].'/bilans-carbone', [
                'siren' => $siren,
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning("Erreur lors de la récupération des données ADEME pour SIREN {$siren}: ".$e->getMessage());
        }

        return null;
    }

    public function calculateRseScore(array $rawData): array
    {
        $scores = [
            'environmental_score' => $this->calculateEnvironmentalScore($rawData),
            'social_score' => $this->calculateSocialScore($rawData),
            'governance_score' => $this->calculateGovernanceScore($rawData),
            'ethics_score' => $this->calculateEthicsScore($rawData),
        ];

        // Calcul du score global
        $validScores = array_filter($scores, fn ($score) => $score !== null);
        $globalScore = ! empty($validScores) ? array_sum($validScores) / count($validScores) : 0;

        $scores['global_score'] = round($globalScore, 2);
        $scores['detailed_metrics'] = $this->extractDetailedMetrics($rawData);
        $scores['data_sources'] = array_keys($rawData);
        $scores['data_quality_score'] = $this->calculateDataQuality($rawData);

        return $scores;
    }

    protected function calculateEnvironmentalScore(array $data): ?float
    {
        $score = 50; // Score de base

        // Bonus si bilan carbone disponible
        if (isset($data['environmental_info']['bilan_carbone'])) {
            $score += 20;
        }

        // Bonus si certification ISO 14001
        if (isset($data['rse_info']['certifications']) &&
            in_array('ISO 14001', $data['rse_info']['certifications'] ?? [])) {
            $score += 15;
        }

        // Bonus si énergies renouvelables
        if (isset($data['environmental_info']['energie_renouvelable']) &&
            $data['environmental_info']['energie_renouvelable'] > 50) {
            $score += 15;
        }

        return min($score, 100);
    }

    protected function calculateSocialScore(array $data): ?float
    {
        $score = 50; // Score de base

        // Bonus si index égalité professionnelle élevé
        if (isset($data['rse_info']['index_egalite']) &&
            $data['rse_info']['index_egalite'] > 75) {
            $score += 20;
        }

        // Bonus si formation continue
        if (isset($data['rse_info']['formation_continue']) &&
            $data['rse_info']['formation_continue'] === true) {
            $score += 15;
        }

        // Bonus si politique diversité
        if (isset($data['rse_info']['politique_diversite'])) {
            $score += 15;
        }

        return min($score, 100);
    }

    protected function calculateGovernanceScore(array $data): ?float
    {
        $score = 50; // Score de base

        // Bonus si transparence financière
        if (isset($data['basic_info']['publication_comptes']) &&
            $data['basic_info']['publication_comptes'] === true) {
            $score += 20;
        }

        // Bonus si certification qualité
        if (isset($data['rse_info']['certifications']) &&
            ! empty($data['rse_info']['certifications'])) {
            $score += 15;
        }

        return min($score, 100);
    }

    protected function calculateEthicsScore(array $data): ?float
    {
        $score = 50; // Score de base

        // Bonus si code éthique publié
        if (isset($data['rse_info']['code_ethique']) &&
            $data['rse_info']['code_ethique'] === true) {
            $score += 25;
        }

        // Bonus si politique anti-corruption
        if (isset($data['rse_info']['politique_anticorruption'])) {
            $score += 25;
        }

        return min($score, 100);
    }

    protected function extractDetailedMetrics(array $data): array
    {
        return [
            'co2_emissions' => $data['environmental_info']['co2_emissions'] ?? null,
            'energy_consumption' => $data['environmental_info']['energy_consumption'] ?? null,
            'waste_production' => $data['environmental_info']['waste_production'] ?? null,
            'employee_count' => $data['basic_info']['employee_count'] ?? null,
            'gender_equality_index' => $data['rse_info']['index_egalite'] ?? null,
            'certifications' => $data['rse_info']['certifications'] ?? [],
        ];
    }

    protected function calculateDataQuality(array $data): int
    {
        $totalSources = count($this->dataSources);
        $availableSources = count(array_keys($data));

        return (int) round(($availableSources / $totalSources) * 100);
    }

    public function updateCompanyScore(Company $company): RseScore
    {
        $rawData = $this->fetchCompanyData($company->siren);
        $scoreData = $this->calculateRseScore($rawData);

        $scoreData['company_id'] = $company->id;
        $scoreData['last_updated'] = now();

        $score = RseScore::updateOrCreate(
            ['company_id' => $company->id],
            $scoreData
        );

        // Calcul automatique du score global et de la note
        $score->global_score = (string) $score->calculateGlobalScore();
        $score->rating_letter = $score->determineRatingLetter();
        $score->save();

        return $score;
    }
}
