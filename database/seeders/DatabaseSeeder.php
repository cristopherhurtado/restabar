<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\MenuEntry;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Cristopher',
            'password' => bcrypt('123456'),
            'email' => 'cristopher@example.com',
            'role' => Role::Frontline,
        ]);

        User::factory()->create([
            'name' => 'Ariela',
            'password' => bcrypt('123456'),
            'email' => 'ariela@example.com',
            'role' => Role::Kitchen,
        ]);

        Table::factory()->count(5)
            ->state(new Sequence(
                ['id' => 1, 'name' => 'Mesa 1'],
                ['id' => 2, 'name' => 'Mesa 2'],
                ['id' => 3, 'name' => 'Mesa 3'],
                ['id' => 4, 'name' => 'Mesa 4'],
                ['id' => 5, 'name' => 'Mesa 5'],
            ))
            ->create();

        MenuEntry::factory()->count(10)
            ->state(new Sequence(
                ['id' => 1, 'name' => 'Hamburguesa', 'description' => 'Hamburguesa de carne', 'price' => 100],
                ['id' => 2, 'name' => 'Pizza', 'description' => 'Pizza de peperoni', 'price' => 150],
                ['id' => 3, 'name' => 'Pasta', 'description' => 'Pasta con salsa de tomate', 'price' => 120],
                ['id' => 4, 'name' => 'Ensalada', 'description' => 'Ensalada de lechuga', 'price' => 80],
                ['id' => 5, 'name' => 'Sopa', 'description' => 'Sopa de verduras', 'price' => 70],
                ['id' => 6, 'name' => 'Pollo', 'description' => 'Pollo frito', 'price' => 90],
                ['id' => 7, 'name' => 'Pescado', 'description' => 'Pescado a la plancha', 'price' => 110],
                ['id' => 8, 'name' => 'Tacos', 'description' => 'Tacos de carne', 'price' => 130],
                ['id' => 9, 'name' => 'Sushi', 'description' => 'Sushi de salmón', 'price' => 200],
                ['id' => 10, 'name' => 'Torta', 'description' => 'Torta de chocolate', 'price' => 50],
            ))
            ->create();
    }
}
