<?php

namespace App\Livewire;


use Exception;
use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use App\Models\JournalUser;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;

class FormCall extends Component implements HasForms
{
    use InteractsWithForms;
    
    public ?array $data = [];
    public ?array $journalUser = [];
    public $focusAndScopes = [];
    public $roles = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form($form)
    {
        return $form
            ->schema([
                // user detail
                Section::make('Account Details')
                    ->description('Provide your account details to access your login credentials')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name & Title')
                            ->required(),
                        PhoneInput::make('phone')
                            ->label('Whatsapp Number')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->required()
                    ])->columnSpanFull()
                    ->statePath('data'),

                    // user detail
                    Section::make('Additional Information')
                    ->description('Provide your personal details for your profile')
                        ->schema([
                            TextInput::make('google_scholars')
                                ->label('Google Scholars')
                                ->url()
                                ->required(),
                            TextInput::make('scopus')
                                ->label('Scopus ID')
                                ->url()
                                ->required(),
                            TextInput::make('orchid')
                                ->label('ORCHID iD')
                                ->placeholder('0000-0001-2345-6789')
                                ->mask('9999-9999-9999-9999')
                                ->helperText('Enter your 16-digit ORCHID iD'),
                            TextInput::make('department')
                                    ->label('Faculty / Department')
                                    ->required(),
                            TextInput::make('affiliation')
                                ->label('University / Institution')
                                ->required(),
                            Select::make('country')
                                ->label('Country')
                                ->required()
                                ->options(config('countries'))
                                ->searchable()
                                ->preload()
                                ->placeholder('Select country'),
                        ])->columnSpanFull()
                        ->statePath('data'),

                        Section::make('Roles & Expertise')
                            ->description('Select your desired role and areas of expertise')
                            ->schema([
                                Radio::make('Apply As')
                                    ->label('Apply As')
                                    ->required()
                                    ->options([
                                        'Reviewer' => 'Reviewer',
                                        'Editor' => 'Editor',
                                    ])->statePath('roles'),
                            ])->columnSpanFull(),
                        
                        Section::make('Review Interests')
                            ->description('Please indicate your areas of expertise for reviewing. This information will help us match you with manuscripts that best align with your background and interests.')
                            ->schema([
                                Select::make('focusAndScopes')
                                    ->label('Topics of Interest')
                                    ->helperText('You can select one or more Focus and Scope.')
                                    ->multiple()
                                    ->options(\App\Models\FocusAndScope::pluck('name', 'id'))
                                    ->required(),
                                
                                // CheckboxList::make('journals')
                                //     ->label('Select Journals')
                                //     ->searchable()
                                //     ->required()
                                //     ->options(
                                //         Journal::orderBy('title')
                                //             ->get()
                                //             ->mapWithKeys(fn($j) => [$j->id => "{$j->title} ({$j->singkatan})"])
                                //             ->toArray()
                                // )->statePath('journalUser'),
                            ]),

                        Section::make('Upload Files')
                            ->description('Upload your profile picture and CV (PDF format) to help us get to know you better.')
                            ->schema([
                                FileUpload::make('profile_photo')
                                    ->image()
                                    ->label('Profile Picture')
                                    ->disk('public')
                                    ->required()
                                    ->directory('photo_profile')
                                    ->visibility('public'),
                                AdvancedFileUpload::make('cv')
                                    ->label('Curriculum Vitae')
                                    ->disk('public')
                                    ->directory('cv')
                                    ->required()
                                    ->visibility('public')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(1024 * 1024 * 10) // 10MB
                                    ->pdfPreviewHeight(400) // Customize preview height
                                    ->pdfDisplayPage(1) // Set default page
                                    ->pdfToolbar(true) // Enable toolbar
                                    ->pdfZoomLevel(100) // Set zoom level
                                    ->pdfFitType(PdfViewFit::FIT) // Set fit type
                                    ->pdfNavPanes(true) // Enable navigation panes
                            ])->statePath('data'),

                            Section::make('Agreement')
                                ->description('By clicking the submit button, you agree to the terms and conditions.')
                                ->schema([
                                    Checkbox::make('agreement.objectivity')
                                        ->label('I will review manuscripts objectively, fairly, and confidentially, without using the content for personal advantage')
                                        ->required(),
                                    Checkbox::make('agreement.conflict_of_interest')
                                        ->label('I will disclose any potential conflict of interest before accepting a review assignment.')
                                        ->required(),
                                    Checkbox::make('agreement.constructive_feedback')
                                        ->label('I will provide constructive, clear, and timely feedback within my area of expertise.')
                                        ->required(),
                                    Checkbox::make('agreement.ethics')
                                        ->label('I agree to follow the reviewer guidelines and uphold the journal publication ethics.')
                                        ->required(),
                                ])
                                ->columnSpanFull()
                                ->statePath('data'),

                            Section::make('Signature')
                                ->description('Please provide your digital signature below to confirm your agreement to the terms and conditions outlined above.')
                                ->schema([
                                    \App\Forms\Components\SignaturePad::make('signature')
                                        ->label('Your Signature')
                                        ->required(),
                                ])
                                ->columnSpanFull()
                                ->statePath('data'),
                                
            ]);
        }
    
    public function create(): void
    {
        try {
            // Validasi form
            $this->form->validate();
            $data = $this->form->getState();
            
            DB::beginTransaction();
            
            // Pisahkan data user dari data relasi
            $userData = $data['data'];
            $focusAndScopesData = $this->focusAndScopes;
            $journalUserData = $data['journalUser'] ?? [];
            $rolesData = $this->roles;
            
            // Ekstrak agreement & signature dari userData
            $agreementData = $userData['agreement'] ?? [];
            $signatureData = $userData['signature'] ?? null;
            
            // Hapus agreement dan signature dari userData sebelum create user
            unset($userData['agreement']);
            unset($userData['signature']);
            
            // Hash password
            if (isset($userData['password'])) {
                $userData['password'] = bcrypt($userData['password']);
            }
            
            // Buat user baru
            $user = User::create($userData);
            
            // Simpan relasi many-to-many dengan focus_and_scopes
            if (!empty($focusAndScopesData)) {
                $user->focusAndScopes()->attach($focusAndScopesData);
            }
            
            // Simpan relasi many-to-many dengan journals
            if (!empty($journalUserData)) {
                foreach ($journalUserData as $journalId) {
                    $position = $rolesData === 'Editor' ? 'Editor' : 'Reviewer';
                    $lastSortOrder = JournalUser::where('journal_id', $journalId)
                        ->where('position', $position)
                        ->max('sort_order') ?? 0;
                    
                    foreach ($journalUserData as $journalId) {
                        $user->journals()->attach($journalId, [
                            'position' => $position,
                            'sort_order' => $lastSortOrder + 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
            }
            }
            
            // Assign role menggunakan Spatie Permission
            if (!empty($rolesData) && is_string($rolesData)) {
                $roleName = strtolower($rolesData);
                // Pastikan role exists sebelum assign
                if (Role::where('name', $roleName)->exists()) {
                    $user->assignRole($roleName);
                }
            }
            
            // Simpan Agreement dan Signature ke tabel agreements
            if (!empty($agreementData) || !empty($signatureData)) {
                \App\Models\Agreement::create([
                    'user_id' => $user->id,
                    'agreement' => $agreementData, // Akan disimpan sebagai JSON
                    'signature' => $signatureData, // Base64 string
                ]);
            }
            
            DB::commit();
            
            // Tampilkan notifikasi sukses
            Notification::make()
                ->title('Registration Successful!')
                ->body('Your account has been created successfully. Please wait for admin approval.')
                ->success()
                ->send();
            
            // Reset form
            $this->form->fill();
            redirect()->route('filament.admin.auth.login');
            
        } catch (Exception $e) {
            DB::rollBack();
            
            // Tampilkan notifikasi error
            Notification::make()
                ->title('Registration Failed!')
                ->body('An error occurred while creating your account. Please try again.')
                ->danger()
                ->send();
                
            // Log error untuk debugging
            logger()->error('User registration failed: ' . $e->getMessage());

        }
    }
    
    public function render()
    {
        return view('livewire.form-call');
    }
    

}