<?php

declare(strict_types=1);

require __DIR__ . '/app/config/database.php';

$sql = "
INSERT INTO bookings
(guest_id, transfer_code, room, check_in, check_out, features)
VALUES
(:guest_id, :transfer_code, :room, :check_in, :check_out, :features)
";

$stmt = $db->prepare($sql);

$stmt->execute([
    'guest_id'      => 'TEST123',
    'transfer_code' => 'BANK-999',
    'room'          => 'standard',
    'check_in'      => '2026-01-10',
    'check_out'     => '2026-01-12',
    'features'      => 'pool, minibar'
]);

echo "✅ Testbokning sparad!";
