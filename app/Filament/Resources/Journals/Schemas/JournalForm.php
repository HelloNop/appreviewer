<?php

namespace App\Filament\Resources\Journals\Schemas;

use App\Models\FocusAndScope;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater\TableColumn;

use function Laravel\Prompts\select;

class JournalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Journal Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('singkatan')
                                    ->required(),
                                select::make('publisher_id')
                                    ->label('Publisher')
                                    ->options(\App\Models\Publisher::all()->pluck('brand_name', 'id'))
                                    ->searchable()
                                    ->required(),
                                TextInput::make('url')
                                    ->url()
                                    ->label('Website')
                                    ->required(),
                                FileUpload::make('certificate')
                                    ->required()
                                    ->image()
                                    ->disk('public')
                                    ->directory('certificates')
                                    ->visibility('public'),
                            ]),
                ])->columnSpanFull(),

                Section::make('Editors')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('journalEditors')
                        ->relationship()
                        ->columnSpanFull()
                        ->orderColumn('sort_order')
                        ->table([
                            TableColumn::make('Editor Name'),
                            TableColumn::make('Position'),
                        ])

                        ->schema([
                            Select::make('user_id')
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('position')
                                ->label('Role')
                                ->options([
                                    'Editor in Chief' => 'Editor in Chief',
                                    'Editor' => 'Editor',
                                    'Managing Editor' => 'Managing Editor',
                                    'Associate Editor' => 'Associate Editor',
                                    'International Editor' => 'International Editor',
                                    'Team Editor' => 'Team Editor',
                                    'Proofreader' => 'Proofreader',
                                ])
                                ->required(),
                            Hidden::make('status')->default('accepted'),
                        ])
                    ]),

                    Section::make('Reviewer')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('journalReviewers')
                        ->hiddenLabel()
                        ->relationship()
                        ->columnSpanFull()
                        ->orderColumn('sort_order')
                        ->table([
                            TableColumn::make('Reviewer Name'),
                            TableColumn::make('Position'),
                        ])
                        ->schema([
                            Select::make('user_id')
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('position')
                                ->label('Role')
                                ->options([
                                    'Reviewer' => 'Reviewer',
                                    'International Reviewer' => 'International Reviewer',
                                    'Team Reviewer' => 'Team Reviewer',
                                ])
                                ->required(),
                            Hidden::make('status')->default('accepted'),
                        ])
                    ]),


            ]);
        
    }
}
