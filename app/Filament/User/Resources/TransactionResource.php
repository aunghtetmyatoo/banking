<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
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
        $user = Auth::guard('user')->user();

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereMorphRelation('from', get_class($user), 'from_id', $user->id)
                ->orWhereMorphRelation('to', get_class($user), 'to_id', $user->id)
                ->orderBy('created_at', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('by.name'),
                Tables\Columns\TextColumn::make('from.name'),
                Tables\Columns\TextColumn::make('to.name'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTransactions::route('/'),
        ];
    }

    protected static function getTableQuery(): Builder
    {
        $user = Auth::guard('user')->user();

        return parent::getTableQuery()->whereMorphRelation('from', get_class($user), 'from', $user->id);
    }
}
