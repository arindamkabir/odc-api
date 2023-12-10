<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\ProductService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;

class ProductSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ProductService $productService)
    {
        for ($j = 0; $j < 50; $j++) {
            $productService->store([
                'name' => $this->faker->unique()->words($nb = 4, $asText = true),
                'description' => $this->faker->text(400),
                'price' => $this->faker->numberBetween(10, 300),
                'category_id' => $this->faker->numberBetween(1, 6),
                'SKU' => $this->faker->unique()->numberBetween(1000000, 9999999),
                'primary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'secondary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'stocks' => [
                    ['size_id' => 2, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                    ['size_id' => 1, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                    ['size_id' => 3, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                    ['size_id' => 4, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                ],
                'has_colors' => "false",
                'has_sizes' => "true",
                'is_featured' => "true",
                'is_hidden' => "true",
                'extra_images' => [],
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            $productService->store([
                'name' => $this->faker->unique()->words($nb = 4, $asText = true),
                'description' => $this->faker->text(400),
                'price' => $this->faker->numberBetween(10, 300),
                'category_id' => $this->faker->numberBetween(1, 6),
                'SKU' => $this->faker->unique()->numberBetween(1000000, 9999999),
                'primary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'secondary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'stocks' => [
                    ['color_id' => 2, 'size_id' => 2, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                    ['color_id' => 1, 'size_id' => 1, 'quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                ],
                'has_colors' => "true",
                'has_sizes' => "true",
                'is_featured' => "true",
                'is_hidden' => "true",
                'extra_images' => [],
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            $productService->store([
                'name' => $this->faker->unique()->words($nb = 4, $asText = true),
                'description' => $this->faker->text(400),
                'price' => $this->faker->numberBetween(10, 300),
                'category_id' => $this->faker->numberBetween(1, 6),
                'SKU' => $this->faker->unique()->numberBetween(1000000, 9999999),
                'primary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'secondary_img' =>  new UploadedFile(storage_path('test_images/' . rand(1, 26) . '.jpg'), 'originalname.jpg', 'image/jpg'),
                'stocks' => [
                    ['quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                    ['quantity' => rand(1, 5), 'price' => rand(100.12, 600.123)],
                ],
                'has_colors' => "false",
                'has_sizes' => "false",
                'is_featured' => "true",
                'is_hidden' => "true",
                'extra_images' => [],
            ]);
        }
    }
}
