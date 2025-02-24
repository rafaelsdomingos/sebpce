<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MacroregiaoResource\Pages;
use App\Filament\Resources\MacroregiaoResource\RelationManagers;
use App\Models\Macroregiao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;


class MacroregiaoResource extends Resource
{
    protected static ?string $model = Macroregiao::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $modelLabel = 'Macroregião';
    protected static ?string $pluralModelLabel = 'Macroregiões';
    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record) {
                        if ($record->bibliotecas()->count() > 0) {
                            Notification::make()
                                ->title('Erro ao excluir')
                                ->body('Não é possível excluir esta macroregião porque existem bibliotecas cadastradas.')
                                ->danger()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->success()
                            ->title('Excluído')
                            ->send();

                        $record->delete();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMacroregiaos::route('/'),
        ];
    }
}
