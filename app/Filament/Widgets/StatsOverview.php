<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Biblioteca;


class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('', Biblioteca::where('tipo', 'Comunitária')->count() )
                ->description('Bibliotecas Comunitárias')
                ->color('info'),
            Stat::make('', Biblioteca::where('tipo', 'Pública')->count())
                ->description('Bibliotecas Públicas')
                ->color('success'),
        ];
    }

    //Metódo para definir as colunas
    protected function getColumns(): int
    {
        return 2;
    }
}
