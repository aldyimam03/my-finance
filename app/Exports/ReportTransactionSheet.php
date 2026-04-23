<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportTransactionSheet implements FromArray, WithTitle, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(
        private $allTransactions,
        private string $monthLabel,
    ) {}

    public function title(): string
    {
        return 'Semua Transaksi';
    }

    public function headings(): array
    {
        return ['Tanggal', 'Deskripsi', 'Kategori', 'Dompet', 'Tipe', 'Jumlah (Rp)'];
    }

    public function array(): array
    {
        return $this->allTransactions->map(function ($trx) {
            return [
                $trx->date->format('d/m/Y'),
                $trx->description ?? '-',
                $trx->category->name ?? '-',
                $trx->wallet->name ?? '-',
                $trx->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                $trx->type === 'income' ? $trx->amount : -$trx->amount,
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
        return ['A' => 15, 'B' => 35, 'C' => 20, 'D' => 15, 'E' => 15, 'F' => 20];
    }
}
