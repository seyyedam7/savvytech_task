<?php

function base_path(string $path = ''): string
{
    if ($path) {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $path;
    }
    return dirname(__DIR__, 2);
}

function resources_path(string $path = ''): string
{
    if ($path) {
        return base_path('resources') . DIRECTORY_SEPARATOR . $path;
    }
    return base_path('resources');
}

function secondsToReadableTime($seconds): string
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    $parts = [];
    if ($hours > 0) {
        $parts[] = $hours . " hour" . ($hours > 1 ? "s" : "");
    }
    if ($minutes > 0) {
        $parts[] = $minutes . " minute" . ($minutes > 1 ? "s" : "");
    }
    if ($seconds > 0) {
        $parts[] = $seconds . " second" . ($seconds > 1 ? "s" : "");
    }

    return implode(" and ", $parts);
}
