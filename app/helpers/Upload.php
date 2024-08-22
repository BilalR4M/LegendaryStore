<?php

declare(strict_types=1);

namespace App\Helpers;

final class Upload
{
    public const MAX_BYTES = 2000000;

    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    /** @param array<string, mixed> $file */
    public static function store(array $file): ?string
    {
        $error = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($error !== UPLOAD_ERR_OK) {
            Flash::add('image upload failed');
            return null;
        }

        $size = (int) ($file['size'] ?? 0);
        $tmp = (string) ($file['tmp_name'] ?? '');
        if ($size < 1 || $size > self::MAX_BYTES || !is_uploaded_file($tmp)) {
            Flash::add('image size is too large');
            return null;
        }

        $original = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        if ($original === 'jpeg') {
            $original = 'jpg';
        }
        if (!in_array($original, ['jpg', 'png', 'webp'], true)) {
            Flash::add('image type is not allowed');
            return null;
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmp);
        if (!is_string($mime) || !isset(self::ALLOWED[$mime])) {
            Flash::add('image type is not allowed');
            return null;
        }

        $filename = bin2hex(random_bytes(16)) . '.' . self::ALLOWED[$mime];
        $destination = self::directory() . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($tmp, $destination)) {
            Flash::add('image upload failed');
            return null;
        }

        return $filename;
    }

    public static function remove(?string $filename): void
    {
        if ($filename === null || $filename === '' || basename($filename) !== $filename) {
            return;
        }

        $path = self::directory() . DIRECTORY_SEPARATOR . $filename;
        if (is_file($path)) {
            unlink($path);
        }
    }

    private static function directory(): string
    {
        $dir = dirname(__DIR__, 2) . '/public/uploads';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        return $dir;
    }
}
