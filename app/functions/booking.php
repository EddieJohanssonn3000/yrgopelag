<?php

declare(strict_types=1);

require_once __DIR__ . '/features.php';

function saveBooking(PDO $db, array $data): array
{
    $errors = [];

    $guestId      = $data['guest_id'] ?? null;
    $transferCode = $data['transfer_code'] ?? null;
    $room         = $data['room'] ?? null;
    $checkIn      = $data['check_in'] ?? null;
    $checkOut     = $data['check_out'] ?? null;
    $features     = $data['features'] ?? [];

    if (!$guestId || !$transferCode || !$room || !$checkIn || !$checkOut) {
        $errors[] = 'Alla fält måste fyllas i.';
    }

    if ($checkIn && $checkOut && $checkOut <= $checkIn) {
        $errors[] = 'Utcheckningsdatum måste vara efter incheckningsdatum.';
    }

    if (!empty($errors)) {
        return [
            'success' => false,
            'errors'  => $errors,
        ];
    }

    $stmt = $db->prepare(
        'INSERT INTO bookings
        (guest_id, transfer_code, room, check_in, check_out, features)
        VALUES
        (:guest_id, :transfer_code, :room, :check_in, :check_out, :features)'
    );

    $stmt->execute([
        ':guest_id'      => $guestId,
        ':transfer_code' => $transferCode,
        ':room'          => $room,
        ':check_in'      => $checkIn,
        ':check_out'     => $checkOut,
        ':features'      => json_encode($features),
    ]);

    return [
        'success'    => true,
        'booking_id' => (int) $db->lastInsertId(),
    ];
}

function isRoomAvailable(PDO $db, string $room, string $checkIn, string $checkOut): bool
{
    $stmt = $db->prepare(
        'SELECT COUNT(*) FROM bookings 
         WHERE room = :room 
         AND check_out > :check_in 
         AND check_in < :check_out'
    );

    $stmt->execute([
        ':room' => $room,
        ':check_in' => $checkIn,
        ':check_out' => $checkOut,
    ]);

    return $stmt->fetchColumn() === 0;
}

function calculateTotalPrice(
    string $room,
    string $checkIn,
    string $checkOut,
    array $selectedFeatures
): int {
    $total = 0;


    $roomPrices = getRoomPrices();
    $pricePerNight = $roomPrices[$room] ?? 0;

    $nights = (strtotime($checkOut) - strtotime($checkIn)) / 86400;
    if ($nights < 1) {
        $nights = 1;
    }

    $total += $pricePerNight * $nights;

    $tierPrices = getTierPrices();

    foreach ($selectedFeatures as $feature) {
        // Ex: "wheels:economy"
        [$category, $tier] = explode(':', $feature);

        if (isset($tierPrices[$tier])) {
            $total += $tierPrices[$tier];
        }
    }


    return $total;
}
