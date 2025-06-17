<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\RseScore;
use App\Services\RseDataService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RseDashboardController extends Controller
{
    public function __construct(
        protected RseDataService $rseDataService
    ) {}

    public function index(): Response
    {
        $stats = [
            'total_companies' => Company::count(),
            'avg_global_score' => RseScore::avg('global_score') ?? 0,
            'top_performers' => Company::with('rseScore')
                ->whereHas('rseScore', fn ($q) => $q->where('global_score', '>=', 80))
                ->count(),
            'need_improvement' => Company::with('rseScore')
                ->whereHas('rseScore', fn ($q) => $q->where('global_score', '<', 60))
                ->count(),
        ];

        $topCompanies = Company::with('rseScore')
            ->whereHas('rseScore')
            ->get()
            ->sortByDesc('rseScore.global_score')
            ->take(10)
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'sector' => $company->sector,
                    'global_score' => $company->rseScore->global_score,
                    'rating_letter' => $company->rseScore->rating_letter,
                ];
            });

        $scoreDistribution = RseScore::selectRaw('
            CASE 
                WHEN global_score >= 80 THEN "Excellent (80-100)"
                WHEN global_score >= 60 THEN "Bon (60-79)"
                WHEN global_score >= 40 THEN "Moyen (40-59)"
                ELSE "Faible (0-39)"
            END as category,
            COUNT(*) as count
        ')
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['category'] => $item['count']];
            });

        $sectorPerformance = Company::with('rseScore')
            ->whereHas('rseScore')
            ->get()
            ->groupBy('sector')
            ->map(function ($companies, $sector) {
                return [
                    'sector' => $sector,
                    'avg_score' => $companies->avg('rseScore.global_score'),
                    'company_count' => $companies->count(),
                ];
            })
            ->values();

        return Inertia::render('RseDashboard', [
            'stats' => $stats,
            'topCompanies' => $topCompanies,
            'scoreDistribution' => $scoreDistribution,
            'sectorPerformance' => $sectorPerformance,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $sector = $request->get('sector');
        $minScore = $request->get('min_score');
        $maxScore = $request->get('max_score');

        $companies = Company::with('rseScore')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('siren', 'like', "%{$query}%");
            })
            ->when($sector, fn ($q) => $q->where('sector', $sector))
            ->when($minScore || $maxScore, function ($q) use ($minScore, $maxScore) {
                $q->byScore($minScore, $maxScore);
            })
            ->whereHas('rseScore')
            ->paginate(20);

        return response()->json($companies);
    }

    public function show(Company $company): Response
    {
        $company->load('rseScore', 'reports');

        // Récupération des entreprises similaires (même secteur)
        $similarCompanies = Company::with('rseScore')
            ->where('sector', $company->sector)
            ->where('id', '!=', $company->id)
            ->whereHas('rseScore')
            ->limit(5)
            ->get();

        return Inertia::render('CompanyDetail', [
            'company' => $company,
            'similarCompanies' => $similarCompanies,
        ]);
    }

    public function compare(Request $request): Response
    {
        $companyIds = $request->get('companies', []);

        $companies = Company::with('rseScore')
            ->whereIn('id', $companyIds)
            ->whereHas('rseScore')
            ->get();

        return Inertia::render('CompanyComparison', [
            'companies' => $companies,
        ]);
    }

    public function refreshScore(Company $company)
    {
        try {
            $score = $this->rseDataService->updateCompanyScore($company);

            return response()->json([
                'success' => true,
                'message' => 'Score mis à jour avec succès',
                'score' => $score,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du score',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
