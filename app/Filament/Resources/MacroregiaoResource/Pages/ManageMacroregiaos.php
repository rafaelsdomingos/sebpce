<?php

namespace App\Filament\Resources\MacroregiaoResource\Pages;

use App\Filament\Resources\MacroregiaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMacroregiaos extends ManageRecords
{
    protected static string $resource = MacroregiaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
