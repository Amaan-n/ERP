<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);

        $this->call(EmployeesTableSeeder::class);
        $this->call(ManufacturersTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(FieldsTableSeeder::class);
        $this->call(FieldGroupsTableSeeder::class);
        $this->call(AssetCategoriesTableSeeder::class);
        $this->call(AssetModelsTableSeeder::class);

        $this->call(LocationsTableSeeder::class);
        $this->call(MeasuringUnitsTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
