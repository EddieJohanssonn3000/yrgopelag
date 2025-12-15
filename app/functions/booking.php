<?php

declare(strict_types=1);

function saveBooking(PDO $db, array $data): array
{
    $errors = [];

    $checkIn  = $data['check_in']  ?? null;
    $checkOut = $data['check_out'] ?? null;
    $room     = $data['room']      ?? null;

    if (!$checkIn || !$checkOut || !$room) {
        $errors[] = 'Alla fält måste fyllas i.';
    }

    if ($checkIn && $checkOut && $checkOut <= $checkIn) {
        $errors[] = 'Utcheckningsdatum måste vara efter incheckningsdatum.';
    }

    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors
        ];
    }

    $stmt = $db->prepare(
        'INSERT INTO bookings (check_in, check_out, room)
         VALUES (:check_in, :check_out, :room)'
    );

    $stmt->execute([
        ':check_in'  => $checkIn,
        ':check_out' => $checkOut,
        ':room'      => $room,
    ]);

    return [
        'success' => true,
        'booking_id' => (int) $db->lastInsertId()
    ];
}
