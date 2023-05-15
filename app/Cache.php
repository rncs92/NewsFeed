<?php

namespace NewsFeed;

use Carbon\Carbon;
class Cache
{
    public static function set(string $key, string $data, int $ttl = 120): void
    {
        $cacheFile = '../cache/' . $key;

        file_put_contents($cacheFile, json_encode([
            'expires_at' => Carbon::now()->addSeconds($ttl)->toTimeString(),
            'content' => $data
        ]));
    }

    public static function delete(string $key): void
    {
        unlink('../cache/' . $key);
    }

    public static function get(string $key): ?string
    {
        if (!self::check($key)) {
            return null;
        }

        $decoded = json_decode(file_get_contents('../cache/' . $key));

        return $decoded->content;
    }

    public static function check(string $key): bool
    {
        if (!file_exists('../cache/' . $key)) {
            return false;
        }


        $content = json_decode(file_get_contents('../cache/' . $key));

        return Carbon::parse($content->expires_at)->greaterThan(Carbon::now());
    }
}