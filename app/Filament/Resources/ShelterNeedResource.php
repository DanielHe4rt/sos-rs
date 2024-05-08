<?php

namespace App\Filament\Resources;

use App\Enums\ShelterNeedTypeEnum;
use App\Filament\Resources\ShelterNeedResource\Pages;
use App\Models\Shelter\ShelterNeed;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

                TextColumn::make('type_id', )
                    ->label('Tipo')
                    ->badge()
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
