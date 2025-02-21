<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmsOutboxResource\Pages;
use App\Filament\Resources\SmsOutboxResource\RelationManagers;
use App\Models\SmsOutbox;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Button;

class SmsOutboxResource extends Resource
{
    protected static ?string $model = SmsOutbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sender')
                ->label('Número remitente')
                ->required()
                ->maxLength(15),
                Forms\Components\TextInput::make('recipient')
                    ->label('Número destino')
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextArea::make('message')
                    ->label('Mensaje')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('message')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
            'index' => Pages\ListSmsOutboxes::route('/'),
            'create' => Pages\CreateSmsOutbox::route('/create'),
            'edit' => Pages\EditSmsOutbox::route('/{record}/edit'),
        ];
    }
}
