<?php

use Illuminate\Support\Facades\Storage;

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\File;

new class extends Component
{
    use WithFileUploads;

    private string $openssl;

    private string $storage_path = '../storage/app/private';

    public $certificate;
    public $password;

    #[Locked]
    public ?string $effective_date;

    #[Locked]
    public string $owner;

    #[Locked]
    public string $status;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        if($user->certificate->uploaded){
            $this->effective_date = $user->certificate->effective_date;
            $this->owner = $user->certificate->owner;
        }
    }

    public function hydrate()
    {
        $this->openssl = config('app.openssl-cli', 'openssl');
    }

    /**
     * Update the certificate for the currently authenticated user.
     */
    public function updateCertificate(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'certificate' => 'required|file|max:50|extensions:p12',
            'password' => 'required|string|max:255'
        ]);

        $this->certificate->storeAs('certificates/', $user->id);

        $result = $this->unlock($validated['password'], $user);

        $this->dispatch('certificate-updated', $result);
    }

    /**
     * Opens the certificate
     */
    private function unlock($password, $user)
    {
        $user_id = $user->id;
        $password_esc = escapeshellarg($password);
        $signature = shell_exec(
            "$this->openssl pkcs12 -in $this->storage_path/certificates/$user_id -nodes -passin pass:$password_esc"
        );
        if($signature){
            $file = "$this->storage_path/certificates/$user_id.pem";
            File::put($file, $signature);
            $owner = shell_exec("$this->openssl x509 -in $file -noout -subject") ?? 'Desconocido.';
            $effective_date = $this->formatDate(
                shell_exec("$this->openssl x509 -in $file -noout -enddate")
            );
            File::delete($file);
            $user->certificate->update([
                'uploaded' => true, 'effective_date' => $effective_date, 'owner' => $owner, 'password' => $password
            ]);
            $this->effective_date = $effective_date;
            $this->owner = $owner;
            $this->status = 'Guardado.';
        } else {
            Storage::delete('certificate/'.$user_id);
            $user->certificate->update([
                'uploaded' => false, 'effective_date' => null, 'owner' => 'Desconocido.', 'password' => null
            ]);
            $this->effective_date = null;
            $this->owner = 'Desconocido.';
            $this->status = 'Fallido.';
        }
    }

    private function formatDate($date)
    {
        if(is_null($date)) return null;
        $date = Str::betweenFirst($date, 'notAfter=', '\n');
        return (new DateTime($date))->format('Y-m-d');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Firma digital
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Actualice su certificado de firma digital.
        </p>
    </header>

    <form wire:submit="updateCertificate" class="mt-6 space-y-6">
        <div>
            <x-input-label for="certificate" :value="'Certificado'" />
            <x-text-input wire:model="certificate" id="certificate" name="certificate" type="file" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('certificate')" />
        </div>

        <div>
            <x-input-label for="certificatePassword" :value="'Contraseña'" />
            <x-text-input wire:model="password" id="certificatePassword" name="password" type="password" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="effectiveDateFalseInput" :value="'Fecha de vigencia'" />
            <x-text-input id="effectiveDateFalseInput" wire:model="effective_date" name="effective_date" type="date" class="mt-1 block w-full" readonly />
        </div>

        <div>
            <x-input-label for="ownerFalseInput" :value="'Propietario'" />
            <x-text-input id="ownerFalseInput" wire:model="owner" name="owner" type="text" class="mt-1 block w-full" readonly />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="certificate-updated">
                {{$status}}
            </x-action-message>
        </div>
    </form>
</section>
