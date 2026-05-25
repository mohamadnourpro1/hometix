<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::query()->pluck('id');

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::query()->pluck('id');
        }

        Product::factory()
            ->count(30)
            ->state(fn () => ['category_id' => $categories->random()])
            ->create()
            ->each(function (Product $product) {
                $imageCount = random_int(1, 3);

                for ($index = 1; $index <= $imageCount; $index++) {
                    $product->images()->create([
                        'image_path' => "https://picsum.photos/seed/product-{$product->id}-{$index}/900/700",
                    ]);
                }

                $videoOptions = [
                    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'https://youtu.be/aqz-KE-bpKQ',
                    'https://www.youtube.com/watch?v=ysz5S6PUM-U',
                ];

                if ($product->is_popular || random_int(0, 100) < 35) {
                    $product->videos()->create([
                        'youtube_url' => Arr::random($videoOptions),
                    ]);
                }
            });
    }
}
