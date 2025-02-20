<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmsInboxResource\Pages;
use App\Filament\Resources\SmsInboxResource\RelationManagers;
use App\Models\SmsInbox;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Auth;

class SmsInboxResource extends Resource
{
    protected static ?string $model = SmsInbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // Si quieres personalizar la navegación
    public static function getModelLabel(): string
    {
        return 'SMS Recibido';
    }

    public static function getPluralModelLabel(): string
    {
        return 'SMS Recibidos';
    }

    public static function getNavigationLabel(): string
    {
        return 'SMS Recibidos';
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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),
                Forms\Components\TextInput::make('sender')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('recipient')
                    ->required()
                    ->maxLength(20),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('seen')
                    ->required(),
                Forms\Components\DateTimePicker::make('received_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->searchable(),
                Tables\Columns\IconColumn::make('seen')
                    ->boolean(),
                Tables\Columns\TextColumn::make('received_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('received_at','desc')
            ->filters([
                Filter::make('received_at')
                    ->form([
                        DatePicker::make('desde')->label('Desde'),
                        DatePicker::make('hasta')->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['desde'], fn($q) => $q->whereDate('received_at', '>=', $data['desde']))
                            ->when($data['hasta'], fn($q) => $q->whereDate('received_at', '<=', $data['hasta']));
                    }),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSmsInboxes::route('/'),
            //'create' => Pages\CreateSmsInbox::route('/create'),
            //'edit' => Pages\EditSmsInbox::route('/{record}/edit'),
        ];
    }
}
