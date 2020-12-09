<?php

use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            ['subscription' => 'Full School Site License'],
            ['subscription' => 'Classroom'],
        ]);
    }
}
