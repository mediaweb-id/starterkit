<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title'=>  'Home',
                'template'=>'home',
                'sections' => null,
                'slug'=>  'home',
                'summary' => '',
                'meta' => [
                    'title' => null,
                    'description' =>  null,
                    'image' => null,
                ],
            ],
        ];
        Page::truncate();
        foreach ($pages as $key => $value) {
            $page = Page::updateOrCreate(
                [
                    'title' => $value['title'] ?? null,
                ],
                [
                    'template' => $value['template'] ?? null,
                    'sections' => $value['sections'] ?  (array)json_decode(json_encode($value['sections']), true) : null,
                    'slug' => $value['slug'] ?? null,
                    'meta' => $value['meta'] ?? null,
                    'summary' => $value['summary'],
                    'published_at' => Carbon::now(),
                ]
            );
            $this->command->info('Creating...' . $page->title);
        }
        cache()->flush();
    }
}
