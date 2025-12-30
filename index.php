<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/functions/booking.php';
require_once __DIR__ . '/app/functions/features.php';
require_once __DIR__ . '/app/functions/centralbank.php';

require __DIR__ . '/views/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'guest_id' => $_POST['guest_id'] ?? null,
        'transfer_code' => $_POST['transfer_code'] ?? null,
        'room' => $_POST['room'] ?? null,
        'check_in' => $_POST['check_in'] ?? null,
        'check_out' => $_POST['check_out'] ?? null,
        'features' => $_POST['features'] ?? [],
    ];

    $totalPrice = calculateTotalPrice(
        $data['room'],
        $data['check_in'],
        $data['check_out'],
        $data['features']
    );

    // ===== Rabatt för återkommande gäster =====
    $discount = 0;
    $discountPercent = 0;
    if (!empty($data['guest_id'])) {
        $discountPercent = getDiscountPercent($db, $data['guest_id']);
        if ($discountPercent > 0) {
            $discount = (int) round($totalPrice * $discountPercent / 100);
            $totalPrice = $totalPrice - $discount;
        }
    }

    if (($_POST['action'] ?? null) === 'preview') {
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    if (($_POST['action'] ?? null) === 'book' && empty($data['transfer_code'])) {
        $errors[] = 'Transfer code is required to make a reservation.';
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    // ===== 1. Datum → antal nätter =====
    $checkInDate = new DateTime($data['check_in']);
    $checkOutDate = new DateTime($data['check_out']);
    $nights = $checkInDate->diff($checkOutDate)->days;

    // ===== 2. Rumspris =====
    $roomPrices = [
        'budget' => 1,
        'standard' => 2,
        'luxury' => 4,
    ];
    $roomPrice = $roomPrices[$data['room']];
    $roomTotal = $roomPrice * $nights;

    // ===== 3. Feature-priser =====
    $tierPrices = [
        'economy' => 2,
        'basic' => 5,
        'premium' => 10,
        'superior' => 17,
    ];

    $featuresUsed = [];
    $featuresTotal = 0;

    if (!empty($data['features'])) {
        foreach ($data['features'] as $feature) {
            [$activity, $tier] = explode(':', $feature);
            $featuresUsed[] = [
                'activity' => $activity,
                'tier' => $tier,
            ];
            $featuresTotal += $tierPrices[$tier];
        }
    }

    $guestId  = $data['guest_id'];
    $checkIn  = $data['check_in'];
    $checkOut = $data['check_out'];

    // ===== Validera transferCode =====
    if (($_POST['action'] ?? null) === 'book') {
        $isValidPayment = centralbankValidateTransferCode(
            $data['transfer_code'],
            $totalPrice
        );

        if (!$isValidPayment) {
            $errors[] = 'Invalid transfer code or incorrect amount. Expected: ' . $totalPrice . ' credits.';
            require __DIR__ . '/views/booking-form.php';
            require __DIR__ . '/views/footer.php';
            exit;
        }
    }

    // ===== Kontrollera om rum är ledigt =====
    if (!isRoomAvailable($db, $data['room'], $data['check_in'], $data['check_out'])) {
        $errors[] = 'This room is not available for the selected dates.';
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    // ===== Gör deposit =====
    $depositSuccess = centralbankDeposit($data['transfer_code']);

    if (!$depositSuccess) {
        $errors[] = 'Payment failed during deposit.';
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    // ===== Skapa receipt EFTER deposit =====
    $receiptCreated = centralbankCreateReceipt(
        $data['guest_id'],
        $data['check_in'],
        $data['check_out'],
        $featuresUsed,
        $totalPrice
    );

    if (!$receiptCreated) {
        $errors[] = 'Could not create receipt.';
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    // ===== Spara bokning =====
    $result = saveBooking($db, $data);

    if ($result['success']) {
        $checkIn = $data['check_in'];
        $checkOut = $data['check_out'];
        $room = $data['room'];
        $features = $data['features'];
        $guestId = $data['guest_id'];
        $total = $totalPrice;

        require __DIR__ . '/views/booking-result.php';
    } else {
        $errors = $result['errors'];
        require __DIR__ . '/views/booking-form.php';
    }
} else {
    require __DIR__ . '/views/booking-form.php';
}

require __DIR__ . '/views/footer.php';
