<?php

declare(strict_types=1);

namespace App\Helpers;

final class Validate
{
    public const CATEGORIES = ['game', 'movie', 'music', 'offer', 'giftcard'];

    public const PAYMENT_METHODS = ['credit card', 'paytm', 'paypal'];

    public const PAYMENT_STATUSES = ['pending', 'completed'];

    public static function id(mixed $value): ?int
    {
        if (is_int($value) || (is_string($value) && preg_match('/^[1-9]\d*$/', $value) === 1)) {
            return (int) $value;
        }

        return null;
    }

    public static function text(mixed $value, int $max): string
    {
        $text = trim((string) $value);
        if (strlen($text) > $max) {
            return substr($text, 0, $max);
        }

        return $text;
    }

    public static function email(mixed $value, int $max = 50): ?string
    {
        $email = trim((string) $value);
        $filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($filtered === false || strlen($filtered) > $max) {
            return null;
        }

        return $filtered;
    }

    public static function price(mixed $value): ?int
    {
        if (is_int($value)) {
            $price = $value;
        } elseif (is_string($value) && preg_match('/^\d+$/', $value) === 1) {
            $price = (int) $value;
        } else {
            return null;
        }

        if ($price > 999999999) {
            return null;
        }

        return $price;
    }

    public static function qty(mixed $value): ?int
    {
        if (!is_numeric($value)) {
            return null;
        }

        $qty = (int) $value;
        if ($qty < 1 || $qty > 99) {
            return null;
        }

        return $qty;
    }

    public static function category(mixed $value): ?string
    {
        $category = strtolower(trim((string) $value));

        return in_array($category, self::CATEGORIES, true) ? $category : null;
    }

    public static function phone(mixed $value, int $max = 10): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $value) ?? '';
        if ($digits === '' || strlen($digits) > $max) {
            return null;
        }

        return $digits;
    }

    public static function password(mixed $value): ?string
    {
        $password = (string) $value;
        $length = strlen($password);
        if ($length < 3 || $length > 72) {
            return null;
        }

        return $password;
    }
}
