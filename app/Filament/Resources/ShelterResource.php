<?php

namespace App\Filament\Resources;

use App\Enums\ShelterZoneEnum;
use App\Filament\Resources\ShelterResource\Pages;
use App\Models\Shelter\Shelter;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShelterResource extends Resource
{
    protected static ?string $model = Shelter::class;

    protected static ?string $slug = 'shelters';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Shelter $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Shelter $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('name')
                    ->required(),

                Select::make('neighborhood_id')
                    ->relationship('neighborhood', 'name')
                    ->required(),

                Select::make('zone')
                    ->options(ShelterZoneEnum::class)
                    ->required(),

                Checkbox::make('need_volunteers'),

                TextInput::make('address')
                    ->required(),

                TextInput::make('pix')
                    ->required(),

                TextInput::make('phone_number')
                    ->required(),

                TextInput::make('shelter_capacity_count')
                    ->required()
                    ->integer(),

                TextInput::make('sheltered_capacity_count')
                    ->required()
                    ->integer(),

                Checkbox::make('is_pet_friendly'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('neighborhood'),

                TextColumn::make('zone'),

                TextColumn::make('need_volunteers'),

                TextColumn::make('address'),

                TextColumn::make('pix'),

                TextColumn::make('phone_number'),

                TextColumn::make('shelter_capacity_count'),

                TextColumn::make('sheltered_capacity_count'),

                TextColumn::make('is_pet_friendly'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
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
