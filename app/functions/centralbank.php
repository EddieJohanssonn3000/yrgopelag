<?php

declare(strict_types=1);

/**
 * Fake-check: låtsas att transferCode är giltig
 */
function centralbankValidateTransferCode(
    string $transferCode,
    int $amount
): bool {
    // TEMP: Allt som inte är tomt är giltigt
    return trim($transferCode) !== '' && $amount > 0;
}

/**
 * Fake-deposit: låtsas att vi får pengar
 */
function centralbankDeposit(
    string $transferCode,
    int $amount
): bool {
    // TEMP: alltid OK
    return true;
}
