<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('User Info')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\Grid::make(2)
                                ->schema([
                                    Infolists\Components\TextEntry::make('banking_number')->badge(),
                                    Infolists\Components\TextEntry::make('balance')->badge(),
                                    Infolists\Components\TextEntry::make('name'),
                                    Infolists\Components\TextEntry::make('username'),
                                    Infolists\Components\TextEntry::make('email'),
                                    Infolists\Components\TextEntry::make('mobile'),
                                    Infolists\Components\TextEntry::make('state.name')
                                        ->label('State')
                                        ->badge(),
                                    Infolists\Components\TextEntry::make('township.name')
                                        ->label('Township')
                                        ->badge(),
                                    Infolists\Components\TextEntry::make('address'),
                                ]),
                        ])
                            ->from('lg'),
                    ]),
            ]);
    }

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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->sortable(),
                Tables\Columns\TextColumn::make('banking_number'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('Active'))
                    ->onIcon('heroicon-o-lock-open')
                    ->offIcon('heroicon-o-lock-closed'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
