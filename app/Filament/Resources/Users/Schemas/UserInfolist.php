<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Basic Information
                TextEntry::make('name')
                    ->label('Full Name')
                    ->size('lg')
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-o-user'),
                
                TextEntry::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->copyMessageDuration(1500),
                
                TextEntry::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->icon('heroicon-o-shield-check'),
                
                TextEntry::make('status')
                    ->label('Account Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->icon('heroicon-o-check-circle'),
                
                TextEntry::make('point')
                    ->label('Review Points')
                    ->icon('heroicon-o-star')
                    ->numeric()
                    ->color('warning')
                    ->weight('bold'),

                // Academic Information
                TextEntry::make('affiliation')
                    ->label('University / Institution')
                    ->icon('heroicon-o-building-office-2')
                    ->placeholder('Not specified')
                    ->color('primary'),
                
                TextEntry::make('department')
                    ->label('Faculty / Department')
                    ->icon('heroicon-o-building-library')
                    ->placeholder('Not specified')
                    ->color('primary'),
                
                TextEntry::make('google_scholars')
                    ->label('Google Scholar Profile')
                    ->icon('heroicon-o-academic-cap')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->placeholder('Not provided')
                    ->formatStateUsing(fn ($state) => $state ? '🔗 View Profile' : 'Not provided')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                
                TextEntry::make('scopus')
                    ->label('Scopus Profile')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->placeholder('Not provided')
                    ->formatStateUsing(fn ($state) => $state ? '🔗 View Profile' : 'Not provided')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                // Contact Information
                TextEntry::make('phone')
                    ->label('WhatsApp Number')
                    ->icon('heroicon-o-phone')
                    ->placeholder('Not provided')
                    ->copyable()
                    ->copyMessage('Phone number copied!')
                    ->copyMessageDuration(1500)
                    ->color('info'),
                
                TextEntry::make('country')
                    ->label('Country')
                    ->icon('heroicon-o-globe-alt')
                    ->placeholder('Not specified')
                    ->color('info'),

                // Documents
                TextEntry::make('profile_photo')
                    ->label('Profile Picture')
                    ->icon('heroicon-o-photo')
                    ->placeholder('Not uploaded')
                    ->formatStateUsing(fn ($state) => $state ? '✅ Available' : '❌ Not uploaded')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                
                TextEntry::make('cv')
                    ->label('Curriculum Vitae')
                    ->icon('heroicon-o-document-text')
                    ->placeholder('Not uploaded')
                    ->formatStateUsing(fn ($state) => $state ? '✅ CV Available' : '❌ Not uploaded')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                // System Information
                TextEntry::make('email_verified_at')
                    ->label('Email Verified')
                    ->icon('heroicon-o-check-circle')
                    ->dateTime()
                    ->placeholder('❌ Not verified')
                    ->formatStateUsing(fn ($state) => $state ? '✅ Verified on ' . $state->format('M d, Y') : '❌ Not verified')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                
                TextEntry::make('created_at')
                    ->label('Member Since')
                    ->icon('heroicon-o-calendar')
                    ->dateTime()
                    ->since()
                    ->color('gray'),
                
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->icon('heroicon-o-clock')
                    ->dateTime()
                    ->since()
                    ->color('gray'),
            ]);
    }
}
