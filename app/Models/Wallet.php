<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    public const TYPE_ICONS = [
        'Bank' => 'account_balance',
        'E-Wallet' => 'account_balance_wallet',
        'Investasi' => 'trending_up',
        'Tunai' => 'payments',
        'Kripto' => 'currency_bitcoin',
    ];

    public const TYPE_COLORS = [
        'Bank' => '#4B8EFF',
        'E-Wallet' => '#00A572',
        'Investasi' => '#7C3AED',
        'Tunai' => '#16A34A',
        'Kripto' => '#F59E0B',
    ];

    public const LEGACY_COLOR_MAP = [
        'bg-blue-700' => '#1D4ED8',
        'bg-yellow-600' => '#CA8A04',
        'bg-blue-600' => '#2563EB',
        'bg-emerald-600' => '#059669',
        'bg-purple-600' => '#9333EA',
        'bg-blue-500' => '#3B82F6',
        'bg-blue-400' => '#60A5FA',
        'bg-orange-500' => '#F97316',
        'bg-orange-600' => '#EA580C',
        'bg-green-600' => '#16A34A',
        'bg-primary' => '#ADC6FF',
        'bg-secondary' => '#4EDEA3',
        'bg-tertiary-container' => '#FF516A',
        'bg-amber-400' => '#FBBF24',
        'bg-indigo-500' => '#6366F1',
        'bg-fuchsia-500' => '#D946EF',
        'bg-rose-500' => '#F43F5E',
        'bg-slate-400' => '#94A3B8',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance',
        'currency',
        'icon',
        'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(Transaction::class, 'to_wallet_id');
    }

    public static function defaultIconForType(string $type): string
    {
        return self::TYPE_ICONS[$type] ?? 'account_balance_wallet';
    }

    public static function defaultColorForType(string $type): string
    {
        return self::TYPE_COLORS[$type] ?? '#ADC6FF';
    }

    public function resolvedIcon(): string
    {
        return self::TYPE_ICONS[$this->type] ?? ($this->icon ?: 'account_balance_wallet');
    }

    public function resolvedColor(): string
    {
        $color = $this->color;

        if (! $color) {
            return self::defaultColorForType($this->type);
        }

        if (isset(self::LEGACY_COLOR_MAP[$color])) {
            return self::LEGACY_COLOR_MAP[$color];
        }

        if (preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            return strtoupper($color);
        }

        return self::defaultColorForType($this->type);
    }
}
