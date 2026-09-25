<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected string $accessToken;

    protected string $accountId;

    protected string $apiVersion;

    protected string $baseUrl;

    protected string $cacheKey = 'instagram_posts';

    protected int $cacheTtl;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token') ?? env('INSTAGRAM_ACCESS_TOKEN');
        $this->accountId = config('services.instagram.account_id') ?? env('INSTAGRAM_ACCOUNT_ID');
        $this->apiVersion = config('services.instagram.api_version', env('INSTAGRAM_API_VERSION', 'v22.0'));
        $this->baseUrl = config('services.instagram.api_base_url', env('INSTAGRAM_API_BASE_URL', 'https://graph.facebook.com'));
        $this->cacheTtl = (int) config('services.instagram.cache_ttl', env('INSTAGRAM_CACHE_TTL', 3600));
    }

    public function getRecentPosts(int $limit = 6): array
    {
        return Cache::remember($this->cacheKey, $this->cacheTtl, function () use ($limit) {
            $response = Http::get(
                "{$this->baseUrl}/{$this->apiVersion}/{$this->accountId}/media",
                [
                    'fields' => 'id,caption,media_type,media_url,permalink,timestamp,thumbnail_url',
                    'access_token' => $this->accessToken,
                    'limit' => $limit,
                ]
            );

            if ($response->failed()) {
                Log::warning('Instagram API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [];
            }

            $data = $response->json('data', []);

            if (isset($data['error'])) {
                Log::warning('Instagram API returned an error', [
                    'error' => $data['error'],
                ]);

                return [];
            }

            if (! is_array($data)) {
                return [];
            }

            return $data;
        });
    }

    protected function formatCaption(string $caption): array
    {
        $lines = explode("\n", trim($caption));

        return $lines;
    }

    protected function extractCategory(string $caption): string
    {
        $lines = $this->formatCaption($caption);

        if (isset($lines[0])) {
            return str_replace('#', '', $lines[0]);
        }

        return 'Journal';
    }

    protected function extractTitle(string $caption): string
    {
        $lines = $this->formatCaption($caption);

        if (isset($lines[1])) {
            return $lines[1];
        }

        return 'Runway Chronicle';
    }

    protected function extractExcerpt(string $caption): string
    {
        $lines = $this->formatCaption($caption);

        if (isset($lines[2])) {
            return $lines[2];
        }

        return '';
    }

    protected function estimateReadingTime(string $text): int
    {
        $wordCount = str_word_count($text);
        $minutes = max(1, (int) ceil($wordCount / 200));

        return $minutes;
    }

    public function getFormattedPosts(int $limit = 6): array
    {
        $posts = $this->getRecentPosts($limit);

        return array_map(function ($post) {
            $caption = $post['caption'] ?? '';
            $timestamp = $post['timestamp'] ?? now()->toIso8601String();
            $date = Carbon::parse($timestamp);
            $readingTime = $this->estimateReadingTime($caption);

            return [
                'id' => $post['id'],
                'image' => $post['media_type'] === 'VIDEO'
                    ? ($post['thumbnail_url'] ?? $post['media_url'] ?? '')
                    : ($post['media_url'] ?? ''),
                'category' => $this->extractCategory($caption),
                'title' => $this->extractTitle($caption),
                'excerpt' => $this->extractExcerpt($caption) ?: 'Discover the latest from Atelier Noir\'s atelier.',
                'date' => $date->format('F d, Y'),
                'reading_time' => $readingTime,
                'permalink' => $post['permalink'] ?? '#',
            ];
        }, $posts);
    }
}
