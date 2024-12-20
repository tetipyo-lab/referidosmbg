<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;



class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->hiddenOn('edit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('referral_code')
                    ->label('Referral Code')
                    ->default(User::generateReferralCode())
                    ->readOnlyOn('edit'),
                Forms\Components\Select::make('referred_by')
                    ->label('Referred By')
                    ->relationship('referredBy', 'name')
                    ->searchable(),
                Forms\Components\Select::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name') // Relación con el modelo Role y mostrar el campo 'name'
                    ->multiple(false) // Permitir seleccionar solo un rol
                    ->preload() // Cargar los datos al cargar el formulario
                    ->required(),
                // Campo para el teléfono
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->required()
                    ->tel() // Campo de tipo teléfono
                    ->maxLength(15)
                    ->placeholder('+1 (555) 123-4567'),

                // Campo para Agent NPN
                Forms\Components\TextInput::make('agent_npn')
                    ->label('NPN del Agente')
                    ->required()
                    ->numeric() // Asegura que solo permita números
                    ->maxLength(20),

                // Campo para la foto de perfil
                Forms\Components\FileUpload::make('profile_photo')
                    ->label('Foto de Perfil')
                    ->image()
                    ->directory('profile_photos')
                    ->disk('public')
                    ->visibility('public')
                    ->hint('Sube una imagen para tu foto de perfil')
                    ->rules('mimes:jpeg,png,jpg', 'max:2048')
                    ->imageEditor()
                    ->imageEditorViewportWidth('1920')
                    ->imageEditorViewportHeight('1080'),

                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->visible(false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('referral_code')
                    ->searchable()
                    ->label('Referral Code'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referredBy.name')
                    ->label('Referred By')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable(),    
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
