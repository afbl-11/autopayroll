<?php

use Carbon\Carbon;

if (! function_exists('formatTimeOrDash')) {
    function formatTimeOrDash($time)
    {
        return $time ? Carbon::parse($time)->format('H:i') : '—';
    }
}
