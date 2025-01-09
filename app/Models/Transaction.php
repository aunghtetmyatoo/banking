<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Exceptions\AmountNotEnoughException;
use App\Exceptions\TransactionFailedException;
use Carbon\Carbon;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'type' => TransactionType::class,
            'created_at' => 'datetime:Y-m-d H:i:s.u',
        ];
    }

    public function by(): MorphTo
    {
        return $this->morphTo();
    }

    public function from(): MorphTo
    {
        return $this->morphTo();
    }

    public function to(): MorphTo
    {
        return $this->morphTo();
    }

    public static function make(TransactionType $transactionType, int $amount, Admin|User $user, Admin|User $by, ?string $transactionId = null, ?Carbon $transactionTime = null): ?Transaction
    {
        try {
            $transaction = DB::transaction(function () use ($transactionType, $amount, $by, $user, $transactionId, $transactionTime) {
                $fromUser = $by;
                $toUser = $user;
                $fromBalanceBefore = null;
                $fromBalanceAfter = null;
                $toBalanceBefore = null;
                $toBalanceAfter = null;
                $fromUserLocked = null;
                $toUserLocked = null;

                if ($fromUser) {
                    if ($transactionType === TransactionType::DEPOSIT) {
                        $fromUserLocked = SystemBalance::lockForUpdate()->first();
                        $fromBalanceBefore = $fromUserLocked->balance;
                    } elseif ($transactionType === TransactionType::WITHDRAW) {
                        $fromUserLocked = get_class($user)::lockForUpdate()->find($user->id);
                        $fromBalanceBefore = $fromUserLocked->balance;
                    } else {
                        $fromUserLocked = get_class($fromUser)::lockForUpdate()->find($fromUser->id);
                        $fromBalanceBefore = $fromUserLocked->balance;
                    }

                    if ($fromBalanceBefore < $amount) {
                        throw new AmountNotEnoughException;
                    }

                    $fromBalanceAfter = $fromBalanceBefore - $amount;

                    $fromUserLocked->update([
                        'balance' => $fromBalanceAfter,
                    ]);
                }

                if ($toUser) {
                    if ($transactionType === TransactionType::WITHDRAW) {
                        $toUserLocked = SystemBalance::lockForUpdate()->first();
                        $toBalanceBefore = $toUserLocked->balance;
                    } else {
                        $toUserLocked = get_class($toUser)::lockForUpdate()->find($toUser->id);
                        $toBalanceBefore = $toUserLocked->balance;
                    }

                    $toBalanceAfter = $toBalanceBefore + $amount;

                    $toUserLocked->update([
                        'balance' => $toBalanceAfter,
                    ]);
                }

                $transactionTime = $transactionTime ? $transactionTime->format('Y-m-d H:i:s.u') : now()->format('Y-m-d H:i:s.u');

                $transaction = new Transaction;
                $transaction->transaction_id = $transactionId ?? $transactionType->getPrefix().get_random_digit(10);
                $transaction->type = $transactionType;
                $transaction->amount = $amount;
                $transaction->by()->associate($by);
                $transaction->to()->associate($toUserLocked);
                $transaction->to_balance_before = $toBalanceBefore;
                $transaction->to_balance_after = $toBalanceAfter;
                $transaction->from()->associate($fromUserLocked);
                $transaction->from_balance_before = $fromBalanceBefore;
                $transaction->from_balance_after = $fromBalanceAfter;
                $transaction->created_at = $transactionTime;
                $transaction->updated_at = $transactionTime;
                $transaction->save();
                $transaction->refresh();

                return $transaction;
            }, 3);
        } catch (Exception $e) {
            Notification::make()
                ->title('Fail')
                ->body('Transaction Failed.')
                ->danger()
                ->send();

            // throw $e;
            throw new TransactionFailedException;
        }

        return $transaction;
    }
}
