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
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Resources\RelationManagers\RelationGroup;




class BibliotecaResource extends Resource
{
    protected static ?string $model = Biblioteca::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $modelLabel = 'Biblioteca';
    protected static ?string $pluralModelLabel = 'Bibliotecas';
    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('IDENTIFICAÇÃO DA BIBLIOTECA')
                    ->schema([
                        Forms\Components\Select::make('macroregiao_id')
                            ->label('Macroregião')
                            ->relationship('macroregiao', 'nome')
                            ->required()
                            ->columnSpan('2')
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
                            ->columnSpan('2')
                            ->reactive(),
    
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan('4'),
        
                        Forms\Components\TextInput::make('endereco')
                            ->label('Endereço')
                            ->maxLength(255)
                            ->columnSpan('2')
                            ->default(null),
        
                        Forms\Components\TextInput::make('cep')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->maxLength(255)
                            ->default(null),
        
                        Forms\Components\TextInput::make('cidade')
                            ->maxLength(255)
                            ->default(null),
        
                        Forms\Components\TextInput::make('fone')
                            ->label('Telefone')
                            ->mask('(99) 9999-9999')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('celular')
                            ->label('Celular / Whatsapp')
                            ->mask('(99) 9999-9999')
                            ->maxLength(255)
                            ->default(null),
    
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->columnSpan('2')
                            ->default(null),
        
                        Forms\Components\TextInput::make('horario_funcionamento')
                            ->label('Horário de funcionamento')
                            ->columnSpan('2')
                            ->maxLength(255)
                            ->default(null),
    
                        Forms\Components\DatePicker::make('data_criacao')
                            ->label('Data de criação'),
        
                        Forms\Components\Select::make('subordinacao')
                            ->label('Subordinação')
                            ->options(fn (callable $get) => $get('tipo') === 'publica' 
                                ? [
                                    'Secretaria de Cultura' => 'Secretaria de Cultura',
                                    'Secretaria de Educação' => 'Secretaria de Educação',
                                    'Outro' => 'Outro',
                                ]
                                : [
                                    'ONG' => 'ONG',
                                    'Associação' => 'Associação',
                                    'Particular' => 'Particular',
                                    'Coletivo' => 'Coletivo',
                                    'Outro' => 'Outro',
                                ])
                            ->hidden(fn (callable $get) => !$get('tipo'))
                            ->reactive()
                            ->default(null),
                        

                        //Campos visíveis quando biblioteca for do tipo publica
                        Forms\Components\Toggle::make('possui_lei')
                            ->label('Possui lei de criação?')
                            ->columnSpan('2')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),

                        Forms\Components\Toggle::make('foi_implantada')
                            ->columnSpan('2')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),
        
                        Forms\Components\TextInput::make('lei_criacao')
                            ->label('Se sim, informe a lei e o ano de criação')
                            ->columnSpan('2')
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('tipo') === 'publica')
                            ->default(null),

                        //Campos visíveis quando biblioteca for do tipo comunitária
                        Forms\Components\TextInput::make('registro_sebp')
                            ->label('Registro SEBP')
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('tipo') === 'comunitaria')
                            ->default(null),
    
    
                        Forms\Components\DatePicker::make('data_implantacao')
                            ->columnSpan('2')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),
        
                        Forms\Components\Toggle::make('foi_modernizada')
                            ->columnSpan('2')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),

                        Forms\Components\Toggle::make('orcamento_proprio')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),
        
                        Forms\Components\DatePicker::make('data_modernizacao')
                            ->columnSpan('2')
                            ->visible(fn ($get) => $get('tipo') === 'publica'),
        
                        

                    ]),

                Fieldset::make('SERVIÇOS PRESTADOS')
                    ->schema([
                        Forms\Components\CheckboxList::make('servicos_prestados')
                            ->label('')
                            ->options([
                                'Empréstimo Domiciliar' => 'Empréstimo Domiciliar',
                                'Consulta Local' => 'Oficinas/Cursos',
                                'Oficinas/Cursos' => 'Oficinas/Cursos',
                                'Mesa redeonda/Palestra' => 'Mesa redeonda/Palestral',
                                'Exposição' => 'Exposição',
                                'Mediação Literária' => 'Mediação Literária',
                                'Saraus' => 'Saraus',
                                'Teatro' => 'Teatro',
                                'Contação de História' => 'Contação de História',
                                'Lançamentos de livros' => 'Lançamentos de livros',
                                'Outros' => 'Outros',
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
                Fieldset::make('REDES SOCIAIS')
                    ->schema([
                        Forms\Components\CheckboxList::make('redes_sociais')
                            ->label('')
                            ->options([
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'youtube' => 'Youtube',
                                'mc_nacional' => 'Mapa Cultural Nacional',
                                'mc_estadual' => 'Mapa Cultural Estadual',
                                'mc_municipal' => 'Mapa Cultural Municipal',
                                'outros' => 'Outros',
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
                


            ])->columns(4);
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

            RelationGroup::make('Espaço Físico', [
                RelationManagers\EspacoRelationManager::class,
            ]),

            RelationGroup::make('Acervo', [
                RelationManagers\FuncionariosRelationManager::class,
            ]),

            RelationGroup::make('Equipamentos', [
                RelationManagers\FuncionariosRelationManager::class,
            ]),

            RelationGroup::make('Funcionários', [
                RelationManagers\FuncionariosRelationManager::class,
            ]),

            
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
