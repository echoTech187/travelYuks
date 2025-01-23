<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Input\Input;
use App\Filament\Resources\CityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CityResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $navigationLabel = 'Kota';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('city_name')->maxLength(50)->minLength(3)->required()->label('Kota'),
                Select::make('province_id')->relationship('province', 'province_name')->required()->label('Provinsi'),
                Toggle::make('city_status')->required()->label('Status')->inline(false),
                Hidden::make('city_slug')->required()->label('Slug')->default(Str::uuid()->toString()),
                Hidden::make('city_create_by')->default(Auth::id()),
                Hidden::make('city_update_by')->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex()->label('No'),
                TextColumn::make('city_name')->label('Kota')->sortable()->searchable(),
                TextColumn::make('province_id')->label('Provinsi')->sortable()->searchable()->formatStateUsing(fn (string $state) => Province::find($state)->province_name),
                TextColumn::make('city_status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (City $record) {
                        return $record->city_status ? 'Aktif' : 'Tidak Aktif';
                    })->badge()
                    ->color(function (City $record) {
                        return $record->city_status ? 'success' : 'danger';
                    })
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
