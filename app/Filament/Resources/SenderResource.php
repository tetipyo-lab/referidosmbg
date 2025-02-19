<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SenderResource\Pages;
use App\Filament\Resources\SenderResource\RelationManagers;
use App\Models\Sender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SenderResource extends Resource
{
    protected static ?string $model = Sender::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Si quieres personalizar la navegación
    public static function getNavigationLabel(): string
    {
        return 'Remitentes';
    }

    // Para cambiar el grupo de navegación
    public static function getNavigationGroup(): ?string
    {
        return 'Mensajes de Texto'; // o null si no quieres que esté en un grupo
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->roles()->whereIn('name', ['Admin','ATC Agent'])->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('device_id')
                    ->maxLength(5),
                Forms\Components\Toggle::make('is_active')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_id')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSenders::route('/'),
            'create' => Pages\CreateSender::route('/create'),
            'edit' => Pages\EditSender::route('/{record}/edit'),
        ];
    }
}
