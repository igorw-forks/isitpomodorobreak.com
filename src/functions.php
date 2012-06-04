<?php

function isPomodoroMinute($minute) {
    return ($minute >= 25 && $minute <= 29) || ($minute >= 55 && $minute <= 59);
}

function getStatus($now) {
    $minute = (int) date('i', $now);
    $status = isPomodoroMinute($minute) ? 'yes' : 'no';

    $data = array(
        'version'       => '1.0',
        'current_time'  => $now,
        'status'        => $status
    );

    return $data;
}
