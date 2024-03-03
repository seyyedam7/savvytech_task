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