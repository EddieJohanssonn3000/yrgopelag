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

function getRoomPrices(): array
{
    return [
        'budget'   => 2,
        'standard' => 5,
        'luxury'   => 10,
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

function calculateFeaturesPrice(array $selectedFeatures): int
{
    $availableFeatures = getAvailableFeatures();
    $tierPrices = getTierPrices();

    $total = 0;

    foreach ($selectedFeatures as $feature) {
        foreach ($availableFeatures as $category) {
            if (isset($category[$feature])) {
                $tier = $category[$feature];
                $total += $tierPrices[$tier];
            }
        }
    }

    return $total;
}

function calculateRoomPrice(string $room): int
{
    $tiers = getTierPrices();
    return $tiers[$room] ?? 0;
}

function calculateNights(string $checkIn, string $checkOut): int
{
    return (int) (
        (strtotime($checkOut) - strtotime($checkIn)) / 86400
    );
}

function calculateTotalPrice(
    string $room,
    string $checkIn,
    string $checkOut,
    array $features
): int {
    $nights = calculateNights($checkIn, $checkOut);
    $roomPrice = calculateRoomPrice($room);
    $featuresPrice = calculateFeaturesPrice($features);

    return ($roomPrice + $featuresPrice) * $nights;
}
