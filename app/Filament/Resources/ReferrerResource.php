<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferrerResource\Pages;
use App\Filament\Resources\ReferrerResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\Link;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ReferrerResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Referrers';  // Cambia el nombre aquí
    protected static ?string $navigationItemGroup = 'Referrers';  // Cambia el nombre aquí
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->required()
                    ->tel() // Campo de tipo teléfono
                    ->maxLength(15)
                    ->placeholder('+15551234567'),    
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('referral_code')
                    ->label('Referral Code')
                    ->default(User::generateReferralCode())
                    ->readOnlyOn('edit'),
                Forms\Components\Select::make('link_id')
                    ->label('Link')
                    ->options(function () {
                        return Link::where('is_active', true)
                            ->paginate(10) // Limita los resultados a 10 elementos por página
                            ->pluck('url', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->preload()
                    ->placeholder('Select an active link')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\CreateReferrer::route('/create'),
            /*'index' => Pages\ListReferrers::route('/'),
            'create' => Pages\CreateReferrer::route('/create'),
            'view' => Pages\ViewReferrer::route('/{record}'),
            'edit' => Pages\EditReferrer::route('/{record}/edit'),*/
        ];
    }
}
