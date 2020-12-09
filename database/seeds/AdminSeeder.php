<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            ['name'    => 'Kevlon Jr',
                'email'    => 'kevlongalloway1999m@gmail.com',
                'password' => '$2y$10$du.7Yc9sw6kBQBpwUQUwCO6NGgA9xFxZ4TFPeR6SaDgUeYDR35HOi'],
            ['name'    => 'Kevlon',
                'email'    => 'kgalloway56@yahoo.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy'],
            ['name'    => 'Kevin Cates',
                'email'    => 'kcates@koolriculum.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy'],
            ['name'    => 'Kevia Cates',
                'email'    => 'keviacates@koolriculum.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy'],
        ]);

        DB::table('users')->insert([
            ['name'    => 'Kevlon Jr',
                'email'    => 'kevlongalloway1999m@gmail.com',
                'password' => '$2y$10$du.7Yc9sw6kBQBpwUQUwCO6NGgA9xFxZ4TFPeR6SaDgUeYDR35HOi',
                 'is_active' => 1],
            ['name'    => 'Kevlon',
                'email'    => 'kgalloway56@yahoo.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy',
            'is_active' => 1],
            ['name'    => 'Kevin Cates',
                'email'    => 'kcates@koolriculum.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy',
            'is_active' => 1],
            ['name'    => 'Kevia Cates',
                'email'    => 'keviacates@koolriculum.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy',
            'is_active' => 1],
        ]);

        DB::table('teachers')->insert([
            ['name'    => 'Kevlon Jr',
                'email'    => 'kevinwoods@gmail.com',
                'password' => '$2y$10$QFkedhHJRYQjkOl4P0g59e8zvdSf0MFx.dFKv8ZF9DTXSP90LzUmy',
                'organization_id' => 1]
        ]);
    }
}
