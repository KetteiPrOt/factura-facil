<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Rules\String\NumericDigits;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $ruc = '';
    public string $matrix_address = '';
    public $logo;

    #[Locked]
    public ?string $current_logo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->ruc = $user->ruc;
        $this->matrix_address = $user->matrix_address;
        $this->current_logo = $user->logo;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'ruc' => [
                'bail', 'required', 'string', 'size:13', new NumericDigits,
                Rule::unique('users', 'ruc')->ignore(Auth::user()->id)
            ],
            'matrix_address' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024|dimensions: ratio=1/1'
        ]);

        if ($this->logo) {
            if(isset($this->current_logo)) Storage::delete('logos/'.$this->current_logo);
            $this->logo->store(path: 'logos');
            $validated['logo'] = $this->logo->hashName();
            $this->current_logo = $validated['logo'];
        } else {
            unset($validated['logo']); // prevents set null
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="ruc" :value="'RUC'" />
            <x-text-input wire:model="ruc" id="ruc" name="ruc" type="text" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('ruc')" />
        </div>

        <div>
            <x-input-label for="matrix_address" :value="'Dirección matriz'" />
            <x-text-input wire:model="matrix_address" id="matrix_address" name="matrix_address" type="text" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('matrix_address')" />
        </div>

        <div>
            <x-input-label for="logo" :value="'Logo'" />
            <x-text-input wire:model="logo" id="logo" name="logo" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />

            @if($current_logo)
                <div class="my-2 aspect-square flex justify-center sm:block sm:w-1/2">
                    <img src="{{route('profile.logo', ['img' => $current_logo])}}" alt="Logo" class="w-full h-full border rounded" />
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
