<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferredLinkResource\Pages;
use App\Filament\Resources\ReferredLinkResource\RelationManagers;
use App\Models\ReferredLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;

class ReferredLinkResource extends Resource
{
    protected static ?string $model = ReferredLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Referrer')
                    ->options(function () {
                        // Verifica si el usuario autenticado es un Admin
                        if (Auth::user()?->roles()->where('name', 'Admin')->exists()) {
                            return User::all()->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->hidden(fn () => !Auth::user()?->roles()->where('name', 'Admin')->exists()) // Hace el campo invisible si no es Admin
                    ->required(),
                Forms\Components\Select::make('link_id')
                    ->label('Link') // Etiqueta para el campo
                    ->relationship('link', 'url', fn ($query) => $query->where('is_active', true)) // Relación con la tabla links
                    ->required()
                    ->preload()
                    ->placeholder('Select an active link'), // Placeholder
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('link_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_links')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->default(true),
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
            'index' => Pages\ListReferredLinks::route('/'),
            'create' => Pages\CreateReferredLink::route('/create'),
            'edit' => Pages\EditReferredLink::route('/{record}/edit'),
        ];
    }
}
