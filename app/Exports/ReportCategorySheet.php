<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportCategorySheet implements FromArray, WithTitle, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(
        private $expenseByCategory,
        private string $monthLabel,
    ) {}

    public function title(): string
    {
        return 'Per Kategori';
    }

    public function headings(): array
    {
        return ['Kategori', 'Total Pengeluaran (Rp)', 'Persentase (%)'];
    }

    public function array(): array
    {
        return $this->expenseByCategory->map(function ($cat) {
            return [
                $cat['name'],
                $cat['amount'],
                $cat['percentage'],
            ];
        })->toArray();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1A73E8']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 25, 'C' => 20];
    }
}
