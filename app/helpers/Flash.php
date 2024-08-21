<?php

declare(strict_types=1);

namespace App\Helpers;

final class Flash
{
    public static function add(string $message): void
    {
        $_SESSION['_flash'][] = $message;
    }

    /** @return list<string> */
    public static function pull(): array
    {
        $messages = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);

        if (!is_array($messages)) {
            return [];
        }

        return array_values(array_filter($messages, 'is_string'));
    }
}
