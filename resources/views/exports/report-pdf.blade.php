<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $monthLabel }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1a1a2e; background: #fff; }

        .header { background: linear-gradient(135deg, #1a73e8, #0d47a1); color: white; padding: 28px 32px; margin-bottom: 24px; }
        .header h1 { font-size: 22px; font-weight: 700; letter-spacing: -0.5px; margin-bottom: 4px; }
        .header p { font-size: 12px; opacity: 0.85; }
        .header .meta { margin-top: 12px; display: flex; gap: 24px; }
        .header .meta span { font-size: 10px; background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 20px; }

        .body { padding: 0 32px 32px; }

        .summary-grid { display: flex; gap: 12px; margin-bottom: 24px; }
        .summary-card { flex: 1; padding: 14px 16px; border-radius: 10px; border: 1px solid #e0e0e0; }
        .summary-card .label { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 6px; }
        .summary-card .value { font-size: 16px; font-weight: 700; }
        .income .value { color: #2e7d32; }
        .expense .value { color: #c62828; }
        .net .value { color: {{ $netBalance >= 0 ? '#2e7d32' : '#c62828' }}; }

        .section { margin-bottom: 24px; }
        .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1a73e8; border-bottom: 2px solid #1a73e8; padding-bottom: 6px; margin-bottom: 12px; }

        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background: #1a73e8; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-weight: 600; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background: #f5f7ff; }
        tbody tr:hover { background: #e8f0fe; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #eee; }

        .badge-income { color: #2e7d32; font-weight: 700; }
        .badge-expense { color: #c62828; font-weight: 700; }

        .progress-bar-wrap { background: #e0e0e0; border-radius: 4px; height: 6px; width: 100px; display: inline-block; vertical-align: middle; }
        .progress-bar { height: 6px; border-radius: 4px; background: #1a73e8; }

        .footer { margin-top: 32px; padding-top: 12px; border-top: 1px solid #eee; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>My Finance — Laporan Keuangan</h1>
        <p>Laporan keuangan bulanan yang dikompilasi secara otomatis</p>
        <div class="meta">
            <span>📅 Periode: {{ $monthLabel }}</span>
            <span>🖨️ Dicetak: {{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div class="body">
        {{-- Summary --}}
        <div class="summary-grid">
            <div class="summary-card income">
                <div class="label">Total Pemasukan</div>
                <div class="value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card expense">
                <div class="label">Total Pengeluaran</div>
                <div class="value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card net">
                <div class="label">Selisih Bersih</div>
                <div class="value">{{ $netBalance >= 0 ? '+' : '' }}Rp {{ number_format($netBalance, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Expense by Category --}}
        @if($expenseByCategory->count() > 0)
        <div class="section">
            <div class="section-title">Distribusi Pengeluaran Per Kategori</div>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Persentase</th>
                        <th>Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseByCategory as $cat)
                    <tr>
                        <td><strong>{{ $cat['name'] }}</strong></td>
                        <td>Rp {{ number_format($cat['amount'], 0, ',', '.') }}</td>
                        <td>{{ $cat['percentage'] }}%</td>
                        <td>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width: {{ $cat['percentage'] }}%;"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Budget Performance --}}
        @if($budgetPerformance->count() > 0)
        <div class="section">
            <div class="section-title">Performa Anggaran</div>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Anggaran</th>
                        <th>Terpakai</th>
                        <th>Sisa</th>
                        <th>%</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgetPerformance as $b)
                    <tr>
                        <td>{{ $b['name'] }}</td>
                        <td>Rp {{ number_format($b['amount'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($b['spent'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($b['remaining'], 0, ',', '.') }}</td>
                        <td>{{ $b['percentage'] }}%</td>
                        <td style="color: {{ $b['percentage'] >= 90 ? '#c62828' : ($b['percentage'] >= 75 ? '#e65100' : '#2e7d32') }}; font-weight: 700;">
                            {{ $b['percentage'] >= 90 ? 'KRITIS' : ($b['percentage'] >= 75 ? 'WASPADA' : 'AMAN') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- All Transactions --}}
        <div class="section">
            <div class="section-title">Riwayat Transaksi ({{ $allTransactions->count() }} Transaksi)</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Dompet</th>
                        <th>Tipe</th>
                        <th style="text-align:right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allTransactions as $trx)
                    <tr>
                        <td>{{ $trx->date->format('d/m/Y') }}</td>
                        <td>{{ $trx->description ?? '-' }}</td>
                        <td>{{ $trx->category->name ?? '-' }}</td>
                        <td>{{ $trx->wallet->name ?? '-' }}</td>
                        <td class="{{ $trx->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $trx->type === 'income' ? '↓ Masuk' : '↑ Keluar' }}
                        </td>
                        <td style="text-align:right" class="{{ $trx->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; color:#999; padding: 16px;">Tidak ada transaksi pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            My Finance — Laporan Keuangan Pribadi &bull; Periode {{ $monthLabel }} &bull; Dicetak {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
