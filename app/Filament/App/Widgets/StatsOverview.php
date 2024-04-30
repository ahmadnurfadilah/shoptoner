<?php

namespace App\Filament\App\Widgets;

use App\Models\Payment\Payment;
use App\Models\Product\Product;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::where('store_id', Filament::getTenant()->id)->count()),
            Stat::make('Total Orders', Payment::where('status', 'success')->where('store_id', Filament::getTenant()->id)->count()),
            Stat::make('Total Revenue', round(Payment::where('status', 'success')->where('store_id', Filament::getTenant()->id)->sum('total_amount'), 2) . ' TON'),
        ];
    }
}
