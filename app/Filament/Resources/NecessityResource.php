<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NecessityResource\Pages;
use App\Models\Necessity\Necessity;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ViewAction;

class NecessityResource extends Resource
{
    protected static ?string $model = Necessity::class;

    protected static ?string $navigationGroup = 'Necessidades';
    protected static ?string $modelLabel = 'Necessidade';
    protected static ?string $pluralLabel = 'Necessidades';

    protected static ?string $slug = 'necessities';

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Necessidades')
                    ->description('Informe as necessidades que podem ser cadastradas.')
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),

                        Select::make('type_id')
                            ->label('Tipo')
                            ->relationship('type', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Lista de Necessidades')
            ->description('Explore nossa lista de necessidades')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type.name')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),

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
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),
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
                Tabs::make('Necessity Details')
                    ->columnSpan('full')
                    ->tabs([
                        Tab::make('Detalhes')
                            ->icon('heroicon-o-hand-raised')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nome'),
                                TextEntry::make('type.name')
                                    ->label('Tipo'),
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
            'index' => Pages\ListNecessities::route('/'),
            'create' => Pages\CreateNecessity::route('/create'),
            'view' => Pages\ViewNecessity::route('/{record}'),
            'edit' => Pages\EditNecessity::route('/{record}/edit'),
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
        return parent::getGlobalSearchEloquentQuery()->with(['type']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'type.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->type) {
            $details['Type'] = $record->type->name;
        }

        return $details;
    }
}
