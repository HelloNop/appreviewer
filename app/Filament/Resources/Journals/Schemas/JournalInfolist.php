<?php

namespace App\Filament\Resources\Journals\Schemas;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use FontLib\Glyph\Outline;

class JournalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jurnal')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('singkatan'),
                        TextEntry::make('publisher.brand_name')->label('Publisher'),
                        TextEntry::make('url')->label('Website')->url(fn ($state) => $state),
                    ])->columnSpanFull(),

            // editor
                Section::make('Editorial Board')
                    ->afterHeader([
                        Action::make('Copy Code')
                            ->label('Copy Code List Editor')
                            ->button()
                            ->outlined()
                            ->icon('heroicon-o-clipboard-document')
                            ->modalHeading('Generated HTML Code')
                            ->modalDescription('Copy the HTML code below for all editors and reviewers:')
                            ->modalSubmitActionLabel('Close')
                            ->modalWidth('2xl')
                            ->schema([
                                Textarea::make('html_code')
                                ->label('HTML Code')   
                                ->default(function ($record) {
                                    $positions = $record->journalEditors
                                        ->pluck('position')
                                        ->unique()
                                        ->toArray();
                                    $html = '<div class="editorial-team">';
                                    
                                    foreach ($positions as $position) {
                                        $editors = $record->journalEditors->where('position', $position);
                                        if ($editors->count() > 0) {
                                            $html .= '<h3>' . $position . '</h3>';
                                            $html .= $editors->map(function ($editor) {
                                                $user = $editor->user;
                                                // Profile picture logic
                                                $profilePicture = '';
                                                if ($user->profile_photo) {
                                                    $fullImageUrl = url('storage/' . $user->profile_photo);
                                                    $profilePicture = '<img src="' . $fullImageUrl . '" alt="' . $user->name . '" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 12px; vertical-align: top;">';
                                                } else {
                                                    $initials = collect(explode(' ', $user->name))
                                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                        ->take(2)
                                                        ->join('');
                                                    $profilePicture = '<div style="width: 40px; height: 40px; border-radius: 50%; background-color: #3b82f6; color: white; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; vertical-align: top; font-size: 18px; font-weight: bold;">' . $initials . '</div>';
                                                }

                                                $content = '<div class="editor-item" style="display: flex; align-items: flex-start; margin-bottom: 60px;">';
                                                $content .= $profilePicture;
                                                $content .= '<div>';
                                                $content .= '<p style="margin: 0 0 4px 0; font-size: 18px;">' . $user->name . '</p>';
                                                $content .= '<p style="margin: 0 0 4px 0; font-size: 14px; color: #666;">' . ($user->department ?: 'N/A') . ', ' . ($user->affiliation ?: 'N/A') . ', ' . ($user->country ?: 'N/A') . '</p>';

                                                $links = [];
                                                if ($user->google_scholars) {
                                                    $links[] = '<a href="' . trim($user->google_scholars) . '" target="_blank" style="color: #3b82f6; text-decoration: none;">Google Scholar</a>';
                                                }
                                                if ($user->scopus) {
                                                    $links[] = '<a href="' . trim($user->scopus) . '" target="_blank" style="color: #3b82f6; text-decoration: none;">Scopus</a>';
                                                }
                                                if ($user->orchid) {
                                                    $orchidUrl = str_starts_with($user->orchid, 'http') 
                                                        ? $user->orchid 
                                                        : 'https://orcid.org/' . trim($user->orchid);
                                                    $links[] = '<a href="' . $orchidUrl . '" target="_blank" style="color: #3b82f6; text-decoration: none;">ORCHID</a>';
                                                }
                                                if (!empty($links)) {
                                                    $content .= '<p style="margin: 0; font-size: 12px;">' . implode(' | ', $links) . '</p>';
                                                }

                                                $content .= '</div>';
                                                $content .= '</div>';
                                                return $content;
                                            })->join('');
                                        }
                                    }

                                    $html .= '</div>';
                                    return $html; 
                                })
                                ->disabled() 
                                ->rows(18),
                            ])
                    ])
                    ->schema(fn ($record) =>
                        $record->journalEditors
                            ->pluck('position')
                            ->unique()
                            ->values()
                            ->map(function ($position, $index) use ($record) {
                                return 
                                TextEntry::make('Position' . $index)
                                    ->label($position)
                                    ->size(TextSize::Medium)
                                    ->listWithLineBreaks()
                                    ->html()
                                    ->getStateUsing(fn ($record) =>
                                        $record->journalEditors
                                            ->where('position', $position)
                                            ->map(function ($editor) {
                                                $user = $editor->user;
                                                $googleScholar = $user->google_scholars ? '<a href="' . $user->google_scholars . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M5.242 13.769L0.5 9.5 12 1l11.5 8.5-4.742 4.269C17.548 12.53 14.978 11.5 12 11.5c-2.977 0-5.548 1.03-6.758 2.269zM12 13.5c1.381 0 2.5 1.119 2.5 2.5s-1.119 2.5-2.5 2.5-2.5-1.119-2.5-2.5 1.119-2.5 2.5-2.5z"/></svg>Google Scholar</a>' : 'N/A';
                                                $scopus = $user->scopus ? '<a href="' . $user->scopus . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Scopus</a>' : 'N/A';
                                                $orchid = $user->orchid ? '<a href="' . (str_starts_with($user->orchid, 'http') ? $user->orchid : 'https://orcid.org/' . trim($user->orchid)) . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 7.387c.558 0 1.01.452 1.01 1.01 0 .558-.452 1.01-1.01 1.01-.558 0-1.01-.452-1.01-1.01 0-.558.452-1.01 1.01-1.01zm-.727 3.29h1.454v7.015H6.642v-7.015zm3.42 0h1.388v.96h.02c.193-.366.666-.96 1.371-.96 1.466 0 1.737 1.168 1.737 2.687v3.09h-1.447v-2.74c0-.542-.01-1.238-.753-1.238-.754 0-.87.588-.87 1.198v2.78H10.06v-7.015z"/></svg>ORCID</a>' : 'N/A';
                                                $profilePicture = $user->profile_photo ? '<img src="' . asset('storage/' . $user->profile_photo) . '" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 12px; vertical-align: middle;">' : '<div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; vertical-align: middle; color: white; font-weight: bold; font-size: 18px;">' . strtoupper(substr($user->name, 0, 1)) . '</div>';
                                                
                                                return '<div style="display: flex; align-items: center; margin-bottom: 8px;">' . $profilePicture . '<div>' . $user->name . '<br><small style="color: #666;">' . 
                                                    $googleScholar . ' | ' .
                                                    $scopus . ' | ' .
                                                    $orchid . '<br>' .
                                                    ($user->department ? $user->department : 'N/A') . ', ' .
                                                    ($user->affiliation ? $user->affiliation : 'N/A') . ', ' .
                                                    ($user->country ? $user->country : 'N/A') . '</small></div></div>';
                                            })->implode('<br>')
                                    );
                            })->toArray(),
                )->columnSpanFull(),
                   
            // list reviewer
                Section::make('Peer Reviewer Board')
                    ->afterHeader([
                        Action::make('ReviewerCode')
                            ->label('Copy List Reviewer Code')
                            ->button()
                            ->outlined()
                            ->icon('heroicon-o-clipboard-document')
                            ->modalHeading('Generated HTML Code')
                            ->modalDescription('Copy the HTML code below for all reviewers:')
                            ->modalSubmitActionLabel('Close')
                            ->modalWidth('2xl')
                            ->schema([
                                Textarea::make('html_code')
                                ->label('HTML Code')   
                                ->default(function ($record) {
                                    $positions = $record->journalReviewers
                                        ->pluck('position')
                                        ->unique()
                                        ->toArray();
                                    $html = '<div class="editorial-team">';
                                    
                                    foreach ($positions as $position) {
                                        $reviewers = $record->journalReviewers->where('position', $position);
                                        if ($reviewers->count() > 0) {
                                            $html .= '<h3>' . $position . '</h3>';
                                            $html .= $reviewers->map(function ($reviewer) {
                                                $user = $reviewer->user;

                                                // Profile picture logic
                                                $profilePicture = '';
                                                if ($user->profile_photo) {
                                                    $fullImageUrl = url('storage/' . $user->profile_picture);
                                                    $profilePicture = '<img src="' . $fullImageUrl . '" alt="' . $user->name . '" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 12px; vertical-align: top;">';
                                                } else {
                                                    $initials = collect(explode(' ', $user->name))
                                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                        ->take(2)
                                                        ->join('');
                                                    $profilePicture = '<div style="width: 40px; height: 40px; border-radius: 50%; background-color: #3b82f6; color: white; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; vertical-align: top; font-size: 18px; font-weight: bold;">' . $initials . '</div>';
                                                }

                                                $content = '<div class="editor-item" style="display: flex; align-items: flex-start; margin-bottom: 16px;">';
                                                $content .= $profilePicture;
                                                $content .= '<div>';
                                                $content .= '<p style="margin: 0 0 4px 0; font-size: 18px;">' . $user->name . '</p>';
                                                $content .= '<p style="margin: 0 0 4px 0; font-size: 14px; color: #666;">' . ($user->department ?: 'N/A') . ', ' . ($user->affiliation ?: 'N/A') . ', ' . ($user->country ?: 'N/A') . '</p>';

                                                $links = [];
                                                if ($user->google_scholars) {
                                                    $links[] = '<a href="' . trim($user->google_scholars) . '" target="_blank" style="color: #3b82f6; text-decoration: none;">Google Scholar</a>';
                                                }
                                                if ($user->scopus) {
                                                    $links[] = '<a href="' . trim($user->scopus) . '" target="_blank" style="color: #3b82f6; text-decoration: none;">Scopus</a>';
                                                }
                                                if ($user->orchid) {
                                                $orchidUrl = str_starts_with($user->orchid, 'http') 
                                                    ? $user->orchid 
                                                    : 'https://orcid.org/' . trim($user->orchid);
                                                $links[] = '<a href="' . $orchidUrl . '" target="_blank" style="color: #3b82f6; text-decoration: none;">ORCHID</a>';
}
                                                if (!empty($links)) {
                                                    $content .= '<p style="margin: 0; font-size: 12px;">' . implode(' | ', $links) . '</p>';
                                                }

                                                $content .= '</div>';
                                                $content .= '</div>';
                                                return $content;
                                            })->join('');
                                        }
                                    }

                                    $html .= '</div>';
                                    return $html; 
                                })
                                ->disabled() 
                                ->rows(18), 
                            ])
                    ])
                    ->schema(fn ($record) =>
                        $record->journalReviewers
                            ->pluck('position')
                            ->unique()
                            ->values()
                            ->map(function ($position, $index) use ($record) {
                                return 
                                TextEntry::make('Position' . $index)
                                    ->label($position)
                                    ->size(TextSize::Medium)
                                    ->listWithLineBreaks()
                                    ->html()
                                    ->getStateUsing(fn ($record) =>
                                        $record->journalReviewers
                                            ->where('position', $position)
                                            ->map(function ($reviewer) {
                                                $user = $reviewer->user;
                                                $googleScholar = $user->google_scholars ? '<a href="' . $user->google_scholars . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M5.242 13.769L0.5 9.5 12 1l11.5 8.5-4.742 4.269C17.548 12.53 14.978 11.5 12 11.5c-2.977 0-5.548 1.03-6.758 2.269zM12 13.5c1.381 0 2.5 1.119 2.5 2.5s-1.119 2.5-2.5 2.5-2.5-1.119-2.5-2.5 1.119-2.5 2.5-2.5z"/></svg>Google Scholar</a>' : 'N/A';
                                                $scopus = $user->scopus ? '<a href="' . $user->scopus . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Scopus</a>' : 'N/A';
                                                $orchid = $user->orchid ? '<a href="' . (str_starts_with($user->orchid, 'http') ? $user->orchid : 'https://orcid.org/' . trim($user->orchid)) . '" target="_blank" style="color: #2563eb !important; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'"><svg style="width: 16px; height: 16px; fill: #2563eb;" viewBox="0 0 24 24"><path d="M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 7.387c.558 0 1.01.452 1.01 1.01 0 .558-.452 1.01-1.01 1.01-.558 0-1.01-.452-1.01-1.01 0-.558.452-1.01 1.01-1.01zm-.727 3.29h1.454v7.015H6.642v-7.015zm3.42 0h1.388v.96h.02c.193-.366.666-.96 1.371-.96 1.466 0 1.737 1.168 1.737 2.687v3.09h-1.447v-2.74c0-.542-.01-1.238-.753-1.238-.754 0-.87.588-.87 1.198v2.78H10.06v-7.015z"/></svg>ORCID</a>' : 'N/A';
                                                $profilePicture = $user->profile_photo ? '<img src="' . asset('storage/' . $user->profile_photo) . '" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 12px; vertical-align: middle;">' : '<div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; vertical-align: middle; color: white; font-weight: bold; font-size: 18px;">' . strtoupper(substr($user->name, 0, 1)) . '</div>';
                                                
                                                return '<div style="display: flex; align-items: center; margin-bottom: 8px;">' . $profilePicture . '<div>' . $user->name . '<br><small style="color: #666;">' . 
                                                    $googleScholar . ' | ' .
                                                    $scopus . ' | ' .
                                                    $orchid . '<br>' .
                                                    ($user->department ? $user->department : 'N/A') . ', ' .
                                                    ($user->affiliation ? $user->affiliation : 'N/A') . ', ' .
                                                    ($user->country ? $user->country : 'N/A') . '</small></div></div>';
                                            })->implode('<br>')
                                    );
                            })->toArray(),
                )->columnSpanFull(),           
            
            
            
            ]);
    }
}
