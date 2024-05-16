<?php

namespace App\Filament\Resources;

use App\Enums\VictimStatusEnum;
use App\Filament\Resources\VictimResource\Pages;
use App\Models\Victim\Victim;
use App\Traits\HasTranslatedNavigation;
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
    use HasTranslatedNavigation;

    protected static ?string $model = Victim::class;

    protected static ?string $slug = 'victims';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type_id')
                    ->label(__('Tipo'))
                    ->options(VictimStatusEnum::class)
                    ->required(),

                Select::make('shelter_id')
                    ->label(__('Abrigo'))
                    ->relationship('shelter', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('location')
                    ->label(__('Localização'))
                    ->required(),

                TextInput::make('name')
                    ->label(__('Nome'))
                    ->required(),

                TextInput::make('phone_number')
                    ->label(__('Número de telefone'))
                    ->required(),

                TextInput::make('notes')
                    ->label(__('Notas'))
                    ->required(),

                Placeholder::make('created_at')
                    ->label(__('Criado em'))
                    ->content(fn (?Victim $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label(__('Alterado em'))
                    ->content(fn (?Victim $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status_id')
                    ->label(__('Estado'))
                    ->badge(),

                TextColumn::make('shelter.name')
                    ->label(__('Abrigo'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->label(__('Localização')),

                TextColumn::make('name')
                    ->label(__('Nome'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label(__('Número de telefone')),

                TextColumn::make('address')
                    ->label(__('Endereço')),

                TextColumn::make('notes')
                    ->label(__('Notas')),
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

    protected static function navigationSingular(): string
    {
        return __('Vítima');
    }

    protected static function navigationPlural(): string
    {
        return __('Vítimas');
    }
}
