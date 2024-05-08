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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShelterResource extends Resource
{
    protected static ?string $model = Shelter::class;

    protected static ?string $modelLabel = 'Abrigo';

    protected static ?string $pluralLabel = 'Abrigos';

    protected static ?string $slug = 'shelters';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
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
                    ->required(),

                Select::make('need_volunteers')
                    ->options(NeedVolunteersEnum::class),

                TextInput::make('address')
                    ->label('Endereço')
                    ->required(),

                TextInput::make('phone_number')
                    ->label('Número de telefone')
                    ->mask('(99) 99999-9999')
                    ->required(),

                TextInput::make('pix')
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

                Toggle::make('need_volunteers')
                    ->inline(false)
                    ->label('Precisa de voluntários'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->badge()
                    ->label('Zona'),

                TextColumn::make('need_volunteers')
                    ->badge()
                    ->label('Precisa de voluntários'),

                TextColumn::make('phone_number')
                    ->label('Número de telefone'),

                TextColumn::make('shelter_capacity_count')
                    ->sortable()
                    ->label('Capacidade do abrigo'),

                TextColumn::make('sheltered_capacity_count')
                    ->sortable()
                    ->label('Capacidade de abrigados'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShelters::route('/'),
            'create' => Pages\CreateShelter::route('/create'),
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
