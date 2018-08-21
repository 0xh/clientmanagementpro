<?php

namespace App\Traits\Methods;
use Illuminate\Database\Eloquent\Collection;
use App\Task;

trait CampaignProgressMethod
{

    public static function total($ids) : int
    {
        return  array_reduce(self::getTaskIds($ids),'self::sumTasksTotal');
    }

    public static function done($ids) : int
    {
        return  array_reduce(self::getTaskIds($ids),'self::sumTasksDone');
    }

    public static function progress($modelOrID) : int
    {
        $campaign = self::normalize($modelOrID);
        return round(self::get_percentage(self::total($campaign), self::done($campaign)));
    }

    public static function get_percentage($total, $number) : float
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }

    private static function sumTasksTotal($carry,$item) : int
    {
        $carry += Task::total($item);
        return $carry;
    }

    private static function sumTasksDone($carry,$item) : int
    {
        $carry += Task::done($item);
        return $carry;
    }

    private static function getTaskIds($modeOrID) : array
    {
        $campaign = self::normalize($modeOrID);
        return $campaign->tasks()->pluck('id')->toArray();
    }
}
