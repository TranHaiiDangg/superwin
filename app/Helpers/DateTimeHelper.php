<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * Lấy thời gian hiện tại theo múi giờ Việt Nam
     */
    public static function now(): Carbon
    {
        return Carbon::now('Asia/Ho_Chi_Minh');
    }

    /**
     * Parse thời gian theo múi giờ Việt Nam
     */
    public static function parse($time): Carbon
    {
        return Carbon::parse($time, 'Asia/Ho_Chi_Minh');
    }

    /**
     * Tạo Carbon instance với múi giờ Việt Nam
     */
    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null): Carbon
    {
        return Carbon::create($year, $month, $day, $hour, $minute, $second, 'Asia/Ho_Chi_Minh');
    }

    /**
     * Format thời gian theo định dạng Việt Nam
     */
    public static function format($date, $format = 'd/m/Y H:i:s'): string
    {
        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        return self::parse($date)->format($format);
    }

    /**
     * Lấy ngày hiện tại theo định dạng Việt Nam
     */
    public static function today($format = 'Y-m-d'): string
    {
        return self::now()->format($format);
    }

    /**
     * Lấy thời gian hiện tại theo định dạng Việt Nam
     */
    public static function currentTime($format = 'H:i:s'): string
    {
        return self::now()->format($format);
    }
}
