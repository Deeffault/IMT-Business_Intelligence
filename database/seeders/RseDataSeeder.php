<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\RseScore;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RseDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Note: All CSR data is generated for plausible, fictional scenarios.
     * It does not represent the actual performance of the real companies listed.
     */
    public function run(): void
    {
        // Clean up previous data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        RseScore::truncate();
        Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $companies = [
            // Technology
            ['name' => 'Apple Inc.', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Microsoft Corporation', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Alphabet Inc.', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Amazon.com, Inc.', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Meta Platforms, Inc.', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'NVIDIA Corporation', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'SAP SE', 'sector' => 'Technology', 'size' => 'large', 'country' => 'Germany'],
            ['name' => 'Salesforce, Inc.', 'sector' => 'Technology', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Innovatech Solutions', 'sector' => 'Technology', 'size' => 'medium', 'country' => 'Canada'],
            ['name' => 'CyberSecure Ltd.', 'sector' => 'Technology', 'size' => 'small', 'country' => 'UK'],

            // Financials
            ['name' => 'JPMorgan Chase & Co.', 'sector' => 'Finance', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'BNP Paribas', 'sector' => 'Finance', 'size' => 'large', 'country' => 'France'],
            ['name' => 'HSBC Holdings plc', 'sector' => 'Finance', 'size' => 'large', 'country' => 'UK'],
            ['name' => 'Allianz SE', 'sector' => 'Finance', 'size' => 'large', 'country' => 'Germany'],
            ['name' => 'Royal Bank of Canada', 'sector' => 'Finance', 'size' => 'large', 'country' => 'Canada'],
            ['name' => 'GreenLeaf Investments', 'sector' => 'Finance', 'size' => 'medium', 'country' => 'Switzerland'],
            ['name' => 'Capital Trust Bank', 'sector' => 'Finance', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'SecureWealth Partners', 'sector' => 'Finance', 'size' => 'small', 'country' => 'Singapore'],
            ['name' => 'AXA Group', 'sector' => 'Finance', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Goldman Sachs Group, Inc.', 'sector' => 'Finance', 'size' => 'large', 'country' => 'USA'],

            // Healthcare
            ['name' => 'Johnson & Johnson', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Roche Holding AG', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'Switzerland'],
            ['name' => 'Pfizer Inc.', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Novartis AG', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'Switzerland'],
            ['name' => 'Sanofi S.A.', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Medtronic plc', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'Ireland'],
            ['name' => 'Vitalis Health', 'sector' => 'Healthcare', 'size' => 'medium', 'country' => 'Germany'],
            ['name' => 'BioGenex Labs', 'sector' => 'Healthcare', 'size' => 'small', 'country' => 'USA'],
            ['name' => 'UnitedHealth Group', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'AstraZeneca PLC', 'sector' => 'Healthcare', 'size' => 'large', 'country' => 'UK'],

            // Consumer Goods & Retail
            ['name' => 'Procter & Gamble Co.', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Nestlé S.A.', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'Switzerland'],
            ['name' => 'LVMH Moët Hennessy Louis Vuitton', 'sector' => 'Luxury', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Walmart Inc.', 'sector' => 'Retail', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'The Coca-Cola Company', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Unilever PLC', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'UK'],
            ['name' => 'Inditex (Zara)', 'sector' => 'Retail', 'size' => 'large', 'country' => 'Spain'],
            ['name' => 'Patagonia, Inc.', 'sector' => 'Retail', 'size' => 'medium', 'country' => 'USA'],
            ['name' => 'EcoWares', 'sector' => 'Retail', 'size' => 'small', 'country' => 'Netherlands'],
            ['name' => 'FreshFarm Organics', 'sector' => 'Consumer Goods', 'size' => 'medium', 'country' => 'Canada'],

            // Industrials & Automotive
            ['name' => 'Siemens AG', 'sector' => 'Industrials', 'size' => 'large', 'country' => 'Germany'],
            ['name' => 'Schneider Electric', 'sector' => 'Industrials', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Toyota Motor Corporation', 'sector' => 'Automotive', 'size' => 'large', 'country' => 'Japan'],
            ['name' => 'Volkswagen Group', 'sector' => 'Automotive', 'size' => 'large', 'country' => 'Germany'],
            ['name' => 'Tesla, Inc.', 'sector' => 'Automotive', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'General Electric Company', 'sector' => 'Industrials', 'size' => 'large', 'country' => 'USA'],
            ['name' => '3M Company', 'sector' => 'Industrials', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'GreenBuild Corp', 'sector' => 'Construction', 'size' => 'medium', 'country' => 'USA'],
            ['name' => 'AeroDynamics', 'sector' => 'Aerospace', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Precision Motors', 'sector' => 'Automotive', 'size' => 'small', 'country' => 'Italy'],

            // Energy & Utilities
            ['name' => 'Exxon Mobil Corporation', 'sector' => 'Energy', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Shell plc', 'sector' => 'Energy', 'size' => 'large', 'country' => 'UK'],
            ['name' => 'TotalEnergies SE', 'sector' => 'Energy', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Ørsted A/S', 'sector' => 'Renewable Energy', 'size' => 'large', 'country' => 'Denmark'],
            ['name' => 'NextEra Energy, Inc.', 'sector' => 'Utilities', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Iberdrola, S.A.', 'sector' => 'Utilities', 'size' => 'large', 'country' => 'Spain'],
            ['name' => 'Solaris Power', 'sector' => 'Renewable Energy', 'size' => 'medium', 'country' => 'Germany'],
            ['name' => 'GeoThermal Dynamics', 'sector' => 'Energy', 'size' => 'medium', 'country' => 'Iceland'],
            ['name' => 'AquaPure Utilities', 'sector' => 'Utilities', 'size' => 'large', 'country' => 'Canada'],
            ['name' => 'WindVerse Energy', 'sector' => 'Renewable Energy', 'size' => 'small', 'country' => 'USA'],

            // More diverse companies
            ['name' => 'The Walt Disney Company', 'sector' => 'Media', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Comcast Corporation', 'sector' => 'Telecommunications', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Accenture plc', 'sector' => 'Consulting', 'size' => 'large', 'country' => 'Ireland'],
            ['name' => 'Nike, Inc.', 'sector' => 'Apparel', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Starbucks Corporation', 'sector' => 'Food & Beverage', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Caterpillar Inc.', 'sector' => 'Heavy Equipment', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'FedEx Corporation', 'sector' => 'Logistics', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'Sony Group Corporation', 'sector' => 'Electronics', 'size' => 'large', 'country' => 'Japan'],
            ['name' => 'Samsung Electronics Co., Ltd.', 'sector' => 'Electronics', 'size' => 'large', 'country' => 'South Korea'],
            ['name' => 'Global Logistics Co.', 'sector' => 'Logistics', 'size' => 'medium', 'country' => 'Germany'],
            ['name' => 'Artisan Coffee Roasters', 'sector' => 'Food & Beverage', 'size' => 'small', 'country' => 'USA'],
            ['name' => 'Creative Minds Agency', 'sector' => 'Media', 'size' => 'medium', 'country' => 'UK'],
            ['name' => 'BuildRight Construction', 'sector' => 'Construction', 'size' => 'large', 'country' => 'Canada'],
            ['name' => 'AirGo', 'sector' => 'Aerospace', 'size' => 'medium', 'country' => 'USA'],
            ['name' => 'Pinnacle Consulting', 'sector' => 'Consulting', 'size' => 'small', 'country' => 'Australia'],
            ['name' => 'Momentum Apparel', 'sector' => 'Apparel', 'size' => 'medium', 'country' => 'USA'],
            ['name' => 'ByteStream Telecom', 'sector' => 'Telecommunications', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'HeavyLift Equipment', 'sector' => 'Heavy Equipment', 'size' => 'medium', 'country' => 'Germany'],
            ['name' => 'FutureGadget Labs', 'sector' => 'Electronics', 'size' => 'small', 'country' => 'Japan'],
            ['name' => 'Terra Firma Real Estate', 'sector' => 'Real Estate', 'size' => 'large', 'country' => 'USA'],
            ['name' => 'UrbanScape Properties', 'sector' => 'Real Estate', 'size' => 'medium', 'country' => 'UK'],
            ['name' => 'Vertex Pharmaceuticals', 'sector' => 'Healthcare', 'size' => 'medium', 'country' => 'USA'],
            ['name' => 'Danone S.A.', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'France'],
            ['name' => 'L\'Oréal S.A.', 'sector' => 'Consumer Goods', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Michelin', 'sector' => 'Automotive', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Veolia', 'sector' => 'Utilities', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Kering S.A.', 'sector' => 'Luxury', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Société Générale', 'sector' => 'Finance', 'size' => 'large', 'country' => 'France'],
            ['name' => 'Bouygues S.A.', 'sector' => 'Construction', 'size' => 'large', 'country' => 'France'],
        ];

        foreach ($companies as $companyData) {
            $company = Company::create([
                'siren' => fake()->unique()->numerify('#########'),
                'name' => $companyData['name'],
                'sector' => $companyData['sector'],
                'size' => $companyData['size'],
                'country' => $companyData['country'],
                'description' => fake()->sentence(),
                'website' => 'https://www.'.fake()->domainName(),
            ]);

            $scores = $this->generateScoresForSector($companyData['sector'], $companyData['name']);
            $globalScore = collect($scores)->average();

            RseScore::create([
                'company_id' => $company->id,
                'environmental_score' => $scores['environmental_score'],
                'social_score' => $scores['social_score'],
                'governance_score' => $scores['governance_score'],
                'ethics_score' => $scores['ethics_score'],
                'global_score' => round($globalScore, 2),
                'rating_letter' => $this->determineRatingLetter($globalScore),
                'detailed_metrics' => $this->generateDetailedMetrics($companyData['size']),
                'data_sources' => ['portail_rse', 'ademe', 'insee', 'self-declared'],
                'last_updated' => now()->subDays(fake()->numberBetween(1, 365)),
                'data_quality_score' => fake()->numberBetween(60, 98),
            ]);
        }
    }

    private function generateScoresForSector(string $sector, string $name): array
    {
        // Base scores with some randomness
        $baseScores = [
            'environmental_score' => fake()->numberBetween(50, 85),
            'social_score' => fake()->numberBetween(55, 90),
            'governance_score' => fake()->numberBetween(60, 95),
            'ethics_score' => fake()->numberBetween(60, 95),
        ];

        // Adjust scores based on sector stereotypes for realism
        switch ($sector) {
            case 'Renewable Energy':
                $baseScores['environmental_score'] = fake()->numberBetween(80, 98);
                break;
            case 'Energy': // Fossil fuels
                $baseScores['environmental_score'] = fake()->numberBetween(30, 65);
                break;
            case 'Technology':
                $baseScores['social_score'] = fake()->numberBetween(50, 80); // Data privacy concerns
                $baseScores['governance_score'] = fake()->numberBetween(75, 95);
                break;
            case 'Finance':
            case 'Consulting':
                $baseScores['environmental_score'] = fake()->numberBetween(65, 90);
                $baseScores['governance_score'] = fake()->numberBetween(70, 95);
                $baseScores['ethics_score'] = fake()->numberBetween(70, 95);
                break;
            case 'Healthcare':
                $baseScores['social_score'] = fake()->numberBetween(75, 95);
                $baseScores['ethics_score'] = fake()->numberBetween(80, 98); // High ethical standards
                break;
            case 'Apparel':
            case 'Retail':
                $baseScores['social_score'] = fake()->numberBetween(45, 75); // Supply chain issues
                break;
            case 'Construction':
            case 'Heavy Equipment':
                $baseScores['environmental_score'] = fake()->numberBetween(40, 70);
                $baseScores['social_score'] = fake()->numberBetween(60, 85); // Worker safety
                break;
        }

        // Special adjustments for companies known for CSR
        if (str_contains($name, 'Patagonia')) {
            return [
                'environmental_score' => fake()->numberBetween(92, 98),
                'social_score' => fake()->numberBetween(90, 95),
                'governance_score' => fake()->numberBetween(85, 92),
                'ethics_score' => fake()->numberBetween(90, 96),
            ];
        }
        if (str_contains($name, 'Schneider Electric') || str_contains($name, 'Ørsted')) {
            return [
                'environmental_score' => fake()->numberBetween(90, 96),
                'social_score' => fake()->numberBetween(85, 92),
                'governance_score' => fake()->numberBetween(88, 94),
                'ethics_score' => fake()->numberBetween(85, 93),
            ];
        }

        return $baseScores;
    }

    private function generateDetailedMetrics(string $size): array
    {
        $metrics = [
            'small' => [
                'co2_emissions' => fake()->numberBetween(50, 500),
                'energy_consumption' => fake()->numberBetween(100, 1000),
                'waste_production' => fake()->numberBetween(10, 100),
                'employee_count' => fake()->numberBetween(10, 250),
                'gender_equality_index' => fake()->numberBetween(75, 100),
                'certifications' => fake()->randomElements(['ISO 14001', 'B-Corp'], fake()->numberBetween(0, 2)),
            ],
            'medium' => [
                'co2_emissions' => fake()->numberBetween(500, 10000),
                'energy_consumption' => fake()->numberBetween(1000, 20000),
                'waste_production' => fake()->numberBetween(100, 2000),
                'employee_count' => fake()->numberBetween(251, 5000),
                'gender_equality_index' => fake()->numberBetween(70, 95),
                'certifications' => fake()->randomElements(['ISO 14001', 'ISO 26000', 'B-Corp', 'SA8000'], fake()->numberBetween(1, 3)),
            ],
            'large' => [
                'co2_emissions' => fake()->numberBetween(10000, 500000),
                'energy_consumption' => fake()->numberBetween(20000, 1000000),
                'waste_production' => fake()->numberBetween(2000, 50000),
                'employee_count' => fake()->numberBetween(5001, 200000),
                'gender_equality_index' => fake()->numberBetween(60, 90),
                'certifications' => fake()->randomElements(['ISO 14001', 'ISO 26000', 'EMAS', 'SA8000', 'Fair Trade'], fake()->numberBetween(2, 4)),
            ],
        ];

        return $metrics[$size] ?? $metrics['medium'];
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
