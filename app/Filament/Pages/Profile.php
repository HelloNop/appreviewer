<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\JournalUser;
use App\Models\User;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Filament\Notifications\Notification;

class Profile extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    protected string $view = 'filament.pages.profile';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected function getHeaderActions(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return [
            Action::make('editProfile')
                ->label('Edit Profile')
                ->modalHeading('Edit Your Profile')
                ->modalWidth('xl')
                ->fillForm(fn () => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'department' => $user->department,
                    'affiliation' => $user->affiliation,
                    'country' => $user->country,
                    'profile_photo' => $user->profile_photo,
                    'cv' => $user->cv,
                    'google_scholars' => $user->google_scholars,
                    'scopus' => $user->scopus,
                ])
                ->schema([
                    // user info
                    Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name & Title')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create') // wajib saat create
                            ->dehydrated(fn ($state) => filled($state)),// hanya disimpan kalau ada isinya 
                    ])->columnSpanFull(),

                    // user detail
                    Section::make()
                        ->schema([
                            TextInput::make('google_scholars')
                                ->label('Google Scholars')
                                ->url(),
                            TextInput::make('scopus')
                                ->label('Scopus ID')
                                ->url(),
                            PhoneInput::make('phone')
                                ->label('Whatsapp Number'),
                            TextInput::make('department')
                                    ->label('Faculty / Department'),
                            TextInput::make('affiliation')
                                ->label('University / Institution'),
                            Select::make('country')
                                ->label('Country')
                                ->options(config('countries'))
                                ->searchable()
                                ->preload(),
                            FileUpload::make('profile_photo')
                                ->image()
                                ->label('Profile Picture')
                                ->disk('public')
                                ->directory('photo_profile')
                                ->visibility('public'),
                            AdvancedFileUpload::make('cv')
                                ->label('Curriculum Vitae')
                                ->disk('public')
                                ->directory('cv')
                                ->visibility('public')
                                ->acceptedFileTypes(['application/pdf'])
                                ->maxSize(1024 * 1024 * 10) // 10MB
                                ->pdfPreviewHeight(400) // Customize preview height
                                ->pdfDisplayPage(1) // Set default page
                                ->pdfToolbar(true) // Enable toolbar
                                ->pdfZoomLevel(100) // Set zoom level
                                ->pdfFitType(PdfViewFit::FIT) // Set fit type
                                ->pdfNavPanes(true) // Enable navigation panes
                        ])->columnSpanFull(),

                ])->action(function (array $data) use ($user): void {
                    $user->update($data);
                })->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Profil Berhasil Diperbarui')
                        ->body('Data profil Anda telah berhasil disimpan.')
                ),


        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(JournalUser::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('journal.title')
                ->label('My Active Journal'),
                TextColumn::make('position')
                ->label('My Position'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                // ...
            ])
            ->toolbarActions([
                // ...
            ]);
    }

        
}
