<?php

use Illuminate\Database\Seeder;

class LabsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            DB::table('labs')->insert([
                'prof' => Str::random(2),
                'field' => Str::random(8) . '研究',
                'study' => Str::random(20) . 'を行う。',
            ]);
        }
    }
}
