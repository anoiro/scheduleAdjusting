<?php

namespace Tests\Unit;

use Carbon\CarbonImmutable;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_dates()
    {
        $input=CarbonImmutable::createFromFormat('Y-m-d', '2020-06-23');
        $actual=dates($input);

        $this->assertCount(35, $actual);
        $this->assertEquals('2020-05-31', $actual[0]->format('Y-m-d'));
        $this->assertEquals('2020-07-04', $actual[34]->format('Y-m-d'));
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_calendar()
    {
        $input=CarbonImmutable::createFromFormat('Y-m-d', '2020-06-23');
        $actual=calendar($input);

        //マジック定数。文字列のクラス名を返す
        $this->assertInstanceOf(Generator::class, $actual);

        $array=iterator_to_array($actual);
        $this->assertCount(5, $array);

        foreach($array as $a){
            $this->assertCount(7, $a);
        }
    }
}
