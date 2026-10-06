<?php

namespace Tests\Feature;

use App\Services\InstagramService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InstagramFeedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.instagram.access_token' => 'test-token',
            'services.instagram.account_id' => 'test-account',
            'services.instagram.username' => 'upsilon.official',
        ]);

        Cache::flush();
    }

    /**
     * @return array<string, mixed>
     */
    protected function apiResponse(array $overrides = []): array
    {
        return array_merge([
            'data' => [
                [
                    'id' => 'post-1',
                    'caption' => "Sneaker Drop\nNike Air Max AP\nFresh pair just landed at Upsilon.",
                    'media_type' => 'IMAGE',
                    'media_url' => 'https://cdn.example.com/post-1.jpg',
                    'permalink' => 'https://www.instagram.com/p/post-1/',
                    'timestamp' => '2026-09-01T10:00:00+0000',
                    'like_count' => 1200,
                    'comments_count' => 34,
                    'username' => 'upsilon.official',
                ],
            ],
            'paging' => [
                'cursors' => ['after' => 'cursor-abc'],
            ],
        ], $overrides);
    }

    public function test_formatted_posts_include_engagement_metrics(): void
    {
        Http::fake([
            '*' => Http::response($this->apiResponse()),
        ]);

        $posts = app(InstagramService::class)->getFormattedPosts(6);

        $this->assertCount(1, $posts);
        $this->assertSame('post-1', $posts[0]['id']);
        $this->assertSame(1200, $posts[0]['like_count']);
        $this->assertSame(34, $posts[0]['comments_count']);
        $this->assertSame('https://cdn.example.com/post-1.jpg', $posts[0]['image']);
    }

    public function test_video_posts_use_the_thumbnail_as_image(): void
    {
        Http::fake([
            '*' => Http::response([
                'data' => [
                    [
                        'id' => 'reel-1',
                        'caption' => 'Reel\nNew Drop\nWatch it in motion.',
                        'media_type' => 'VIDEO',
                        'media_url' => 'https://cdn.example.com/reel-1.mp4',
                        'thumbnail_url' => 'https://cdn.example.com/reel-1-thumb.jpg',
                        'permalink' => 'https://www.instagram.com/reel/reel-1/',
                        'timestamp' => '2026-09-02T10:00:00+0000',
                        'like_count' => 5,
                        'comments_count' => 1,
                    ],
                ],
            ]),
        ]);

        $posts = app(InstagramService::class)->getFormattedPosts(6);

        $this->assertSame('https://cdn.example.com/reel-1-thumb.jpg', $posts[0]['image']);
    }

    public function test_feed_endpoint_returns_posts_and_next_cursor(): void
    {
        Http::fake([
            '*' => Http::response($this->apiResponse()),
        ]);

        $response = $this->getJson(route('instagram.feed', ['limit' => 6]));

        $response->assertOk();
        $response->assertJsonPath('posts.0.id', 'post-1');
        $response->assertJsonPath('posts.0.like_count', 1200);
        $response->assertJsonPath('next_cursor', 'cursor-abc');
    }

    public function test_feed_endpoint_passes_the_cursor_to_the_api(): void
    {
        Http::fake([
            '*' => Http::response($this->apiResponse(['paging' => ['cursors' => ['after' => 'cursor-def']]])),
        ]);

        $response = $this->getJson(route('instagram.feed', ['after' => 'cursor-abc', 'limit' => 3]));

        $response->assertOk();
        $response->assertJsonPath('next_cursor', 'cursor-def');

        Http::assertSent(function ($request) {
            return $request['after'] === 'cursor-abc' && (int) $request['limit'] === 3;
        });
    }

    public function test_feed_endpoint_returns_empty_payload_when_the_api_fails(): void
    {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Invalid token']], 401),
        ]);

        $response = $this->getJson(route('instagram.feed'));

        $response->assertOk();
        $response->assertJsonPath('posts', []);
        $response->assertJsonPath('next_cursor', null);
    }

    public function test_feed_endpoint_validates_the_limit(): void
    {
        $response = $this->getJson(route('instagram.feed', ['limit' => 500]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('limit');
    }

    public function test_ig_insta_login_tokens_are_sent_to_graph_instagram_com(): void
    {
        config(['services.instagram.access_token' => 'IGAA-test-token']);

        Http::fake(['*' => Http::response($this->apiResponse())]);

        app(InstagramService::class)->getFormattedPosts(6);

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'https://graph.instagram.com/');
        });
    }

    public function test_facebook_login_tokens_are_sent_to_graph_facebook_com(): void
    {
        config(['services.instagram.access_token' => 'EAAB-test-token']);

        Http::fake(['*' => Http::response($this->apiResponse())]);

        app(InstagramService::class)->getFormattedPosts(6);

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'https://graph.facebook.com/');
        });
    }

    public function test_explicit_base_url_overrides_token_auto_detection(): void
    {
        config([
            'services.instagram.access_token' => 'IGAA-test-token',
            'services.instagram.api_base_url' => 'https://graph.facebook.com',
        ]);

        Http::fake(['*' => Http::response($this->apiResponse())]);

        app(InstagramService::class)->getFormattedPosts(6);

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'https://graph.facebook.com/');
        });
    }

    public function test_missing_credentials_short_circuit_without_calling_the_api(): void
    {
        config([
            'services.instagram.access_token' => null,
            'services.instagram.account_id' => null,
        ]);

        Http::fake();

        $this->assertFalse(app(InstagramService::class)->isConfigured());
        $this->assertSame([], app(InstagramService::class)->getFormattedPosts(6));

        Http::assertNothingSent();
    }

    public function test_component_renders_tiles_lightbox_and_load_more_button(): void
    {
        Http::fake([
            '*' => Http::response($this->apiResponse()),
        ]);

        $html = Blade::render(
            '<x-instagram-feed :limit="6" :columns="3" />',
        );

        $this->assertStringContainsString('data-feed-url="'.route('instagram.feed').'"', $html);
        $this->assertStringContainsString('data-next-cursor="cursor-abc"', $html);
        $this->assertStringContainsString('https://cdn.example.com/post-1.jpg', $html);
        $this->assertStringContainsString('data-lightbox', $html);
        $this->assertStringContainsString('data-load-more', $html);
        $this->assertStringContainsString('Follow Us', $html);
    }

    public function test_component_falls_back_when_no_posts_are_available(): void
    {
        Http::fake([
            '*' => Http::response(['data' => []]),
        ]);

        $html = Blade::render('<x-instagram-feed :limit="6" />');

        $this->assertStringContainsString('Instagram posts are unavailable right now.', $html);
        $this->assertStringNotContainsString('data-lightbox', $html);
    }
}
