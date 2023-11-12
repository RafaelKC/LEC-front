<?php
function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $minutes = $minutes % 60;

    $format = '%u:%02u';
    $time = sprintf($format, $hours, $minutes, $milliseconds);
    return rtrim($time, '0');
}
