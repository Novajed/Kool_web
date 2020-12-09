<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            ['subject' => 'ELA'],
            ['subject' => 'Math'],
            ['subject' => 'Science'],
            ['subject' => 'Social Studies'],
        ]);
    }
}
