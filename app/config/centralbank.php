<?php

declare(strict_types=1);

return [
    'base_url' => 'https://www.yrgopelag.se/centralbank',
    'user'     => $_ENV['USER'] ?? 'Eddie',
    'api_key'  => $_ENV['API_KEY'] ?? '',
];
