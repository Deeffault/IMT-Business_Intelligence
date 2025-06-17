<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\RseScore;
use Illuminate\Database\Seeder;

class RseDataSeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'siren' => '552120222',
                'name' => 'Danone',
                'sector' => 'Agroalimentaire',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Groupe international de produits alimentaires',
                'website' => 'https://www.danone.com',
                'scores' => [
                    'environmental_score' => 85,
                    'social_score' => 82,
                    'governance_score' => 78,
                    'ethics_score' => 88,
                ],
            ],
            [
                'siren' => '542065479',
                'name' => 'Schneider Electric',
                'sector' => 'Industrie',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Spécialiste mondial de la gestion de l\'énergie',
                'website' => 'https://www.se.com',
                'scores' => [
                    'environmental_score' => 90,
                    'social_score' => 85,
                    'governance_score' => 83,
                    'ethics_score' => 87,
                ],
            ],
            [
                'siren' => '775665671',
                'name' => 'L\'Oréal',
                'sector' => 'Cosmétique',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Groupe de cosmétiques et de beauté',
                'website' => 'https://www.loreal.com',
                'scores' => [
                    'environmental_score' => 78,
                    'social_score' => 80,
                    'governance_score' => 85,
                    'ethics_score' => 82,
                ],
            ],
            [
                'siren' => '552032534',
                'name' => 'Carrefour',
                'sector' => 'Distribution',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Groupe de distribution alimentaire',
                'website' => 'https://www.carrefour.com',
                'scores' => [
                    'environmental_score' => 70,
                    'social_score' => 75,
                    'governance_score' => 72,
                    'ethics_score' => 68,
                ],
            ],
            [
                'siren' => '775671191',
                'name' => 'Renault',
                'sector' => 'Automobile',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Constructeur automobile français',
                'website' => 'https://www.renault.com',
                'scores' => [
                    'environmental_score' => 72,
                    'social_score' => 70,
                    'governance_score' => 68,
                    'ethics_score' => 65,
                ],
            ],
            [
                'siren' => '552081317',
                'name' => 'Michelin',
                'sector' => 'Automobile',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Fabricant de pneumatiques',
                'website' => 'https://www.michelin.com',
                'scores' => [
                    'environmental_score' => 82,
                    'social_score' => 78,
                    'governance_score' => 80,
                    'ethics_score' => 85,
                ],
            ],
            [
                'siren' => '775672272',
                'name' => 'Veolia',
                'sector' => 'Environnement',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Services à l\'environnement',
                'website' => 'https://www.veolia.com',
                'scores' => [
                    'environmental_score' => 95,
                    'social_score' => 80,
                    'governance_score' => 78,
                    'ethics_score' => 82,
                ],
            ],
            [
                'siren' => '552020570',
                'name' => 'Kering',
                'sector' => 'Luxe',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Groupe de luxe français',
                'website' => 'https://www.kering.com',
                'scores' => [
                    'environmental_score' => 88,
                    'social_score' => 85,
                    'governance_score' => 90,
                    'ethics_score' => 92,
                ],
            ],
            [
                'siren' => '775663788',
                'name' => 'Société Générale',
                'sector' => 'Banque',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Banque française',
                'website' => 'https://www.societegenerale.com',
                'scores' => [
                    'environmental_score' => 65,
                    'social_score' => 72,
                    'governance_score' => 85,
                    'ethics_score' => 78,
                ],
            ],
            [
                'siren' => '775676943',
                'name' => 'Bouygues',
                'sector' => 'BTP',
                'size' => 'large',
                'country' => 'France',
                'description' => 'Groupe de construction et télécoms',
                'website' => 'https://www.bouygues.com',
                'scores' => [
                    'environmental_score' => 68,
                    'social_score' => 70,
                    'governance_score' => 75,
                    'ethics_score' => 72,
                ],
            ],
        ];

        foreach ($companies as $companyData) {
            $scores = $companyData['scores'];
            unset($companyData['scores']);

            $company = Company::create($companyData);

            $globalScore = collect($scores)->average();
            $ratingLetter = $this->determineRatingLetter($globalScore);

            RseScore::create([
                'company_id' => $company->id,
                'environmental_score' => $scores['environmental_score'],
                'social_score' => $scores['social_score'],
                'governance_score' => $scores['governance_score'],
                'ethics_score' => $scores['ethics_score'],
                'global_score' => round($globalScore, 2),
                'rating_letter' => $ratingLetter,
                'detailed_metrics' => [
                    'co2_emissions' => fake()->numberBetween(1000, 50000),
                    'energy_consumption' => fake()->numberBetween(500, 10000),
                    'waste_production' => fake()->numberBetween(100, 5000),
                    'employee_count' => fake()->numberBetween(1000, 100000),
                    'gender_equality_index' => fake()->numberBetween(60, 100),
                    'certifications' => fake()->randomElements(['ISO 14001', 'ISO 26000', 'B-Corp', 'EMAS'], 2),
                ],
                'data_sources' => ['portail_rse', 'ademe', 'insee'],
                'last_updated' => now(),
                'data_quality_score' => fake()->numberBetween(70, 100),
            ]);
        }

        // Quelques PME/ETI
        $smallCompanies = [
            [
                'siren' => '123456789',
                'name' => 'EcoTech Solutions',
                'sector' => 'Technologie',
                'size' => 'medium',
                'scores' => [85, 80, 75, 88],
            ],
            [
                'siren' => '987654321',
                'name' => 'Bio & Local',
                'sector' => 'Agroalimentaire',
                'size' => 'small',
                'scores' => [92, 88, 70, 85],
            ],
            [
                'siren' => '456789123',
                'name' => 'GreenBuild',
                'sector' => 'BTP',
                'size' => 'medium',
                'scores' => [88, 82, 78, 80],
            ],
        ];

        foreach ($smallCompanies as $companyData) {
            $company = Company::create([
                'siren' => $companyData['siren'],
                'name' => $companyData['name'],
                'sector' => $companyData['sector'],
                'size' => $companyData['size'],
                'country' => 'France',
                'description' => fake()->sentence(),
                'website' => fake()->url(),
            ]);

            $scores = $companyData['scores'];
            $globalScore = collect($scores)->average();

            RseScore::create([
                'company_id' => $company->id,
                'environmental_score' => $scores[0],
                'social_score' => $scores[1],
                'governance_score' => $scores[2],
                'ethics_score' => $scores[3],
                'global_score' => round($globalScore, 2),
                'rating_letter' => $this->determineRatingLetter($globalScore),
                'detailed_metrics' => [
                    'co2_emissions' => fake()->numberBetween(10, 1000),
                    'energy_consumption' => fake()->numberBetween(50, 500),
                    'waste_production' => fake()->numberBetween(5, 100),
                    'employee_count' => fake()->numberBetween(10, 500),
                    'gender_equality_index' => fake()->numberBetween(70, 100),
                    'certifications' => fake()->randomElements(['ISO 14001', 'ISO 26000', 'B-Corp'], 1),
                ],
                'data_sources' => ['portail_rse', 'insee'],
                'last_updated' => now(),
                'data_quality_score' => fake()->numberBetween(60, 90),
            ]);
        }
    }

    private function determineRatingLetter(float $score): string
    {
        return match (true) {
            $score >= 90 => 'A+',
            $score >= 80 => 'A',
            $score >= 70 => 'B',
            $score >= 60 => 'C',
            $score >= 50 => 'D',
            default => 'E'
        };
    }
}
