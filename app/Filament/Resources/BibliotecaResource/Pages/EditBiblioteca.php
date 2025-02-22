<?php

namespace App\Filament\Resources\BibliotecaResource\Pages;

use App\Filament\Resources\BibliotecaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBiblioteca extends EditRecord
{
    protected static string $resource = BibliotecaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
