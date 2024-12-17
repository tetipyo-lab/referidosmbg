<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Referente')
                    ->options(function () {
                        // Verifica si el usuario autenticado es un Admin
                        if (Auth::user()?->roles()->where('name', 'Admin')->exists()) {
                            return User::all()->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->hidden(fn () => !Auth::user()?->roles()->where('name', 'Admin')->exists()) // Hace el campo invisible si no es Admin
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {//Si soy Agente cargo el referral_code desde la BD
                        $user = User::find($state);
                        $set('referred_code', $user ? $user->referral_code : null);
                    }),
                Forms\Components\TextInput::make('referred_code')
                    ->label('Referred Code')
                    ->readOnly()
                    ->required()
                    ->default(fn ($get) => $get('referred_code') ?: Auth::user()->referral_code),
                Forms\Components\TextInput::make('base_url')
                    ->label('Url')
                    ->placeholder('https://mipagina.com/')
                    ->required()
                    ->maxLength(2083)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        $code = $get('referred_code') ?? '';
                        $base_url = $get('base_url') ?? '';
                        $full_url = "{$base_url}?referred={$code}";
                        $set('url', $full_url);
                    }),
                Forms\Components\TextInput::make('url')
                    ->label('Redirect URL')
                    ->readOnly(),
                Forms\Components\TextInput::make('slug')
                    ->label('Tracking Code')
                    ->default(fn () => Link::generateSlug())
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qr_code_path')
                    ->maxLength(2083)
                    ->default(null)
                    ->visible(false),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Url referente')
                    ->formatStateUsing(fn ($record) => url($record->slug)) // Concatenar la URL base con el slug
                    ->copyable()
                    ->copyMessage('Url referente copiado')
                    ->copyMessageDuration(1500)
                    ->searchable(),
                Tables\Columns\TextColumn::make('qr_code_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('clicks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
