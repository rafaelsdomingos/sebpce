<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Biblioteca;
use App\Models\Macroregiao;

class MacroregiaoChart extends ChartWidget
{
    protected static ?string $heading = 'Quantidade de bibliotecas por macroregião';
    protected static ?string $maxHeight = '360px';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Comunitárias',
                    'data' => [
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 1)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 2)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 3)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 4)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 5)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 6)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 7)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 8)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 9)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 10)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 11)->count(),
                        Biblioteca::where('tipo', "Comunitária")->where('macroregiao_id', 12)->count(),
                    ],
                    'backgroundColor' => '#BEDAFF',
                    'borderColor' => '#136EFF',
                ],
                [
                    'label' => 'Públicas',
                    'data' => [
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 1)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 2)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 3)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 4)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 5)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 6)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 7)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 8)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 9)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 10)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 11)->count(),
                        Biblioteca::where('tipo', 'Pública')->where('macroregiao_id', 12)->count(),
                    ],
                    'backgroundColor' => '#C7F6D0',
                    'borderColor' => '#04B31E',
                ],
            ],
            'labels' => [ 
                Macroregiao::where('id', 1)->value('nome'), 
                Macroregiao::where('id', 2)->value('nome'), 
                Macroregiao::where('id', 3)->value('nome'), 
                Macroregiao::where('id', 4)->value('nome'), 
                Macroregiao::where('id', 5)->value('nome'), 
                Macroregiao::where('id', 6)->value('nome'), 
                Macroregiao::where('id', 7)->value('nome'), 
                Macroregiao::where('id', 8)->value('nome'), 
                Macroregiao::where('id', 9)->value('nome'),
                Macroregiao::where('id', 10)->value('nome'), 
                Macroregiao::where('id', 11)->value('nome'), 
                Macroregiao::where('id', 12)->value('nome'),
            
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
