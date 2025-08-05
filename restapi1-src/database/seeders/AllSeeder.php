<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Company;
use App\Models\Phone;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Category::truncate();
        Address::truncate();
        Company::truncate();
        Phone::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // Categories
        $resultCategories = $this->seedCategories();

        $categoryIds = $resultCategories->pluck('id')->all();

        $possibleCategoryPath = [
            [1, 2, 21, 211],
            [1, 2, 21, 212],
            [1, 2, 22, 221],
            [1, 2, 22, 222],
            [1, 3, 31, 311],
            [1, 3, 31, 312],
            [1, 3, 32, 321],
            [1, 3, 32, 322],
        ];

        // Addresses
        $addresses = Address::factory()->count(100)->create();

        // Companies
        $companies = [];
        /** @var Address $address */
        foreach ($addresses as $address) {

            $randomCategoryPath = $possibleCategoryPath[random_int(0, count($possibleCategoryPath) - 1)];

            /** @var Company $company */
            $_company = Company::factory()->create(['address_id' => $address->id]);
            $_company->categories()->attach($randomCategoryPath);
            $companies[] = $_company;
        }


        // Phones
        foreach ($companies as $company) {
            Phone::factory()->count(random_int(1, 3))->create(['company_id' => $company->id]);
        }
    }

    /**
     * @return Collection<Category>
     */
    public function seedCategories(): Collection
    {

        $categories = [
            ['id' => 1, 'name' => 'Root', 'parent_id' => null, 'level' => 0],

            ['id' => 2, 'name' => 'Еда', 'parent_id' => 1, 'level' => 1],
            ['parent_id' => 2, 'level' => 2, 'id' => 21, 'name' => 'Готовая'],
            ['parent_id' => 21, 'level' => 3, 'id' => 211, 'name' => 'Чай'],
            ['parent_id' => 21, 'level' => 3, 'id' => 212, 'name' => 'Кофе'],
            ['parent_id' => 2, 'level' => 2, 'id' => 22, 'name' => 'Крупы'],
            ['parent_id' => 22, 'level' => 3, 'id' => 221, 'name' => 'Рис'],
            ['parent_id' => 22, 'level' => 3, 'id' => 222, 'name' => 'Гречка'],

            ['id' => 3, 'name' => 'Автомобили', 'parent_id' => 1, 'level' => 1],
            ['parent_id' => 3, 'level' => 2, 'id' => 31, 'name' => 'Легковые'],
            ['parent_id' => 31, 'level' => 3, 'id' => 311, 'name' => 'Отечественные'],
            ['parent_id' => 31, 'level' => 3, 'id' => 312, 'name' => 'Китайские'],
            ['parent_id' => 3, 'level' => 2, 'id' => 32, 'name' => 'Комерческий'],
            ['parent_id' => 32, 'level' => 3, 'id' => 321, 'name' => 'Автобусы'],
            ['parent_id' => 32, 'level' => 3, 'id' => 322, 'name' => 'Грузовики'],

        ];

        $now = Carbon::now();
        foreach ($categories as $key => $category) {
            $category[$key]['created_at'] = $now;
            $category[$key]['updated_at'] = $now;
        }

        $resultCategories = Collection::make();
        foreach ($categories as $categoryData) {
            $resultCategories->add(Category::factory()->create($categoryData));
        }

        return $resultCategories;
    }
}
