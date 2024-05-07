<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShelterNeedResource\Pages;
use App\Models\Shelter\ShelterNeed;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShelterNeedResource extends Resource
{
    protected static ?string $model = ShelterNeed::class;

    protected static ?string $slug = 'shelter-needs';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?ShelterNeed $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?ShelterNeed $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                Select::make('shelter_id')
                    ->relationship('shelter', 'name')
                    ->searchable()
                    ->required(),

                Select::make('necessity_id')
                    ->relationship('necessity', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('type_id')
                    ->required()
                    ->integer(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shelter.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('necessity.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type_id'),
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
            'index' => Pages\ListShelterNeeds::route('/'),
            'create' => Pages\CreateShelterNeed::route('/create'),
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
