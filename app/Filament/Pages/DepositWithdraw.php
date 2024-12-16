<?php

namespace App\Filament\Pages;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class DepositWithdraw extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static string $view = 'filament.pages.deposit-withdraw';

    public ?array $data = [];

    public function getTitle(): string
    {
        return __('Deposit / Withdraw / Transfer');
    }

    public static function getNavigationLabel(): string
    {
        return __('Deposit / Withdraw / Transfer');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function submit()
    {
        $data = $this->form->getState();

        $user = User::whereId($data['to_user_id'])->first();

        $by = isset($data['from_user_id'])
        ? User::whereId($data['from_user_id'])->first()
        : Auth::guard('admin')->user();

        $type = match ($data['type']) {
            'DEPOSIT' => TransactionType::DEPOSIT,
            'WITHDRAW' => TransactionType::WITHDRAW,
            'TRANSFER' => TransactionType::TRANSFER,
        };

        $transaction = Transaction::make(
            transactionType: $type,
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
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->options(TransactionType::class)
                    ->required()
                    ->live(),
                Forms\Components\Select::make('from_user_id')
                    ->label('From User')
                    ->options(User::all()->mapWithKeys(function ($user) {
                        return [$user->id => "{$user->name} ({$user->banking_number})"];
                    }))
                    ->searchable()
                    ->reactive()
                    ->required()
                    ->visible(fn ($get) => $get('type') === 'TRANSFER'),
                Forms\Components\Select::make('to_user_id')
                    ->label('To User')
                    ->options(User::all()->mapWithKeys(function ($user) {
                        return [$user->id => "{$user->name} ({$user->banking_number})"];
                    }))
                    ->searchable()
                    ->reactive()
                    ->required(),
                TextInput::make('amount')
                    ->label(__('Amount'))
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->integer()
                    ->placeholder(__('Enter amount')),
            ])->statePath('data');
    }
}
