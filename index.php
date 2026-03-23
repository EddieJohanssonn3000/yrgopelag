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

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'guest_id' => $_POST['guest_id'] ?? null,
        'transfer_code' => $_POST['transfer_code'] ?? null,
        'room' => $_POST['room'] ?? null,
        'check_in' => $_POST['check_in'] ?? null,
        'check_out' => $_POST['check_out'] ?? null,
        'features' => $_POST['features'] ?? [],
    ];

    // ===== Totalprice calculation =====
    $totalPrice = calculateTotalPrice(
        $data['room'],
        $data['check_in'],
        $data['check_out'],
        $data['features']
    );

    // ===== Check packageprice =====
    $packageDiscount = 0;
    $activePackage = null;
    if (!empty($data['room']) && !empty($data['features'])) {
        $activePackage = checkForPackageDiscount($data['room'], $data['features']);
        if ($activePackage) {
            $packageDiscount = $activePackage['savings'];
            $totalPrice = $totalPrice - $packageDiscount;
        }
    }

    // ===== Discount for returning guests =====
    $discount = 0;
    $discountPercent = 0;
    if (!empty($data['guest_id'])) {
        $discountPercent = getDiscountPercent($db, $data['guest_id']);
        if ($discountPercent > 0) {
            $discount = (int) round($totalPrice * $discountPercent / 100);
            $totalPrice = $totalPrice - $discount;
        }
    }

    // ===== Build features for recipies =====
    $featuresUsed = [];
    if (!empty($data['features'])) {
        foreach ($data['features'] as $feature) {
            [$activity, $tier] = explode(':', $feature);
            $featuresUsed[] = [
                'activity' => $activity,
                'tier' => $tier,
            ];
        }
    }

    // ===== Preview - only show price =====
    if (($_POST['action'] ?? null) === 'preview') {
        require __DIR__ . '/views/booking-form.php';
        require __DIR__ . '/views/footer.php';
        exit;
    }

    // ===== Booking =====
    if (($_POST['action'] ?? null) === 'book') {

        // Validate if transfer code exists 
        if (empty($data['transfer_code'])) {
            $errors[] = 'Transfer code is required to make a reservation.';
        }

        // Validate transfer-code amount 
        if (empty($errors)) {
            $isValidPayment = centralbankValidateTransferCode(
                $data['transfer_code'],
                $totalPrice
            );
            if (!$isValidPayment) {
                $errors[] = 'Invalid transfer code or incorrect amount. Expected: ' . $totalPrice . ' credits.';
            }
        }

        // Check if rooms are available 
        if (empty($errors) && !isRoomAvailable($db, $data['room'], $data['check_in'], $data['check_out'])) {
            $errors[] = 'This room is not available for the selected dates.';
        }

        // If no errors, go through with booking 
        if (empty($errors)) {
            // make diposit
            $depositSuccess = centralbankDeposit($data['transfer_code']);
            if (!$depositSuccess) {
                $errors[] = 'Payment failed during deposit.';
            }
        }

        if (empty($errors)) {
            // Create recipe 
            $receiptCreated = centralbankCreateReceipt(
                $data['guest_id'],
                $data['check_in'],
                $data['check_out'],
                $featuresUsed,
                $totalPrice
            );
            if (!$receiptCreated) {
                $errors[] = 'Could not create receipt.';
            }
        }

        if (empty($errors)) {
            // Save booking 
            $result = saveBooking($db, $data);
            if ($result['success']) {
                $checkIn = $data['check_in'];
                $checkOut = $data['check_out'];
                $room = $data['room'];
                $features = $data['features'];
                $guestId = $data['guest_id'];
                $total = $totalPrice;

                require __DIR__ . '/views/booking-result.php';
                require __DIR__ . '/views/footer.php';
                exit;
            } else {
                $errors = $result['errors'];
            }
        }
    }
}

require __DIR__ . '/views/booking-form.php';
require __DIR__ . '/views/footer.php';


// I will find you and i will...