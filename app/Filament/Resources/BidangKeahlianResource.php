<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidangKeahlianResource\Pages;
use App\Filament\Resources\BidangKeahlianResource\RelationManagers;
use App\Models\Reference\BidangKeahlianModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BidangKeahlianResource extends Resource
{
    protected static ?string $model = BidangKeahlianModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';
    protected static ?string $navigationLabel = 'Bidang Keahlian';
    protected static ?string $slug = 'bidang-keahlian';
    protected static ?string $modelLabel = 'Bidang Keahlian';
    protected static ?string $pluralModelLabel = 'Data Bidang Keahlian';
    protected static ?string $navigationGroup = 'Data Referensi';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_bidang_keahlian')
                    ->label('Nama Bidang Keahlian')
                    ->required()
                    ->maxLength(100)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->state(static function ($rowLoop): string {
                        return (string) $rowLoop->iteration;
                    }),
                Tables\Columns\TextColumn::make('nama_bidang_keahlian')
                    ->label('Nama Bidang Keahlian')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Tidak ada data bidang keahlian yang ditemukan')
            ->emptyStateDescription('Silakan buat data bidang keahlian baru.');
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
            'index' => Pages\ListBidangKeahlians::route('/'),
            'create' => Pages\CreateBidangKeahlian::route('/create'),
            'edit' => Pages\EditBidangKeahlian::route('/{record}/edit'),
        ];
    }
}
