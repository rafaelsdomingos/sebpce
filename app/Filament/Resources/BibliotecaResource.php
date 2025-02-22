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
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('tipo')
                    ->required()
                    ->options([
                        'comunitaria' => 'Comunitária',
                        'publica' => 'Pública',
                    ]),

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
                    ->label('Possui lei de criação?'),

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
                Tables\Columns\TextColumn::make('macroregiao_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('endereco')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cep')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('horario_funcionamento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_criacao')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('possui_lei')
                    ->boolean(),
                Tables\Columns\TextColumn::make('lei_criacao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subordinacao')
                    ->searchable(),
                Tables\Columns\IconColumn::make('foi_implantada')
                    ->boolean(),
                Tables\Columns\TextColumn::make('data_implantacao')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('foi_modernizada')
                    ->boolean(),
                Tables\Columns\TextColumn::make('data_modernizacao')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('orcamento_proprio')
                    ->boolean(),
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
