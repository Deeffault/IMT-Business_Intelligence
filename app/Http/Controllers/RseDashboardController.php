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

    public function index(Request $request): Response
    {
        $sortBy = $request->get('sort', 'global_score');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort parameters
        $allowedSortFields = ['name', 'sector', 'global_score', 'rating_letter'];
        $allowedSortOrders = ['asc', 'desc'];

        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'global_score';
        $sortOrder = in_array($sortOrder, $allowedSortOrders) ? $sortOrder : 'desc';

        // Only calculate stats if not a partial reload
        $stats = [];
        if (! $request->header('X-Inertia-Partial-Data') || in_array('stats', explode(',', $request->header('X-Inertia-Partial-Data')))) {
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
        }

        $topCompaniesQuery = Company::with('rseScore')
            ->whereHas('rseScore');

        // Apply sorting based on the field
        if ($sortBy === 'global_score' || $sortBy === 'rating_letter') {
            $topCompaniesQuery->join('rse_scores', 'companies.id', '=', 'rse_scores.company_id')
                ->orderBy("rse_scores.{$sortBy}", $sortOrder)
                ->select('companies.*');
        } else {
            $topCompaniesQuery->orderBy($sortBy, $sortOrder);
        }

        // Générer le classement global une fois pour toutes les companies avec un score
        $allRanked = Company::with('rseScore')
            ->whereHas('rseScore')
            ->get()
            ->sortByDesc(fn ($c) => $c->rseScore->global_score ?? 0)
            ->values();
        $rankMap = [];
        foreach ($allRanked as $idx => $company) {
            $rankMap[$company->id] = $idx + 1;
        }

        $topCompanies = $topCompaniesQuery
            ->take(20)
            ->get()
            ->map(function ($company) use ($rankMap) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'sector' => $company->sector,
                    'display_rank' => $rankMap[$company->id] ?? null,
                    'global_score' => $company->rseScore->global_score,
                    'rating_letter' => $company->rseScore->rating_letter,
                ];
            });

        // Only calculate charts data if not a partial reload or if explicitly requested
        $scoreDistribution = [];
        $sectorPerformance = [];

        if (! $request->header('X-Inertia-Partial-Data') ||
            in_array('scoreDistribution', explode(',', $request->header('X-Inertia-Partial-Data'))) ||
            in_array('sectorPerformance', explode(',', $request->header('X-Inertia-Partial-Data')))) {

            $scoreDistribution = RseScore::selectRaw('
                CASE 
                    WHEN global_score >= 80 THEN "Excellent (80-100)"
                    WHEN global_score >= 60 THEN "Good (60-79)"
                    WHEN global_score >= 40 THEN "Average (40-59)"
                    ELSE "Poor (0-39)"
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
        }

        return Inertia::render('RseDashboard', [
            'stats' => $stats,
            'topCompanies' => $topCompanies,
            'scoreDistribution' => $scoreDistribution,
            'sectorPerformance' => $sectorPerformance,
            'currentSort' => [
                'field' => $sortBy,
                'order' => $sortOrder,
            ],
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $sector = $request->get('sector');
        $minScore = $request->get('min_score');
        $maxScore = $request->get('max_score');
        $sortBy = $request->get('sort', 'global_score');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort parameters
        $allowedSortFields = ['name', 'sector', 'global_score', 'rating_letter'];
        $allowedSortOrders = ['asc', 'desc'];

        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'global_score';
        $sortOrder = in_array($sortOrder, $allowedSortOrders) ? $sortOrder : 'desc';

        $companiesQuery = Company::with('rseScore')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('siren', 'like', "%{$query}%");
            })
            ->when($sector, fn ($q) => $q->where('sector', $sector))
            ->when($minScore || $maxScore, function ($q) use ($minScore, $maxScore) {
                $q->byScore($minScore, $maxScore);
            })
            ->whereHas('rseScore');

        // Apply sorting
        if ($sortBy === 'global_score' || $sortBy === 'rating_letter') {
            $companiesQuery->join('rse_scores', 'companies.id', '=', 'rse_scores.company_id')
                ->orderBy("rse_scores.{$sortBy}", $sortOrder)
                ->select('companies.*');
        } else {
            $companiesQuery->orderBy($sortBy, $sortOrder);
        }

        $companies = $companiesQuery->paginate(20);

        return response()->json($companies);
    }

    public function show(Company $company): Response
    {
        $company->load('rseScore', 'reports');

        // Get similar companies (same sector)
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
                'message' => 'Score updated successfully',
                'score' => $score,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating score',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function companiesTable(Request $request): Response
    {
        $query = $request->get('name');
        $hasScore = $request->boolean('has_score');
        $perPage = 25;

        $companiesQuery = \App\Models\Company::query()
            ->with('rseScore')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->when($hasScore, function ($q) {
                $q->whereHas('rseScore');
            });

        $sortBy = $request->get('sort', 'display_rank');
        $sortOrder = $request->get('order', 'asc');
        $allowedSortFields = ['name', 'sector', 'global_score', 'rating_letter', 'display_rank'];
        $allowedSortOrders = ['asc', 'desc'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'display_rank';
        $sortOrder = in_array($sortOrder, $allowedSortOrders) ? $sortOrder : 'asc';

        // Générer le classement global une fois pour toutes les companies avec un score
        $allRanked = Company::with('rseScore')
            ->whereHas('rseScore')
            ->get()
            ->sortByDesc(fn ($c) => $c->rseScore->global_score ?? 0)
            ->values();
        $rankMap = [];
        foreach ($allRanked as $idx => $company) {
            $rankMap[$company->id] = $idx + 1;
        }

        $companies = $companiesQuery->paginate($perPage)->appends($request->all());

        // Injection du classement global
        $companies->getCollection()->map(function ($company) use ($rankMap) {
            // Using map() instead of transform() because we're converting to array
            return [
                'id' => $company->id,
                'name' => $company->name,
                'sector' => $company->sector,
                'display_rank' => $rankMap[$company->id] ?? null,
                'rseScore' => [
                    'global_score' => $company->rseScore->global_score ?? '',
                    'rating_letter' => $company->rseScore->rating_letter ?? null,
                ],
            ];
        });

        // Tri côté PHP sur display_rank si demandé
        if ($sortBy === 'display_rank') {
            $sorted = $companies->getCollection()->sortBy('display_rank', SORT_REGULAR, $sortOrder === 'desc')->values();
            $companies->setCollection($sorted);
        }

        return Inertia::render('CompanyTable', [
            'companies' => $companies,
            'filters' => [
                'name' => $query,
                'has_score' => $hasScore,
            ],
        ]);
    }
}
