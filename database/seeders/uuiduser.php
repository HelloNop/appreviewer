<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class uuiduser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::whereNull('uuid')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->uuid = Str::uuid();
                $user->save();
            }
        });
    }
}
