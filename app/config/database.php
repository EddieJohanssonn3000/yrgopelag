<?php

declare(strict_types=1);

try {
    $db = new PDO(
        'sqlite:' . __DIR__ . '/../database/yrgopelag.db'
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Databasfel: ' . $e->getMessage());
}
