<?php

use Illuminate\Database\Seeder;
//ヘルパ関数の中のやつをimportする必要がある
use App\Models\ContactForm;

class ContactFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factoryというヘルパ関数がある
        factory(ContactForm::class, 200)->create();
    }
}
