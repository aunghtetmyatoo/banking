<?php

namespace App\Filament\User\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns;
use Filament\Pages\Page;
use HasanAhani\FilamentOtpInput\Components\OtpInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportRedirects\Redirector;

class OtpCode extends Page
{
    use Concerns\InteractsWithFormActions;
    use WithRateLimiting;

    protected static string $layout = 'filament-panels::components.layout.base';

    protected static string $routePath = '/user/otp-code';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.otp-code';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return __('Verify OTP code');
    }

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            OtpInput::make('otp_code')
                ->autofocus()
                ->password()
                ->numberInput(6)
                // ->columnSpanFull()
                ->required(),
        ])->statePath('data');
    }

    public function submit(): ?Redirector
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user = Auth::guard('user')->user();

        if ($data['otp_code'] != $user->otp_code) {
            $this->throwFailureValidationException();
        }

        $user->is_otp_code_required = false;
        $user->save();

        return redirect(str_replace('_', '-', 'user'));
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.otp_code' => __('Wrong Otp!'),
        ]);
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('confirm')
                ->submit('submit'),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }
}
