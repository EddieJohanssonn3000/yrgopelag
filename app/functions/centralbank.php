<?php

declare(strict_types=1);

function centralbankValidateTransferCode(string $transferCode, int $totalCost): bool
{
    $config = require __DIR__ . '/../config/centralbank.php';

    $url = $config['base_url'] . '/transferCode';

    $data = [
        'transferCode' => $transferCode,
        'totalCost' => $totalCost,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return false;
    }

    $result = json_decode($response, true);
    return isset($result['status']) && $result['status'] === 'success';
}

function centralbankCreateReceipt(
    string $guestName,
    string $arrivalDate,
    string $departureDate,
    array $featuresUsed,
    int $totalCost
): bool {
    $config = require __DIR__ . '/../config/centralbank.php';

    $url = $config['base_url'] . '/receipt';

    $data = [
        'user' => $config['user'],
        'api_key' => $config['api_key'],
        'guest_name' => $guestName,
        'arrival_date' => $arrivalDate,
        'departure_date' => $departureDate,
        'features_used' => $featuresUsed,
        'total_cost' => $totalCost,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        error_log('Centralbank receipt error: HTTP ' . $httpCode);
        return false;
    }

    $result = json_decode($response, true);
    if (isset($result['error'])) {
        error_log('Centralbank receipt error: ' . $result['error']);
        return false;
    }

    return true;
}

function centralbankDeposit(string $transferCode): bool
{
    $config = require __DIR__ . '/../config/centralbank.php';

    $url = $config['base_url'] . '/deposit';

    $data = [
        'user' => $config['user'],
        'transferCode' => $transferCode,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        error_log('Centralbank deposit error: HTTP ' . $httpCode);
        return false;
    }

    $result = json_decode($response, true);
    if (isset($result['error'])) {
        error_log('Centralbank deposit error: ' . $result['error']);
        return false;
    }

    return true;
}
