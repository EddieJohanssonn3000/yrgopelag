<?php

declare(strict_types=1);

function centralbankValidateTransferCode(
    string $transferCode,
    int $amount
): bool {
    $config = require __DIR__ . '/../config/centralbank.php';

    $payload = json_encode([
        'transferCode' => $transferCode,
        'totalCost' => $amount,
    ]);

    $ch = curl_init($config['base_url'] . '/transferCode');

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS     => $payload,
    ]);


    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);


    if ($status !== 200) {
        error_log('Centralbank HTTP error: ' . $response);
        return false;
    }

    $data = json_decode($response, true);


    if (!is_array($data) || ($data['status'] ?? null) !== 'success') {
        error_log('Centralbank validation failed: ' . $response);
        return false;
    }

    return true;
}



function centralbankCreateReceipt(
    string $guestId,
    string $checkIn,
    string $checkOut,
    array $featuresUsed,
    int $totalPrice
): bool {
    $config = require __DIR__ . '/../config/centralbank.php';

    $payload = json_encode([
        'user'           => $config['user'],
        'api_key'        => $config['api_key'],
        'guest_name'     => $guestId,
        'arrival_date'   => $checkIn,
        'departure_date' => $checkOut,
        'total_price'    => $totalPrice,
        'features_used'  => $featuresUsed,
        'star_rating'    => 3,
    ]);

    $ch = curl_init($config['base_url'] . '/receipt');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => $payload,
    ]);

    // 🔥 HÄR ÄR SKILLNADEN
    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);

    curl_close($ch);

    // 🔍 DEBUG – kommentera bort sen
    // if ($status !== 200) {
    //     echo '<pre>';
    //     echo "HTTP STATUS: $status\n";
    //     echo "CURL ERROR: $error\n";
    //     echo "RESPONSE:\n";
    //     var_dump($response);
    //     die;
    // }

    return true;
}



function centralbankDeposit(
    string $transferCode
): bool {
    $config = require __DIR__ . '/../config/centralbank.php';

    if (empty($config['user'])) {
        error_log('Centralbank configuration error: Missing user');
        return false;
    }

    $payload = json_encode([
        'transferCode' => $transferCode,
        'user' => $config['user'],
    ]);

    $url = $config['base_url'] . '/deposit';

    // Anrop utan -w flaggan
    $command = "curl -s -X POST " .
        "-H 'Content-Type: application/json' " .
        "-d " . escapeshellarg($payload) . " " .
        escapeshellarg($url);

    $result = shell_exec($command);

    // Tomt resultat eller inget fel = success
    // Om det finns ett fel returneras JSON med "error"
    if ($result === null || $result === '' || $result === false) {
        return true;
    }

    $data = json_decode($result, true);
    if (isset($data['error'])) {
        error_log('Centralbank deposit error: ' . $data['error']);
        return false;
    }

    return true;
}
