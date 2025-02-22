<?php

namespace App\Filament\Resources\BibliotecaResource\Pages;

use App\Filament\Resources\BibliotecaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBibliotecas extends ListRecords
{
    protected static string $resource = BibliotecaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
