<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        ['transactions' => $transactions, 'reportMatches' => $reportMatches] = $this->searchData($query, 12, 6);

        return view('search-results', [
            'query' => $query,
            'transactions' => $transactions,
            'reportMatches' => $reportMatches,
        ]);
    }

    public function suggest(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        if ($query === '') {
            return response()->json([
                'transactions' => [],
                'reports' => [],
            ]);
        }

        ['transactions' => $transactions, 'reportMatches' => $reportMatches] = $this->searchData($query, 5, 3);

        return response()->json([
            'transactions' => $transactions->map(fn ($transaction) => [
                'description' => $transaction->description ?: 'Tanpa Deskripsi',
                'category' => $transaction->category->name ?? 'Tanpa Kategori',
                'wallet' => $transaction->wallet->name ?? '-',
                'date' => $transaction->date->format('d M Y'),
                'amount' => number_format($transaction->amount, 0, ',', '.'),
                'type' => $transaction->type,
                'url' => route('transactions', ['q' => $query]),
            ])->values(),
            'reports' => $reportMatches->map(fn (array $report) => [
                'label' => $report['label'],
                'url' => route('reports', ['month' => $report['value']]),
            ])->values(),
        ]);
    }

    private function searchData(string $query, int $transactionLimit = 12, int $reportLimit = 6): array
    {
        if ($query === '') {
            return [
                'transactions' => collect(),
                'reportMatches' => collect(),
            ];
        }

        $transactions = Auth::user()
            ->transactions()
            ->with(['wallet', 'category'])
            ->where(function ($builder) use ($query) {
                $builder
                    ->where('description', 'like', "%{$query}%")
                    ->orWhere('type', 'like', "%{$query}%")
                    ->orWhereHas('wallet', fn ($wallet) => $wallet->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('category', fn ($category) => $category->where('name', 'like', "%{$query}%"));
            })
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit($transactionLimit)
            ->get();

        $monthOptions = collect(range(0, 11))
            ->map(function ($offset) {
                $date = now()->subMonths($offset)->locale('id');

                return [
                    'value' => $date->format('Y-m'),
                    'label' => $date->isoFormat('MMMM YYYY'),
                ];
            });

        $normalizedQuery = mb_strtolower($query);

        $reportMatches = $monthOptions
            ->filter(function (array $option) use ($normalizedQuery) {
                return str_contains(mb_strtolower($option['label']), $normalizedQuery)
                    || str_contains($option['value'], $normalizedQuery)
                    || str_contains($normalizedQuery, 'laporan')
                    || str_contains($normalizedQuery, 'report');
            })
            ->take($reportLimit)
            ->values();

        return [
            'transactions' => $transactions,
            'reportMatches' => $reportMatches,
        ];
    }
}
