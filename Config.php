<?php

namespace App;

class Config
{
    // Database configuration
    public const DB_CHARSET = 'utf8';
    public const DB_NAME = 'jv_project';
    public const DB_HOST = 'localhost';
    public const DB_USERNAME = 'root';
    public const DB_PASSWORD = '';

    public const ALLOWED_TAGS = [
        '<h2>',
        '<h3>',
        '<h4>',
        '<p>',
        '<span>',
        '<div>',
        '<i>',
        '<b>',
        '<u>',
        '<style>'
    ];
}