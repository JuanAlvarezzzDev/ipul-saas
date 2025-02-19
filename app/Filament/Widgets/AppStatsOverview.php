<?php

namespace App\Filament\Widgets;

use App\Enums\transactionStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AppStatsOverview extends BaseWidget
{  protected ?string $heading = 'Movimientos';
    use HasWidgetShield;
    protected function getStats(): array
    {
        $churchId = Auth::user()->church_id;
        
        $totalIngresos = $this->getTotalIncomes($churchId);
        $totalEgresos = $this->getTotalExpenses($churchId);
        $saldo = $totalIngresos - $totalEgresos;

        return [
            Stat::make('Total Ingresos', number_format($totalIngresos, 2) . ' PAB')
                ->description('Suma total de ingresos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total Egresos', number_format($totalEgresos, 2) . ' PAB')
                ->description('Suma total de egresos')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo Disponible', number_format($saldo, 2) . ' PAB')
                ->description('Diferencia entre ingresos y egresos')
                ->descriptionIcon($saldo >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($saldo >= 0 ? 'success' : 'danger'),
        ];
    }

    private function getTotalIncomes(int $churchId): float
    {
        return Transactions::whereHas('transactionConcept', function ($query) {
                $query->where('transaction_type', TransactionStatus::INCOME);
            })
            ->where('church_id', $churchId)
            ->sum('amount');
    }

    private function getTotalExpenses(int $churchId): float
    {
        return Transactions::whereHas('transactionConcept', function ($query) {
                $query->where('transaction_type', TransactionStatus::EXPENSE);
            })
            ->where('church_id', $churchId)
            ->sum('amount');
    }
}
