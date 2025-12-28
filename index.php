<?php

declare(strict_types=1);

require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/functions/booking.php';
require_once __DIR__ . '/app/functions/features.php';


require __DIR__ . '/app/functions/centralbank.php';
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

    if (($_POST['action'] ?? null) === 'preview') {
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    if (($_POST['action'] ?? null) === 'book') {

        // 1. Validera transfer code
        $isValidPayment = centralbankValidateTransferCode(
            $data['transfer_code'],
            $totalPrice
        );

        if (!$isValidPayment) {
            $errors[] = 'Payment could not be verified.';
            require __DIR__ . '/views/booking-form.php';
            require __DIR__ . '/views/footer.php';
            exit;
        }

        // 2. Skapa receipt
        $receiptCreated = centralbankCreateReceipt(
            $data['transfer_code'],
            $totalPrice,
            'Booking for Spooky Hotel'
        );

        if (!$receiptCreated) {
            $errors[] = 'Could not create receipt.';
            require __DIR__ . '/views/booking-form.php';
            require __DIR__ . '/views/footer.php';
            exit;
        }

        // 3. Gör deposit (dra pengar)
        $depositSuccess = centralbankDeposit($data['transfer_code']);

        if (!$depositSuccess) {
            $errors[] = 'Payment failed during deposit.';
            require __DIR__ . '/views/booking-form.php';
            require __DIR__ . '/views/footer.php';
            exit;
        }

        $result = saveBooking($db, $data);

        if ($result['success']) {

            $checkIn  = $data['check_in'];
            $checkOut = $data['check_out'];
            $room     = $data['room'];
            $features = $data['features'];
            $guestId  = $data['guest_id'];
            $total    = $totalPrice;

            require __DIR__ . '/views/booking-result.php';
        } else {
            $errors = $result['errors'];
            require __DIR__ . '/views/booking-form.php';
        }
    }
} else {
    require __DIR__ . '/views/booking-form.php';
}

require __DIR__ . '/views/footer.php';
