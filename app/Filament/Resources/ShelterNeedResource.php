<?php

namespace App\Filament\Resources;

use App\Enums\ShelterNeedTypeEnum;
use App\Filament\Resources\ShelterNeedResource\Pages;
use App\Models\Shelter\ShelterNeed;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms;

class ShelterNeedResource extends Resource
{
    protected static ?string $model = ShelterNeed::class;
    protected static ?string $navigationGroup = 'Abrigo';
    protected static ?string $modelLabel = 'Necessidade de Abrigo';
    protected static ?string $pluralLabel = 'Necessidades de Abrigos';

    protected static ?string $slug = 'shelter-needs';

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações gerais')
                    ->description('Insira as informações necessárias para a necessidade de abrigo.')
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Select::make('shelter_id')
                            ->label('Abrigo')
                            ->relationship('shelter', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('necessity_id')
                            ->label('Necessidade')
                            ->relationship('necessity', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('type_id')
                            ->label('Tipo')
                            ->options(ShelterNeedTypeEnum::class)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Lista de Necessidades de Abrigos')
            ->description('Explore a lista de necessidades de abrigos para opções de gerenciamento abrangentes.')
            ->columns([
                TextColumn::make('shelter.name')
                    ->label('Abrigo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('necessity.name')
                    ->label('Necessidade')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type_id')
                    ->label('Tipo')
                    ->sortable()
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Alterado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type_id')
                    ->label('Tipo')
                    ->options(ShelterNeedTypeEnum::class)
                    ->multiple()
                    ->native(false)
                    ->preload(),
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Shelter Details')
                    ->columnSpan('full')
                    ->tabs([
                        Tab::make('Detalhes')
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                TextEntry::make('shelter.name')
                                    ->label('Nome do Abrigo'),
                                TextEntry::make('necessity.name')
                                    ->label('Necessidade'),
                                TextEntry::make('type_id')
                                    ->badge()
                                    ->label('Tipo'),
                                TextEntry::make(''),
                                TextEntry::make('created_at')
                                    ->label('Criado em')
                                    ->dateTime('d/m/Y H:i:s'),
                                TextEntry::make('updated_at')
                                    ->label('Alterado em')
                                    ->dateTime('d/m/Y H:i:s'),
                            ])
                            ->columns([
                                'xl' => 2,
                                '2xl' => 2,
                            ]),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShelterNeeds::route('/'),
            'create' => Pages\CreateShelterNeed::route('/create'),
            'view' => Pages\ViewShelterNeed::route('/{record}'),
            'edit' => Pages\EditShelterNeed::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['shelter', 'necessity']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['shelter.name', 'necessity.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->shelter) {
            $details['Shelter'] = $record->shelter->name;
        }

        if ($record->necessity) {
            $details['Necessity'] = $record->necessity->name;
        }

        return $details;
    }
}
