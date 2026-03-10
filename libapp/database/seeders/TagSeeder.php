<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::truncate();
        
        $tags = [
            'Fantasy',
            'Science Fiction',
            'Horror',
            'Mystery',
            'Thriller',
            'Romance',
            'Adventure',
            'Historical',
            'Philosophy',
            'Psychology',
            'Self Development',
            'Classic',
            'Dystopian',
            'Drama',
            'Young Adult'
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}