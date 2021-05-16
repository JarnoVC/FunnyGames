<?php

class Ago
{

    public function convertToTimestamp($value)
    {
        date_default_timezone_set('Europe/Brussels');
        list($date, $time) = explode(' ', $value);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minutes, $seconds) = explode(':', $time);

        $unit_timestamp = mktime($hour, $minutes, $seconds, $month, $day, $year);
        return $unit_timestamp;
    }

    public function convertToAgo($timestamp)
    {
        date_default_timezone_set('Europe/Brussels');
        $diffCurrentTimeAndTimestamp = time() - $timestamp;
        $periodsString = ["sec", "min", "hr", "day", "week", "month", "year", "decade"];
        $periodsNumber = ["60", "60", "24", "7", "4.35", "12", "10"];

        for ($iterator = 0; $diffCurrentTimeAndTimestamp >= $periodsNumber[$iterator]; $iterator++)
            $diffCurrentTimeAndTimestamp /= $periodsNumber[$iterator];
        $diffCurrentTimeAndTimestamp = round($diffCurrentTimeAndTimestamp);

        if ($diffCurrentTimeAndTimestamp != 1) $periodsString[$iterator] .= "s";

        $output = "$diffCurrentTimeAndTimestamp $periodsString[$iterator]";

        return $output . " ago";
    }
}
