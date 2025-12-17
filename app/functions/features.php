<?php

declare(strict_types=1);

function getTierPrices(): array
{
    return [
        'economy'  => 2,
        'basic'    => 5,
        'premium'  => 10,
        'superior' => 17,
    ];
}

function getAvailableFeatures(): array
{
    return [
        'water' => [
            'pool' => 'economy',
            'scuba_diving' => 'basic',
            'olympic_pool' => 'premium',
            'waterpark_fire_minibar' => 'superior',
        ],
        'games' => [
            'yahtzee' => 'economy',
            'ping_pong' => 'basic',
            'ps5' => 'premium',
            'casino' => 'superior',
        ],
        'wheels' => [
            'unicycle' => 'economy',
            'bicycle' => 'basic',
            'trike' => 'premium',
            'four_wheeled_motorized_beast' => 'superior',
        ],
        'hotel_specific' => [
            'haunted_house' => 'economy',
            'ghost_tour' => 'basic',
            'seance_with_medium' => 'premium',
            'cursed_master_suite' => 'superior',
        ],
    ];
}
