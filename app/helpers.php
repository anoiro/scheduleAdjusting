<?php

use Carbon\CarbonInterface;
use Carbon\CarbonImmutable;

/**
 * 一か月分の日付リストを返す
 */
function dates(CarbonInterface $month)
{
    $dates = [];

    //カレンダーで先月の残り(7/28~7/31)を$date配列に入れる
    //その月の1日を曜日を０〜６で出す
    //$last = date('m', strtotime("first day of $month"));
    $first = $month->firstOfMonth();
    $last = date('w', strtotime("first day of $month"));
 
    for (; 0 <= $last - 1; $last -= 1) {
        $dates[] = new CarbonImmutable("$first-$last day");
        // $dates[] = [];
    }
 
    //今月分(8/1~8/31)を$date配列に入れる
    $week = date('d', strtotime("last day of $month"));
 
    for ($i = 0; $i < $week; $i += 1) {
        $dates[] = new CarbonImmutable("$first+$i day");
    }

    //カレンダーで来月の残り(今回9月分はなし)を$date配列に入れる
    $end = $month->lastOfMonth();
    $next = date('w', strtotime("last day of $month"));
    for ($i = 1; $i <= (6 - $next); $i += 1) {
        $dates[] = new CarbonImmutable("$end+$i day");
    }
    return $dates;
}

/**
 * 一か月分の日付リストを一週間ごとにリスト化する
 */
function calendar(CarbonInterface $month)
{
    $week = [];
    //該当する月$monthのカレンダーで表示する用の配列を得る
    $dates = dates($month);

    for ($i = 0; $i < count($dates); $i += 7) {
        $week = [];

        foreach (array_slice($dates, $i, 7) as $date) {
            $week[] = $date;
        }
        yield $week;
    }
}
