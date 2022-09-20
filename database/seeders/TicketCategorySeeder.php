<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketCategory::insert([
            ['title' => 'HTML/CSS'],
            ['title' => 'Javascript'],
            ['title' => 'Typescript'],
            ['title' => 'PHP'],
            ['title' => 'Java'],
            ['title' => 'C#'],
            ['title' => 'Laravel'],
            ['title' => 'Vue'],
        ]);
    }
}
