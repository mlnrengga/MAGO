<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Auth\AdminModel;
use App\Models\UserModel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class AdminResource extends Resource
{
    protected static ?string $model = AdminModel::class;
    protected static ?string $navigationLabel = 'Manajemen Admin';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nip')->required(),
            Forms\Components\Select::make('id_user')
                ->label('Data Pengguna')
                ->options(UserModel::pluck('nama', 'id_user'))
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('user.nama')->label('Role'),
                Tables\Columns\TextColumn::make('user.no_telepon')->label('No Telepon'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('resetPassword')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(function (AdminModel $record) {
                        $record->user->update(['password' => bcrypt('password_baru')]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
