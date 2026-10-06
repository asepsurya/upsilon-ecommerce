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
        // config() already resolves the env() values, so no env() fallback here:
        // `config(...) ?? env(...)` would silently revive a value whenever the
        // config key is intentionally set to null.
        $this->accessToken = (string) config('services.instagram.access_token');
        $this->accountId = (string) config('services.instagram.account_id');
        $this->apiVersion = (string) config('services.instagram.api_version');
        $this->cacheTtl = (int) config('services.instagram.cache_ttl');
        $this->baseUrl = $this->resolveBaseUrl();
    }

    /**
     * Instagram hands out two different token families, and each one is only
     * accepted by its own graph host:
     *
     *  - IGAA...  -> "Instagram API with Instagram Login" -> graph.instagram.com
     *  - EAA/EAAD/EAAG/EAAB... -> "Facebook Login"          -> graph.facebook.com
     *
     * Sending a token to the wrong host yields `OAuthException code 190`
     * ("Cannot parse access token"), so the host is derived from the token
     * unless it is pinned explicitly via config/env.
     */
    protected function resolveBaseUrl(): string
    {
        $configured = config('services.instagram.api_base_url');

        if (filled($configured)) {
            return rtrim($configured, '/');
        }

        return str_starts_with($this->accessToken, 'IGAA')
            ? 'https://graph.instagram.com'
            : 'https://graph.facebook.com';
    }

    public function isConfigured(): bool
    {
        return filled($this->accessToken) && filled($this->accountId);
    }

    /**
     * Fetch a single page of the Instagram media edge.
     *
     * @return array{posts: array<int, array<string, mixed>>, next_cursor: string|null}
     */
    public function getPostPage(int $limit = 6, ?string $after = null): array
    {
        $limit = max(1, min($limit, 100));

        if (! $this->isConfigured()) {
            Log::warning('Instagram feed skipped: missing INSTAGRAM_ACCESS_TOKEN and/or INSTAGRAM_ACCOUNT_ID.');

            return ['posts' => [], 'next_cursor' => null];
        }

        $cacheKey = $this->cacheKey.'_page_'.$limit.($after ? '_'.$after : '_first');

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($limit, $after) {
            $query = [
                'fields' => implode(',', $this->mediaFields()),
                'access_token' => $this->accessToken,
                'limit' => $limit,
            ];

            if ($after) {
                $query['after'] = $after;
            }

            $response = Http::get(
                "{$this->baseUrl}/{$this->apiVersion}/{$this->accountId}/media",
                $query
            );

            if ($response->failed()) {
                Log::warning('Instagram API request failed', [
                    'host' => $this->baseUrl,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return ['posts' => [], 'next_cursor' => null];
            }

            $error = $response->json('error');

            if ($error) {
                Log::warning('Instagram API returned an error', [
                    'error' => $error,
                ]);

                return ['posts' => [], 'next_cursor' => null];
            }

            $posts = $response->json('data', []);

            if (! is_array($posts)) {
                return ['posts' => [], 'next_cursor' => null];
            }

            return [
                'posts' => $posts,
                'next_cursor' => $response->json('paging.cursors.after'),
            ];
        });
    }

    /**
     * Fields that are valid on the `/{ig-user-id}/media` edge for both
     * Instagram Login and Facebook Login. Requesting an unsupported field
     * makes Meta reject the whole request, so the list stays minimal.
     *
     * @return array<int, string>
     */
    protected function mediaFields(): array
    {
        return [
            'id',
            'caption',
            'media_type',
            'media_url',
            'permalink',
            'timestamp',
            'thumbnail_url',
            'like_count',
            'comments_count',
        ];
    }

    public function getRecentPosts(int $limit = 6, ?string $after = null): array
    {
        return $this->getPostPage($limit, $after)['posts'];
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

    /**
     * @param  array<string, mixed>  $post
     * @return array<string, mixed>
     */
    protected function formatPost(array $post): array
    {
        $caption = $post['caption'] ?? '';
        $timestamp = $post['timestamp'] ?? now()->toIso8601String();
        $date = Carbon::parse($timestamp);

        return [
            'id' => $post['id'] ?? '',
            'image' => ($post['media_type'] ?? 'IMAGE') === 'VIDEO'
                ? ($post['thumbnail_url'] ?? $post['media_url'] ?? '')
                : ($post['media_url'] ?? ''),
            'media_url' => $post['media_url'] ?? '',
            'thumbnail_url' => $post['thumbnail_url'] ?? '',
            'media_type' => $post['media_type'] ?? 'IMAGE',
            'category' => $this->extractCategory($caption),
            'title' => $this->extractTitle($caption),
            'excerpt' => $this->extractExcerpt($caption),
            'caption' => $caption,
            'date' => $date->format('F d, Y'),
            'timestamp' => $date->toIso8601String(),
            'permalink' => $post['permalink'] ?? '#',
            'like_count' => (int) ($post['like_count'] ?? 0),
            'comments_count' => (int) ($post['comments_count'] ?? 0),
            'username' => $post['username'] ?? config('services.instagram.username'),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getFormattedPosts(int $limit = 6, ?string $after = null): array
    {
        return array_map(
            fn (array $post): array => $this->formatPost($post),
            $this->getRecentPosts($limit, $after)
        );
    }

    /**
     * @return array{posts: array<int, array<string, mixed>>, next_cursor: string|null}
     */
    public function getFormattedPostPage(int $limit = 6, ?string $after = null): array
    {
        $page = $this->getPostPage($limit, $after);

        return [
            'posts' => array_map(
                fn (array $post): array => $this->formatPost($post),
                $page['posts']
            ),
            'next_cursor' => $page['next_cursor'],
        ];
    }

    public function getProfileUrl(): string
    {
        $username = config('services.instagram.username');

        return $username
            ? 'https://www.instagram.com/'.ltrim($username, '@').'/'
            : 'https://www.instagram.com/';
    }
}
