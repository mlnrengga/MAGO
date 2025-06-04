<?php

namespace App\Filament\Pembimbing\Resources;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;
use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\RelationManagers;
use App\Models\MonitoringaktivitasMagang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonitoringaktivitasMagangResource extends Resource
{
    // protected static ?string $model = MonitoringaktivitasMagang::class;

    protected static ?string $navigationLabel = 'Monitoring Magang';
    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $modelLabel = 'Manajemen - Pengguna';
    protected static ?string $pluralModelLabel = 'Data Pengguna';
    protected static ?string $navigationGroup = 'Monitoring & Mahasiswa';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListMonitoringaktivitasMagangs::route('/'),
            'create' => Pages\CreateMonitoringaktivitasMagang::route('/create'),
            'edit' => Pages\EditMonitoringaktivitasMagang::route('/{record}/edit'),
        ];
    }
}
