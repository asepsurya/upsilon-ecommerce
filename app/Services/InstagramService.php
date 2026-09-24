<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class InstagramService
{
    protected string $accessToken;

    protected string $accountId;

    protected string $apiVersion = 'v18.0';

    protected string $cacheKey = 'instagram_posts';

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token') ?? env('INSTAGRAM_ACCESS_TOKEN');
        $this->accountId = config('services.instagram.account_id') ?? env('INSTAGRAM_ACCOUNT_ID');
    }

    public function getRecentPosts(int $limit = 6): array
    {
        return Cache::remember($this->cacheKey, 3600, function () use ($limit) {
            $response = Http::get(
                "https://graph.instagram.com/{$this->apiVersion}/{$this->accountId}/media",
                [
                    'fields' => 'id,caption,media_type,media_url,permalink,timestamp,thumbnail_url',
                    'access_token' => $this->accessToken,
                    'limit' => $limit,
                ]
            );

            if ($response->failed()) {
                return [];
            }

            return $response->json('data', []);
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
