<?php

namespace App\Filament\Resources;

use App\Enums\VictimStatusEnum;
use App\Filament\Resources\VictimResource\Pages;
use App\Models\Victim\Victim;
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

class VictimResource extends Resource
{
    protected static ?string $model = Victim::class;

    protected static ?string $slug = 'victims';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Victim $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Victim $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                Select::make('type_id')
                    ->options(VictimStatusEnum::class)
                    ->required(),

                Select::make('shelter_id')
                    ->relationship('shelter', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('location')
                    ->required(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('phone_number')
                    ->required(),

                TextInput::make('notes')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status_id')
                    ->badge(),

                TextColumn::make('shelter.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number'),

                TextColumn::make('address'),

                TextColumn::make('notes'),
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
            'index' => Pages\ListVictims::route('/'),
            'create' => Pages\CreateVictim::route('/create'),
            'edit' => Pages\EditVictim::route('/{record}/edit'),
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
        return parent::getGlobalSearchEloquentQuery()->with(['shelter']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'shelter.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->shelter) {
            $details['Shelter'] = $record->shelter->name;
        }

        return $details;
    }
}
