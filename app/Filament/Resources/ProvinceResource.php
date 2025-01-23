<?php

namespace App\Filament\Resources;


use Filament\Tables;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ProvinceResource\Pages;

class ProvinceResource extends Resource
{
    protected static ?string $model = Province::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'System Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Provinsi';

    protected static ?string $slug = 'provinces';

    protected static bool $shouldRegisterNavigation = true;
    protected static bool $shouldRegisterNavigationWithSidebar = true;

    protected static ?string $modelLabel = 'Provinsi Management';

    protected static ?string $pluralModelLabel = 'Provinsi Management';

    public static function navigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('province_slug')->default(Str::uuid()->toString()),
                TextInput::make('province_name')->maxLength(50)->minLength(3)->required()->label('Nama Provinsi'),
                Toggle::make('province_status')->label('Status')->inline(false)->required(),
                Hidden::make('province_create_by')->default(Auth::id()),
                Hidden::make('province_update_by')->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex()->label('No'),
                TextColumn::make('province_name')->label('Nama Provinsi')->sortable()->searchable(),
                TextColumn::make('province_status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(function (Province $record) {
                        return $record->province_status ? 'success' : 'danger';
                    })
                    ->getStateUsing(function (Province $record) {
                        return $record->province_status ? 'Aktif' : 'Non Aktif';
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
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
            'index' => Pages\ListProvinces::route('/'),
            'create' => Pages\CreateProvince::route('/create'),
            'edit' => Pages\EditProvince::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
