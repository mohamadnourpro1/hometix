<?php

namespace App\Support;

class YouTube
{
    public static function extractVideoId(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $parts = parse_url($url);

        if (! is_array($parts) || ! isset($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $path = $parts['path'] ?? '';
        $query = [];

        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        $videoId = null;

        if ($host === 'youtu.be' || str_ends_with($host, '.youtu.be')) {
            $videoId = ltrim($path, '/');
        }

        if ($host === 'youtube.com' || $host === 'www.youtube.com' || str_ends_with($host, '.youtube.com')) {
            if (isset($query['v'])) {
                $videoId = $query['v'];
            }

            if (! $videoId && preg_match('#^/embed/([^/?]+)#', $path, $matches)) {
                $videoId = $matches[1];
            }

            if (! $videoId && preg_match('#^/shorts/([^/?]+)#', $path, $matches)) {
                $videoId = $matches[1];
            }
        }

        if (! $videoId || ! preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)) {
            return null;
        }

        return $videoId;
    }

    public static function toEmbedUrl(?string $url): ?string
    {
        $videoId = self::extractVideoId($url);

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
