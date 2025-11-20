<?php

namespace App\Filament\Imports;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('phone')
                ->rules(['max:255']),
            ImportColumn::make('google_scholars')
                ->rules(['max:255']),
            ImportColumn::make('scopus')
                ->rules(['max:255']),
            ImportColumn::make('affiliation')
                ->rules(['max:255']),
            ImportColumn::make('department')
                ->rules(['max:255']),
            ImportColumn::make('country')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->rules(['nullabel', 'in:active,inactive']),
            ImportColumn::make('email_verified_at')
                ->rules(['nullable', 'date']),
            ImportColumn::make('password')
                ->rules(['nullable', 'max:255']),
        ];
    }

    public function resolveRecord(): ?User
    {
        return User::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }
    
    protected function beforeFill(): void
    {

    }

    protected function afterFill(): void
    {
        // Default values
        $this->record->status = 'active';
        $this->record->email_verified_at = now();
        $plainPassword = 'password2025';
        $this->record->password = bcrypt($plainPassword);

        // Simpan user dulu
        $this->record->save();

        // Tangkap role dari CSV
        if (!empty($this->data['roles'])) {
            // Split multiple role dengan koma
            $roles = array_map('trim', explode(',', $this->data['roles']));

            // Buat role jika belum ada
            foreach ($roles as $roleName) {
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);
            }

            // Assign semua role ke user
            $this->record->syncRoles($roles); // hapus role lama, set role baru
            // atau pakai $this->record->assignRole($roles) → tambah tanpa hapus role lama
        }
    }

    protected function afterSave(): void
    {

    }



    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
