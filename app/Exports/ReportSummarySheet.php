<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportSummarySheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    public function __construct(
        private array $summary,
        private $budgetPerformance,
        private string $month,
        private string $monthLabel,
    ) {}

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function array(): array
    {
        $rows = [
            ['MY FINANCE — LAPORAN KEUANGAN'],
            ['Periode:', $this->monthLabel],
            ['Dibuat:', now()->format('d/m/Y H:i')],
            [''],
            ['=== RINGKASAN ==='],
            ['Total Pemasukan', 'Rp ' . number_format($this->summary['income'], 0, ',', '.')],
            ['Total Pengeluaran', 'Rp ' . number_format($this->summary['expense'], 0, ',', '.')],
            ['Selisih Bersih', 'Rp ' . number_format($this->summary['net'], 0, ',', '.')],
            [''],
        ];

        if ($this->budgetPerformance->count() > 0) {
            $rows[] = ['=== PERFORMA ANGGARAN ==='];
            $rows[] = ['Kategori', 'Anggaran', 'Terpakai', 'Sisa', 'Persentase'];
            foreach ($this->budgetPerformance as $b) {
                $rows[] = [
                    $b['name'],
                    'Rp ' . number_format($b['amount'], 0, ',', '.'),
                    'Rp ' . number_format($b['spent'], 0, ',', '.'),
                    'Rp ' . number_format($b['remaining'], 0, ',', '.'),
                    $b['percentage'] . '%',
                ];
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF1A73E8']]],
            5 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 25, 'C' => 25, 'D' => 25, 'E' => 15];
    }
}
