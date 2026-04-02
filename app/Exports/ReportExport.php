<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    public function __construct(
        public $summary,
        public $expenseByCategory,
        public $allTransactions,
        public $budgetPerformance,
        public string $month,
        public string $monthLabel,
    ) {}

    public function sheets(): array
    {
        return [
            new ReportSummarySheet($this->summary, $this->budgetPerformance, $this->month, $this->monthLabel),
            new ReportCategorySheet($this->expenseByCategory, $this->monthLabel),
            new ReportTransactionSheet($this->allTransactions, $this->monthLabel),
        ];
    }
}
