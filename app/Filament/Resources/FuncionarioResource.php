<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuncionarioResource\Pages;
use App\Filament\Resources\FuncionarioResource\RelationManagers;
use App\Models\Funcionario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuncionarioResource extends Resource
{
    protected static ?string $model = Funcionario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('biblioteca_id')
                    ->label('Biblioteca')
                    ->relationship('biblioteca', 'nome')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('funcao')
                    ->required()
                    ->options([
                        'coordenador' => 'Coordenador(a)',
                        'bibliotecario' => 'Biblitecário(a)',
                        'secretario' => 'Secretário(a)',
                    ]),
                Forms\Components\Select::make('escolaridade')
                    ->required()
                    ->options([
                        'basica' => 'Educação Básica',
                        'media' => 'Ensino Médio',
                        'graduacao' => 'Graduação',
                        'pos' => 'Pós-Graduação',
                    ]),
                Forms\Components\TextInput::make('fone')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('celular')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('funcao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('escolaridade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageFuncionarios::route('/'),
        ];
    }
}
