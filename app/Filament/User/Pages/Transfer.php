<?php

namespace App\Filament\User\Pages;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Transfer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.transfer';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function submit()
    {
        $data = $this->form->getState();

        $user = User::whereId($data['to_user_id'])->first();
        $by = Auth::guard('user')->user();

        $transaction = Transaction::make(
            transactionType: TransactionType::TRANSFER,
            amount: $data['amount'],
            user: $user,
            by: $by,
        );

        Notification::make()
            ->title('Success')
            ->body('Transaction completed successfully.')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('to_user_id')
                    ->label('To User')
                    ->options(User::all()->mapWithKeys(function ($user) {
                        return [$user->id => "{$user->name} ({$user->banking_number})"];
                    }))
                    ->searchable()
                    ->reactive()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label(__('Amount'))
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->integer()
                    ->placeholder(__('Enter amount')),
            ])->statePath('data');
    }
}
