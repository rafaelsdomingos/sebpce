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
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('IDENTIFICAÇÃO')
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
                                    ])->columnSpan(4),

                            ]),

                        Tabs\Tab::make('ESPAÇO')
                            ->schema([

                                Forms\Components\TextInput::make('extensao')
                                    ->label('Extensão da biblioteca em m²')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\Select::make('predio')
                                    ->label('Prédio')
                                    ->options([
                                        'proprio' => 'Próprio',
                                        'alugado' => 'Alugado',
                                        'cedido' => 'Cedido',
                                    ])
                                    ->default(null),
                                Forms\Components\Select::make('situacao_fisica')
                                    ->label('Situação física')
                                    ->options([
                                        'otima' => 'Ótima',
                                        'boa' => 'Boa',
                                        'regular' => 'Regular',
                                        'insatisfatoria' => 'Insatisfatória',
                                    ])
                                    ->default(null),
                                Forms\Components\CheckboxList::make('acessibilidade')
                                    ->options([
                                        'rampa' => 'Rampa',
                                        'piso_tatil' => 'Piso Tátil',
                                        'banheiro_acessivel' => 'Banheiro Acessível',
                                        'elevador' => 'Elevador',
                                        'nenhuma' => 'Nenhuma',
                                    ])
                                    ->columnSpanFull(),
                                
                            ])->columns(3),
                        
                        //Início aba de acervo
                        Tabs\Tab::make('ACERVO')
                            ->schema([
                                Forms\Components\TextInput::make('total_livros')
                                    ->numeric()
                                    ->default(null),

                                Forms\Components\Select::make('acervo_registrado')
                                    ->label('O acervo é registrado em livro de tombo?')
                                    ->options([
                                        'nao' => 'Não',
                                        '25' => '25% registrado',
                                        '50' => '50% registrado',
                                        '75' => '75% registrado',
                                        '100' => '100% registrado',
                                    ])
                                    ->default(null),

                                Forms\Components\Select::make('acervo_catalogado')
                                    ->label('O acervo é catalogado?')
                                    ->options([
                                        'nao' => 'Não',
                                        '25' => '25% registrado',
                                        '50' => '50% registrado',
                                        '75' => '75% registrado',
                                        '100' => '100% registrado',
                                    ])
                                    ->default(null),

                                Forms\Components\Select::make('acervo_classificado')
                                    ->label('O acervo é classificado')
                                    ->options([
                                        'nao' => 'Não',
                                        '25' => '25% registrado',
                                        '50' => '50% registrado',
                                        '75' => '75% registrado',
                                        '100' => '100% registrado',
                                    ])
                                    ->default(null),

                                Forms\Components\Select::make('acervo_etiquetado')
                                    ->label('O acervo é entiquetado?')
                                    ->options([
                                        'nao' => 'Não',
                                        '25' => '25% registrado',
                                        '50' => '50% registrado',
                                        '75' => '75% registrado',
                                        '100' => '100% registrado',
                                    ])
                                    ->default(null),

                                Forms\Components\Select::make('acervo_informatizado')
                                    ->label('O acervo é informatizado?')
                                    ->options([
                                        'nao' => 'Não',
                                        '25' => '25% registrado',
                                        '50' => '50% registrado',
                                        '75' => '75% registrado',
                                        '100' => '100% registrado',
                                    ])
                                    ->default(null),

                                Forms\Components\Select::make('software')
                                    ->label('Se sim, qual o software utilizado?')
                                    ->options([
                                        'biblivre' => 'Biblivre',
                                        'koha' => 'Koha',
                                        'gnuteca' => 'Gnuteca',
                                        'outros' => 'Outros',
                                    ])
                                    ->default(null),

                                Forms\Components\CheckboxList::make('acervo_acessivel')
                                    ->label('Acervo acessível:')
                                    ->options([
                                        'livro_braile' => 'Livro em braile',
                                        'fonte_ampliada' => 'Fonte amplificada',
                                        'livro_digital' => 'Livro digital',
                                        'audiolivro' => 'Audiolivro',
                                        'nenhuma' => 'Nenhuma das alternativas',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('media_emprestimo_anual')
                                    ->label('Média de livros emprestados durante o ano:')
                                    ->numeric()
                                    ->default(null),

                                Forms\Components\TextInput::make('media_emprestimo_mensal')
                                    ->label('Média de livros emprestados durante o mês:')
                                    ->numeric()
                                    ->default(null),

                                Forms\Components\CheckboxList::make('generos_emprestados')
                                    ->label('Gêneros mais emprestados:')
                                    ->options([
                                        'literatura_geral' => 'Literatura Geral',
                                        'literatura_infantil' => 'Literatura Infantil / Infantojuvenil',
                                        'didaticos' => 'Didáticos',
                                        'quadrinhos' => 'Quadrinhos / HQ / Mangá',
                                        'outros' => 'Outros',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('media_pesquisa_local')
                                    ->numeric()
                                    ->default(null),

                                Forms\Components\CheckboxList::make('generos_pesquisados')
                                    ->options([
                                        'literatura_geral' => 'Literatura Geral',
                                        'literatura_infantil' => 'Literatura Infantil / Infantojuvenil',
                                        'didaticos' => 'Didáticos',
                                        'quadrinhos' => 'Quadrinhos / HQ / Mangá',
                                        'outros' => 'Outros',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\CheckboxList::make('formas_aquisicao')
                                    ->options([
                                        'compra' => 'Compra',
                                        'doacao' => 'Doação',
                                        'permuta' => 'Permuta',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\CheckboxList::make('tipos_acervo')
                                    ->options([
                                        'livros' => 'Livros',
                                        'revistas' => 'Revistas',
                                        'jornais' => 'Jornais',
                                        'quadrinhos' => 'Revistas em quadrinhos',
                                        'cd' => 'CD',
                                        'dvd' => 'DVD',
                                        'folhetos' => 'Folhetos',
                                        'fotografias' => 'Fotografias',
                                        'mapas' => 'Mapas',
                                        'cordel' => 'Cordel',
                                        'outros' => 'Outros',
                                    ])
                                    ->columnSpanFull(),


                            ])->columns(2),
                        
                        //Início Aba de equipamentos
                        Tabs\Tab::make('EQUIPAMENTOS')
                            ->schema([
                                Forms\Components\TextInput::make('qtd_computadores')
                                    ->label('Computadores')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_impressoras')
                                    ->label('Impressoras')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_televisores')
                                    ->label('Televisores')
                                    ->tel()
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_aparelho_dvd')
                                    ->label('DVDs')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_estantes')
                                    ->label('Estantes')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_bibliocantos')
                                    ->label('Bibliocantos')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_armarios')
                                    ->label('Armários')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_cadeiras')
                                    ->label('Cadeiras')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_mesas_leitores')
                                    ->label('Leitores')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_biros')
                                    ->label('Birôs')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_mesas_infantis')
                                    ->label('Mesas infantis')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_cadeiras_infantis')
                                    ->label('Cadeiras infantis')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_estantes_infantis')
                                    ->label('Estantes infantis')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_puffs')
                                    ->label('Puffs')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_tatames_coloridos')
                                    ->label('Tatames Coloridos')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_jogos_educativos')
                                    ->label('Jogos educativos')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_quadros_aviso')
                                    ->label('Quadros de aviso')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('qtd_datashow')
                                    ->label('Projetores')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('almofadas')
                                    ->label('Almofadas')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('bebedouro')
                                    ->label('Bebedouro')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('ventilador')
                                    ->label('Ventiladores')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('ar_condicionado')
                                    ->label('Condicionadores de ar')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('acesso_internet')
                                    ->label('Acesso à internet')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('outros_equipamentos')
                                    ->label('Outros equipamentos')
                                    ->maxLength(255)
                                    ->default(null),          
                            ])->columns(3),


                        Tabs\Tab::make('SERVIÇOS')
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

                    ])->columnSpanFull(),           

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

            RelationManagers\FuncionariosRelationManager::class,
            
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
