<?php

namespace App\Filament\User\Pages\Auth;

use App\Models\State;
use App\Models\Township;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Auth\Register as BaseRegister;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Registration extends BaseRegister
{
    protected ?string $maxWidth = '3xl';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([ // Create a grid with 2 columns

                            $this->getNameFormComponent(),
                            $this->getUsernameFormComponent(),
                            $this->getMobileFormComponent(),
                            $this->getEmailFormComponent(),
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                            $this->getStateFormComponent(),
                            $this->getTownshipFormComponent(),
                        ]),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->placeholder('mgmg123')
            ->rules(['required', 'string', 'max:255', 'unique:users,username']);
    }

    protected function getMobileFormComponent(): Component
    {
        return TextInput::make('mobile')
            ->label('Mobile')
            ->required()
            ->placeholder('09xxxxxxxxx')
            ->rules(['required', 'string', 'max:255', 'unique:users,mobile']);
    }

    protected function getStateFormComponent(): Component
    {
        return Forms\Components\Select::make('state_id')
            ->label('State')
            ->options(State::all()->pluck('name', 'id'))
            ->searchable()
            ->required();
    }

    protected function getTownshipFormComponent(): Component
    {
        return Forms\Components\Select::make('township_id')
            ->label('Township')
            ->options(fn (Get $get): Collection => Township::query()
                ->where('state_id', $get('state_id'))
                ->pluck('name', 'id'))
            ->searchable()
            ->required();
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        $otpCode = config('app.otp') ? rand(100000, 999999) : '111111';

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'mobile' => $data['mobile'],
            'state_id' => $data['state_id'],
            'township_id' => $data['township_id'],
            'banking_number' => generate_banking_number(),
            'otp_code' => $otpCode,
        ]);

        Auth::login($user);

        if (config('app.otp')) {
            $this->sendWithBoomsSms("Your verification code for Banking System is {$otpCode}", $data['mobile']);
        }

        return app(RegistrationResponse::class);
    }

    private function sendWithBoomsSms(string $text, string $mobile): void
    {
        $client = new Client;
        $client->request('POST', config('appconstant.BOOMS_SMS_API'), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.config('appconstant.BOOMS_SMS_TOKEN'),
            ],
            'form_params' => [
                'from' => 'Banking System',
                'text' => $text,
                'to' => $mobile,
            ],
        ]);
    }
}
