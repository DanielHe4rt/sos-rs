<?php

namespace App\Filament\Resources;

use App\Clients\Airtable\Enums\NeedVolunteersEnum;
use App\Enums\ShelterZoneEnum;
use App\Filament\Resources\ShelterResource\Pages;
use App\Models\Shelter\Shelter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms;

class ShelterResource extends Resource
{
    protected static ?string $model = Shelter::class;

    protected static ?string $navigationGroup = 'Abrigo';

    protected static ?string $modelLabel = 'Abrigo';

    protected static ?string $pluralLabel = 'Abrigos';

    protected static ?string $slug = 'shelters';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações gerais')
                    ->description(__('Informações gerais sobre o abrigo.'))
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->columnSpanFull()
                            ->required(),

                        TextInput::make('address')
                            ->label('Endereço')
                            ->columnSpanFull()
                            ->required(),

                        Select::make('neighborhood_id')
                            ->label('Bairro')
                            ->relationship('neighborhood', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('zone')
                            ->label('Zona')
                            ->options(ShelterZoneEnum::class)
                            ->native(false)
                            ->required(),

                        Select::make('need_volunteers')
                            ->label('Precisa de voluntários')
                            ->options(NeedVolunteersEnum::class),

                        TextInput::make('phone_number')
                            ->label('Número de telefone')
                            ->mask('(99) 99999-9999')
                            ->required(),

                        TextInput::make('pix')
                            ->label('Chave PIX')
                            ->columnSpanFull()
                            ->required(),

                        TextInput::make('shelter_capacity_count')
                            ->label('Capacidade do abrigo')
                            ->required()
                            ->integer(),

                        TextInput::make('sheltered_capacity_count')
                            ->label('Capacidade de abrigados')
                            ->required()
                            ->integer(),

                        Toggle::make('is_pet_friendly')
                            ->inline(false)
                            ->label('Aceita animais de estimação'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Lista de Abrigos')
            ->description('Explore a lista de abrigos disponíveis para acolhimento.')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('neighborhood.name')
                    ->label('Bairro')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('zone')
                    ->sortable()
                    ->badge()
                    ->label('Zona'),

                TextColumn::make('need_volunteers')
                    ->badge()
                    ->label('Precisa de voluntários'),

                TextColumn::make('phone_number')
                    ->label('Telefone'),

                TextColumn::make('shelter_capacity_count')
                    ->sortable()
                    ->label('Capacidade do abrigo')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sheltered_capacity_count')
                    ->sortable()
                    ->label('Capacidade de abrigados')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_pet_friendly')
                    ->label('Aceita Pets')
                    ->boolean(),

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
                SelectFilter::make('zone')
                    ->label('Zona')
                    ->options(ShelterZoneEnum::class)
                    ->multiple()
                    ->native(false),
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
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nome'),
                                TextEntry::make(''),
                                TextEntry::make('address')
                                    ->label('Endereço'),
                                TextEntry::make(''),
                                TextEntry::make('neighborhood.name')
                                    ->label('Bairro'),
                                TextEntry::make('neighborhood.name')
                                    ->label('Bairro'),
                                TextEntry::make('zone')
                                    ->label('Zona'),
                                TextEntry::make('need_volunteers')
                                    ->label('Precisa de voluntários'),
                                TextEntry::make('phone_number')
                                    ->label('Número de telefone'),
                                TextEntry::make('pix')
                                    ->label('Chave PIX'),
                                TextEntry::make('shelter_capacity_count')
                                    ->label('Capacidade do abrigo'),
                                TextEntry::make('sheltered_capacity_count')
                                    ->label('Capacidade de abrigados'),
                                IconEntry::make('is_pet_friendly')
                                    ->label('Aceita animais de estimação')
                                    ->boolean(),
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
            'index' => Pages\ListShelters::route('/'),
            'create' => Pages\CreateShelter::route('/create'),
            'view' => Pages\ViewShelter::route('/{record}'),
            'edit' => Pages\EditShelter::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
