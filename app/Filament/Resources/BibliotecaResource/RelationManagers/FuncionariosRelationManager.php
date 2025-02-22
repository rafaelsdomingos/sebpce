<?php

namespace App\Filament\Resources\BibliotecaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuncionariosRelationManager extends RelationManager
{
    protected static string $relationship = 'funcionarios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('funcao')
                    ->required()
                    ->options([
                        'Coordenador(a)' => 'Coordenador(a)',
                        'Biblitecário(a)' => 'Biblitecário(a)',
                        'Secretário(a)' => 'Secretário(a)',
                    ]),
                
                Forms\Components\Select::make('escolaridade')
                    ->required()
                    ->options([
                        'Educação Básica' => 'Educação Básica',
                        'Ensino Médio' => 'Ensino Médio',
                        'Graduação' => 'Graduação',
                        'Pós-Graduação' => 'Pós-Graduação',
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome')
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('funcao'),
                Tables\Columns\TextColumn::make('escolaridade'),
                Tables\Columns\TextColumn::make('celular'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
