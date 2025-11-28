<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Header Section - User Profile
                Section::make('👤 User Profile')
                    ->description('Basic information and account overview')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name')
                            ->weight(FontWeight::Bold)
                            ->color('primary')
                            ->icon('heroicon-o-user')
                            ->columnSpan(3),
                        
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email copied!')
                            ->copyMessageDuration(1500)
                            ->color('info')
                            ->columnSpan(2),
                        
                        TextEntry::make('phone')
                            ->label('WhatsApp')
                            ->icon('heroicon-o-phone')
                            ->placeholder('Not provided')
                            ->copyable()
                            ->copyMessage('Phone copied!')
                            ->color('success'),
                        
                        TextEntry::make('status')
                            ->label('Account Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'pending' => 'warning',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'active' => 'heroicon-o-check-circle',
                                'pending' => 'heroicon-o-clock',
                                default => 'heroicon-o-x-circle',
                            }),
                        
                        TextEntry::make('point')
                            ->label('Review Points')
                            ->icon('heroicon-o-star')
                            ->numeric()
                            ->color('warning')
                            ->weight(FontWeight::Bold)
                            ->suffix(' pts')
                            ->badge(),
                        
                        TextEntry::make('roles.name')
                            ->label('Roles')
                            ->badge()
                            ->separator(', ')
                            ->color('primary'),
                    ]),

                // Academic Profile Section
                Section::make('🎓 Academic Profile')
                    ->description('Academic credentials and research profiles')
                    ->icon('heroicon-o-academic-cap')
                    ->collapsible()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('affiliation')
                            ->label('Institution')
                            ->icon('heroicon-o-building-office-2')
                            ->placeholder('Not specified')
                            ->color('primary')
                            ->weight(FontWeight::SemiBold)
                            ->columnSpanFull(),
                        
                        TextEntry::make('department')
                            ->label('Department / Faculty')
                            ->icon('heroicon-o-building-library')
                            ->placeholder('Not specified')
                            ->color('info')
                            ->columnSpanFull(),
                        
                        TextEntry::make('country')
                            ->label('Country')
                            ->icon('heroicon-o-globe-alt')
                            ->placeholder('Not specified')
                            ->badge()
                            ->color('success'),
                        
                        TextEntry::make('google_scholars')
                            ->label('Google Scholar')
                            ->icon('heroicon-o-academic-cap')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->placeholder('Not linked')
                            ->formatStateUsing(fn ($state) => $state ? '🔗 View Profile' : 'Not linked')
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->weight(fn ($state) => $state ? FontWeight::SemiBold : FontWeight::Medium),
                        
                        TextEntry::make('scopus')
                            ->label('Scopus Profile')
                            ->icon('heroicon-o-document-magnifying-glass')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->placeholder('Not linked')
                            ->formatStateUsing(fn ($state) => $state ? '🔗 View Profile' : 'Not linked')
                            ->color(fn ($state) => $state ? 'info' : 'gray')
                            ->weight(fn ($state) => $state ? FontWeight::SemiBold : FontWeight::Medium),
                        
                        TextEntry::make('orchid')
                            ->label('ORCHID iD')
                            ->icon('heroicon-o-identification')
                            ->url(fn ($state) => $state ? "https://orcid.org/{$state}" : null)
                            ->openUrlInNewTab()
                            ->placeholder('Not linked')
                            ->formatStateUsing(fn ($state) => $state ? "🔗 {$state}" : 'Not linked')
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->weight(fn ($state) => $state ? FontWeight::SemiBold : FontWeight::Medium)
                            ->columnSpanFull(),
                    ]),

                // Documents & Verification
                Section::make('📄 Documents & Verification')
                    ->description('Profile documents and account verification status')
                    ->icon('heroicon-o-document-check')
                    ->collapsible()
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        IconEntry::make('profile_photo')
                            ->label('Profile Photo')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        
                        IconEntry::make('cv')
                            ->label('Curriculum Vitae')
                            ->boolean()
                            ->trueIcon('heroicon-o-document-check')
                            ->falseIcon('heroicon-o-document')
                            ->trueColor('success')
                            ->falseColor('gray'),
                        
                        IconEntry::make('email_verified_at')
                            ->label('Email Verified')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('warning'),
                    ]),

                // System Information
                Section::make('ℹ️ System Information')
                    ->description('Account timestamps and metadata')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Member Since')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('F j, Y')
                            ->badge()
                            ->color('success'),
                        
                        TextEntry::make('created_at')
                            ->label('Account Age')
                            ->icon('heroicon-o-clock')
                            ->since()
                            ->color('gray'),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('F j, Y H:i')
                            ->color('info'),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Update')
                            ->icon('heroicon-o-clock')
                            ->since()
                            ->color('gray'),
                    ]),
            ]);
    }
}
