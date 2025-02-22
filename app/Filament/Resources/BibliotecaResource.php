<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BibliotecaResource\Pages;
use App\Filament\Resources\BibliotecaResource\RelationManagers;
use App\Models\Biblioteca;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BibliotecaResource extends Resource
{
    protected static ?string $model = Biblioteca::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('macroregiao_id')
                    ->label('Macroregião')
                    ->relationship('macroregiao', 'nome')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required(),
                    ]),

                Forms\Components\Select::make('tipo')
                    ->required()
                    ->options([
                        'comunitaria' => 'Comunitária',
                        'publica' => 'Pública',
                    ])
                    ->reactive(),

                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('endereco')
                    ->label('Endereço')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('cep')
                    ->label('CEP')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('cidade')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('fone')
                    ->label('Telefone')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('celular')
                    ->label('Celular / Whatsapp')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('horario_funcionamento')
                    ->label('Horário de funcionamento')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\DatePicker::make('data_criacao')
                    ->label('Data de criação'),

                Forms\Components\Toggle::make('possui_lei')
                    ->label('Possui lei de criação?')
                    ->visible(fn ($get) => $get('tipo') === 'publica'),

                Forms\Components\TextInput::make('lei_criacao')
                    ->label('Se sim, qual lei')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('subordinacao')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Toggle::make('foi_implantada'),

                Forms\Components\DatePicker::make('data_implantacao'),

                Forms\Components\Toggle::make('foi_modernizada'),

                Forms\Components\DatePicker::make('data_modernizacao'),

                Forms\Components\Toggle::make('orcamento_proprio'),

                Forms\Components\Textarea::make('redes_sociais')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('macroregiao.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBibliotecas::route('/'),
            'create' => Pages\CreateBiblioteca::route('/create'),
            'edit' => Pages\EditBiblioteca::route('/{record}/edit'),
        ];
    }
}
