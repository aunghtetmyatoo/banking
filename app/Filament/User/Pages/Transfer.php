<?php

namespace App\Filament\User\Pages;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Closure;
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

        $user = User::where('banking_number', $data['banking_number'])->first();
        $by = Auth::guard('user')->user();

        Transaction::make(
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
        $authUser = Auth::guard('user')->user();

        return $form
            ->schema([
                Forms\Components\TextInput::make('banking_number')
                    ->label("User's Banking Number")
                    ->required()
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, Closure $fail) use ($authUser) {
                            $use = User::where('banking_number', $value)->first();
                            if (! $use) {
                                $fail('Invalid banking number.');
                            }

                            if ($value === $authUser->banking_number) {
                                $fail('You cannot transfer to yourself.');
                            }
                        },
                    ]),
                Forms\Components\TextInput::make('amount')
                    ->label(__('Amount'))
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->integer()
                    ->placeholder(__('Enter amount'))
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, Closure $fail) use ($authUser) {
                            if ($value > $authUser->balance) {
                                $fail('Balance is not enough.');
                            }
                        },
                    ]),
            ])->statePath('data');
    }
}
