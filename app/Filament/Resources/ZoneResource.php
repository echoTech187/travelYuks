<?php

namespace App\Filament\Resources;


use Closure;
use App\Models\City;
use App\Models\Zone;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Query\Builder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\ZoneResource\Pages;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\Factories\Relationship;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;

class ZoneResource extends Resource
{
    use HasPageSidebar;
    protected static ?string $model = Zone::class;

    protected static ?string $navigationIcon = 'heroicon-o-ellipsis-horizontal-circle';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Zona Penjualan';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('zone_slug')
                    ->default(Str::uuid()->toString()),
                TextInput::make('zone_name')
                    ->maxLength(50)
                    ->label('Nama Zona')
                    ->minLength(3)
                    ->required(),
                Select::make('provinces_id')
                    ->options(Province::query()->pluck('province_name', 'id'))
                    ->relationship('provinces', 'province_name')
                    ->label('Provinsi')
                    ->required()
                    ->reactive()
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->afterStateUpdated(fn(Set $set, Get $get) => $set('city_id', [])),
                CheckboxList::make('city_id')
                    ->options(
                        fn(Get $get): Collection => $get('provinces_id') === '' ? [] : City::query()->where('province_id', $get('provinces_id'))->pluck('city_name', 'id')
                    )
                    ->relationship('cities', 'city_name')
                    ->required()
                    ->label('Kota')
                    ->reactive(),
                Toggle::make('zone_status')
                    ->label('Status')
                    ->inline(false)
                    ->required(),
                Hidden::make('zone_create_by')
                    ->default(Auth::id()),
                Hidden::make('zone_update_by')
                    ->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex()->label('No'),
                TextColumn::make('zone_name')->label('Nama Zona')->searchable()->sortable(),
                TextColumn::make('province_id')->label('Provinsi')->searchable()->sortable()->formatStateUsing(fn(string $state) => Province::find($state)->province_name),
                TextColumn::make('city_id')->label('Kota')->searchable()->sortable()->formatStateUsing(fn(string $state) => City::find($state)->city_name),
                TextColumn::make('zone_status')->label('Status')->searchable()->sortable()->getStateUsing(fn(Zone $record) => $record->zone_status ? 'Aktif' : 'Tidak Aktif')->badge()->color(fn(Zone $record) => $record->zone_status ? 'success' : 'danger'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListZones::route('/'),
            'create' => Pages\CreateZone::route('/create'),
            'edit' => Pages\EditZone::route('/{record}/edit'),

        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    
}
