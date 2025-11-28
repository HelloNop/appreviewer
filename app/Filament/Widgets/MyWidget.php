<?php

namespace App\Filament\Widgets;

use App\Models\JournalUser;
use App\Models\Point;
use App\Models\PointCutOff;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MyWidget extends StatsOverviewWidget
{
protected function getStats(): array
{
    $user = Auth::user();

    // Jika user punya role Reviewer atau Editor
    if ($user->roles->whereIn('name', ['Reviewer', 'Editor', 'Proofreader'])->isNotEmpty()) {
        $totalReviews = Point::where('user_id', Auth::user()->id)->count();
        $point = Auth::user()->point;
        $totalPaidPint = PointCutOff::where('user_id', Auth::user()->id)->sum('total');

        return [
            Stat::make('Total Reviews (You)', $totalReviews),
            Stat::make('Your Points', $point),
            Stat::make('Total Paid Point', $totalPaidPint),
        ];
    }

    // Jika Admin
    $totalReviews = Point::count();

    $totalReviewer = User::whereHas('roles', function ($query) {
        $query->where('name', 'Reviewer');
    })->count();

    $totalEditor = User::whereHas('roles', function ($query) {
        $query->where('name', 'Editor');
    })->count();

    return [
        Stat::make('Total Reviews', $totalReviews),
        Stat::make('Total Reviewer', $totalReviewer),
        Stat::make('Total Editor', $totalEditor),
    ];
}

}
