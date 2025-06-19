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

        if (
            ! $request->header('X-Inertia-Partial-Data') ||
            in_array('scoreDistribution', explode(',', $request->header('X-Inertia-Partial-Data'))) ||
            in_array('sectorPerformance', explode(',', $request->header('X-Inertia-Partial-Data')))
        ) {

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

        // Obtention des entreprises similaires (même secteur)
        $similarCompanies = Company::with('rseScore')
            ->where('sector', $company->sector)
            ->where('id', '!=', $company->id)
            ->whereHas('rseScore')
            ->orderByDesc(function ($query) {
                $query->select('global_score')
                    ->from('rse_scores')
                    ->whereColumn('rse_scores.company_id', 'companies.id')
                    ->limit(1);
            })
            ->limit(6)
            ->get()
            ->map(function ($similarCompany) {
                return [
                    'id' => $similarCompany->id,
                    'name' => $similarCompany->name,
                    'sector' => $similarCompany->sector,
                    'rseScore' => $similarCompany->rseScore ? [
                        'global_score' => (float) $similarCompany->rseScore->global_score,
                        'rating_letter' => $similarCompany->rseScore->rating_letter,
                    ] : null,
                ];
            });

        // Calcul des statistiques sectorielles détaillées
        $sectorCompanies = Company::with('rseScore')
            ->where('sector', $company->sector)
            ->whereHas('rseScore')
            ->get();

        // Statistiques globales
        $sectorGlobalStats = $sectorCompanies->map(function ($c) {
            return (float) $c->rseScore->global_score;
        })->sort()->values();

        // Statistiques environnementales
        $sectorEnvironmentalStats = $sectorCompanies->map(function ($c) {
            return (float) $c->rseScore->environmental_score;
        });

        // Statistiques sociales
        $sectorSocialStats = $sectorCompanies->map(function ($c) {
            return (float) $c->rseScore->social_score;
        });

        // Statistiques de gouvernance
        $sectorGovernanceStats = $sectorCompanies->map(function ($c) {
            return (float) $c->rseScore->governance_score;
        });

        // Statistiques d'éthique
        $sectorEthicsStats = $sectorCompanies->map(function ($c) {
            return (float) $c->rseScore->ethics_score;
        });

        // Calcul du top quartile (75ème percentile) pour le score global
        $count = count($sectorGlobalStats);
        $topQuartile = null;
        if ($count > 0) {
            $pos = 0.75 * ($count - 1);
            $base = floor($pos);
            $rest = $pos - $base;
            if (($base + 1) < $count) {
                $topQuartile = $sectorGlobalStats[(int) $base] + $rest * ($sectorGlobalStats[(int) $base + 1] - $sectorGlobalStats[(int) $base]);
            } else {
                $topQuartile = $sectorGlobalStats[(int) $base];
            }
        }

        $sectorPerformance = [
            'average_score' => round($sectorGlobalStats->avg(), 2),
            'median_score' => round($sectorGlobalStats->median(), 2),
            'top_quartile' => round($topQuartile, 2),
            'company_count' => $sectorGlobalStats->count(),
            // Ajout des moyennes par catégorie avec précision décimale
            'environmental_average' => round($sectorEnvironmentalStats->avg(), 2),
            'social_average' => round($sectorSocialStats->avg(), 2),
            'governance_average' => round($sectorGovernanceStats->avg(), 2),
            'ethics_average' => round($sectorEthicsStats->avg(), 2),
        ];

        // Préparer les données de la company avec les scores décimaux
        $companyData = $company->toArray();
        if ($company->rseScore) {
            $companyData['rseScore'] = [
                'id' => $company->rseScore->id,
                'global_score' => (float) $company->rseScore->global_score,
                'rating_letter' => $company->rseScore->rating_letter,
                'environmental_score' => (float) $company->rseScore->environmental_score,
                'social_score' => (float) $company->rseScore->social_score,
                'governance_score' => (float) $company->rseScore->governance_score,
                'ethics_score' => (float) $company->rseScore->ethics_score,
                'detailed_metrics' => $company->rseScore->detailed_metrics,
                'data_quality_score' => $company->rseScore->data_quality_score,
                'last_updated' => $company->rseScore->last_updated,
            ];
        }

        return Inertia::render('CompanyDetail', [
            'company' => $companyData,
            'similarCompanies' => $similarCompanies,
            'sectorPerformance' => $sectorPerformance,
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

    public function companiesTable(Request $request): Response
    {
        $name = $request->get('name');
        $sector = $request->get('sector');
        $minScore = $request->get('min_score');
        $maxScore = $request->get('max_score');
        $perPage = 25;

        // Modification : Changer le tri par défaut pour global_score desc
        $sortBy = $request->get('sort', 'global_score');
        $sortOrder = $request->get('order', 'desc');

        $allowedSortFields = ['name', 'sector', 'global_score', 'rating_letter', 'display_rank'];
        $allowedSortOrders = ['asc', 'desc'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'global_score';
        $sortOrder = in_array($sortOrder, $allowedSortOrders) ? $sortOrder : 'desc';

        $companiesQuery = Company::query()
            ->with('rseScore')
            // CORRECTION PRINCIPALE : Ajouter le filtre pour les entreprises avec score RSE
            ->whereHas('rseScore')
            ->when($name, function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            })
            ->when($sector, function ($q) use ($sector) {
                $q->where('sector', $sector);
            })
            ->when($minScore || $maxScore, function ($q) use ($minScore, $maxScore) {
                $q->whereHas('rseScore', function ($subQuery) use ($minScore, $maxScore) {
                    if ($minScore) {
                        $subQuery->where('global_score', '>=', $minScore);
                    }
                    if ($maxScore) {
                        $subQuery->where('global_score', '<=', $maxScore);
                    }
                });
            });

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

        // Apply sorting before pagination
        if ($sortBy === 'global_score' || $sortBy === 'rating_letter') {
            $companiesQuery->join('rse_scores', 'companies.id', '=', 'rse_scores.company_id')
                ->select('companies.*')
                ->orderBy("rse_scores.{$sortBy}", $sortOrder);
        } elseif ($sortBy !== 'display_rank') {
            $companiesQuery->orderBy($sortBy, $sortOrder);
        }

        $companies = $companiesQuery->paginate($perPage)->appends($request->all());

        // Injection du classement global et données complètes
        $companies->getCollection()->transform(function ($company) use ($rankMap) {
            $company->display_rank = $rankMap[$company->id] ?? null;

            return $company;
        });

        // Tri côté PHP sur display_rank si demandé
        if ($sortBy === 'display_rank') {
            $sorted = $companies->getCollection()->sortBy('display_rank', SORT_REGULAR, $sortOrder === 'desc')->values();
            $companies->setCollection($sorted);
        }

        // Get available sectors for filter dropdown
        $sectors = Company::select('sector')
            ->whereNotNull('sector')
            ->distinct()
            ->orderBy('sector')
            ->pluck('sector');

        return Inertia::render('CompanyTable', [
            'companies' => $companies,
            'sectors' => $sectors,
            'filters' => [
                'name' => $name,
                'sector' => $sector,
                'min_score' => $minScore,
                'max_score' => $maxScore,
                'sort' => $sortBy,
                'order' => $sortOrder,
            ],
        ]);
    }
}
