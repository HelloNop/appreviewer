<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Filament\Forms\Components\DateTimePicker;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Tapp\FilamentCountryCodeField\Forms\Components\CountryCodeSelect;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create') // wajib saat create
                            ->dehydrated(fn ($state) => filled($state)),// hanya disimpan kalau ada isinya 
                        Select::make('status')
                            ->options(['active' => 'active', 'pending' => 'pending'])
                            ->searchable()
                            ->default('active')
                            ->required(),   
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
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
                        Select::make('focusAndScopes')
                                ->relationship('focusAndScopes', 'name')
                                ->label('Review Interest')
                                ->multiple()
                                ->preload(),
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
                        Select::make('focusAndScopes')
                            ->label('Review Interest')
                            ->helperText('You can select one or more Focus and Scope.')
                            ->multiple()
                            ->options(\App\Models\FocusAndScope::pluck('name', 'id'))
                            ->required()
                            ->statePath('focusAndScopes'),
                        FileUpload::make('profile_photo')
                            ->label('Profile Picture')
                            ->disk('public')
                            ->image()
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

            ]);
    }
}
