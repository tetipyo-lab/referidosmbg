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
use App\Models\ReferredLink;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class ReferrerResource extends Resource
{
    protected static ?string $model = ReferredLink::class;
    protected static ?string $navigationLabel = 'Referrers';  // Cambia el nombre aquí
    protected static ?string $navigationItemGroup = 'Referrers';  // Cambia el nombre aquí
    protected static ?string $navigationIcon = 'heroicon-c-user-group';
    public static function getModelLabel(): string
    {
        return 'Referido';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Referidos';
    }

    // Si quieres personalizar la navegación
    public static function getNavigationLabel(): string
    {
        return 'Mis Referidos';
    }

    // Para cambiar el grupo de navegación
    public static function getNavigationGroup(): ?string
    {
        return 'Referidos'; // o null si no quieres que esté en un grupo
    }
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->roles()->whereIn('name', ['Admin','Agent'])->exists();
    }
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
                    ->unique(table: 'users', column: 'email')
                    ->maxLength(255),
                Forms\Components\TextInput::make('referral_code')
                    ->label('Referral Code')
                    ->default(User::generateReferralCode())
                    ->unique(table: 'users', column: 'referral_code')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (User $user) {
                return $user->where("referred_by", Auth::id());
            });
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
            //'index' => Pages\CreateReferrer::route('/create'),
            'index' => Pages\ListReferrers::route('/'),
            'create' => Pages\CreateReferrer::route('/create'),
            /*'view' => Pages\ViewReferrer::route('/{record}'),
            'edit' => Pages\EditReferrer::route('/{record}/edit'),*/
        ];
    }
}
