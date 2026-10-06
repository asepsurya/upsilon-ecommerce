@php
    use App\Services\InstagramService;
    use Illuminate\Support\Str;

    $instagramService = app(InstagramService::class);
    $page = $instagramService->getFormattedPostPage($limit ?? 6);
    $posts = $page['posts'];
    $nextCursor = $page['next_cursor'];

    $instagramProfileUrl = $instagramService->getProfileUrl();
    $instagramUsername = config('services.instagram.username');
    $feedId = 'igfeed-' . Str::random(8);

    $gridClasses = match ((int) ($columns ?? 6)) {
        3 => 'grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-4',
        default => 'grid-cols-3 sm:grid-cols-6',
    };
@endphp

@if (!empty($posts))
    <div class="instagram-feed" id="{{ $feedId }}" data-feed-url="{{ route('instagram.feed') }}"
        data-per-page="{{ (int) ($limit ?? 6) }}" data-profile-url="{{ $instagramProfileUrl }}"
        data-next-cursor="{{ $nextCursor ?? '' }}" data-grid-class="{{ $gridClasses }}">

        <script type="application/json"
            data-feed-posts>@json($posts, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)</script>

        {{-- ================= GRID ================= --}}
        <div class="instagram-feed-grid grid {{ $gridClasses }} gap-2 md:gap-3" data-feed-grid>
            @foreach ($posts as $post)
                <button type="button" class="ig-feed-tile group relative aspect-square overflow-hidden rounded bg-black/10"
                    data-feed-index="{{ $loop->index }}" aria-label="Open Instagram post">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] ?? 'Instagram post' }}"
                        loading="lazy" decoding="async"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">

                    <span
                        class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center gap-1.5 bg-black/55 opacity-0 transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100">
                        <span class="flex items-center gap-1 text-xs font-semibold text-white">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                            <span data-like-count>{{ $post['like_count'] ?? 0 }}</span>
                        </span>
                        <span class="flex items-center gap-1 text-xs font-semibold text-white">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-3 9H7V9h10v2zm0-3H7V6h10v2z" />
                            </svg>
                            <span data-comment-count>{{ $post['comments_count'] ?? 0 }}</span>
                        </span>
                    </span>
                </button>
            @endforeach
        </div>

        {{-- ================= LOAD MORE ================= --}}
        <div class="mt-6 flex justify-center" data-load-more-wrap hidden>
            <button type="button" data-load-more
                class="inline-flex items-center gap-2 rounded-full border border-black/30 px-6 py-2.5 font-condensed text-xs font-bold uppercase tracking-wider text-black transition hover:bg-black hover:text-white disabled:opacity-50">
                <span data-load-more-label>Load More Posts</span>
            </button>
        </div>

        {{-- ================= LIGHTBOX ================= --}}
        <div data-lightbox class="fixed inset-0 z-[80] flex items-center justify-center p-4" role="dialog" aria-modal="true"
            aria-label="Instagram post viewer" hidden>
            <div data-lightbox-backdrop class="absolute inset-0 bg-black/90"></div>

            <div data-lightbox-panel class="relative z-10 w-full max-w-4xl overflow-hidden rounded bg-black shadow-2xl">

                <button type="button" data-lightbox-close
                    class="absolute right-3 top-3 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-black/60 text-white transition hover:bg-black"
                    aria-label="Close gallery">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>

                <button type="button" data-lightbox-prev
                    class="absolute left-2 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/60 text-white transition hover:bg-black md:left-4"
                    aria-label="Previous post">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button" data-lightbox-next
                    class="absolute right-2 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/60 text-white transition hover:bg-black md:right-4"
                    aria-label="Next post">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center bg-black">
                        <img data-lightbox-image src="" alt="" class="max-h-[70vh] w-full object-contain">
                    </div>

                    <div class="flex flex-col bg-white p-5 text-gray-900">
                        <div class="mb-3 flex items-center justify-between gap-2">
                            <a data-lightbox-user href="#" target="_blank" rel="noopener noreferrer"
                                class="text-sm font-bold hover:underline"></a>
                            <a data-lightbox-permalink href="#" target="_blank" rel="noopener noreferrer"
                                class="text-xs font-semibold text-gray-500 hover:underline">Open post</a>
                        </div>

                        <p data-lightbox-caption class="whitespace-pre-line text-sm leading-relaxed text-gray-700"></p>

                        <div
                            class="mt-auto flex flex-wrap items-center gap-4 border-t border-gray-100 pt-4 text-xs text-gray-600">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                                <span data-lightbox-likes>0 likes</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                                </svg>
                                <span data-lightbox-comments>0 comments</span>
                            </span>
                        </div>

                        <p data-lightbox-date class="mt-2 text-[11px] text-gray-400"></p>
                    </div>
                </div>

                <div data-lightbox-dots class="flex items-center justify-center gap-1.5 bg-black/90 py-2"></div>
            </div>
        </div>
    </div>

    <style>
        .instagram-feed [data-lightbox][hidden] {
            display: none;
        }
    </style>
@else
    <div class="text-center text-sm text-white/70">
        <p>Instagram posts are unavailable right now.</p>
        <a href="{{ $instagramProfileUrl }}" target="_blank" rel="noopener noreferrer"
            class="mt-2 inline-block font-semibold underline hover:text-white">Follow us on Instagram</a>
    </div>
@endif

@once
    @push('scripts')
        <script>
            (function () {
                var HEART_ICON =
                    '<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';

                function formatNumber(value) {
                    var num = Number(value) || 0;
                    if (num >= 1000000) return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
                    if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
                    return String(num);
                }

                function buildTile(post, index) {
                    var button = document.createElement('button');
                    button.type = 'button';
                    button.className =
                        'ig-feed-tile group relative aspect-square overflow-hidden rounded bg-black/10';
                    button.setAttribute('data-feed-index', String(index));
                    button.setAttribute('aria-label', 'Open Instagram post');

                    // Instagram API doesn't provide direct video URLs for VIDEO type posts
                    // Use thumbnail/image for all types
                    var image = document.createElement('img');
                    image.src = post.image;
                    image.alt = post.title || 'Instagram post';
                    image.loading = 'lazy';
                    image.decoding = 'async';
                    image.className =
                        'h-full w-full object-cover transition-transform duration-500 group-hover:scale-110';
                    button.appendChild(image);

                    var overlay = document.createElement('span');
                    overlay.className =
                        'pointer-events-none absolute inset-0 flex flex-col items-center justify-center gap-1.5 bg-black/55 opacity-0 transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100';
                    overlay.innerHTML =
                        '<span class="flex items-center gap-1 text-xs font-semibold text-white">' +
                        HEART_ICON +
                        '<span>' +
                        formatNumber(post.like_count) +
                        '</span></span>' +
                        '<span class="flex items-center gap-1 text-xs font-semibold text-white">' +
                        '<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-3 9H7V9h10v2zm0-3H7V6h10v2z"/></svg>' +
                        '<span>' +
                        formatNumber(post.comments_count) +
                        '</span></span>';
                    button.appendChild(overlay);

                    return button;
                }

                function initFeed(root) {
                    if (root.dataset.igFeedReady === '1') return;
                    root.dataset.igFeedReady = '1';

                    var postsNode = root.querySelector('[data-feed-posts]');
                    var grid = root.querySelector('[data-feed-grid]');
                    var loadMoreWrap = root.querySelector('[data-load-more-wrap]');
                    var loadMoreButton = root.querySelector('[data-load-more]');
                    var loadMoreLabel = root.querySelector('[data-load-more-label]');
                    var lightbox = root.querySelector('[data-lightbox]');

                    if (!grid || !postsNode) return;

                    var posts = [];
                    try {
                        posts = JSON.parse(postsNode.textContent) || [];
                    } catch (error) {
                        console.error('Instagram feed: unable to parse posts', error);
                        return;
                    }

                    var nextCursor = root.dataset.nextCursor || null;
                    var loading = false;
                    var activeIndex = 0;
                    var lastFocused = null;
                    var profileUrl = root.dataset.profileUrl || '#';
                    var perPage = root.dataset.perPage || '6';

                    var lbImage = root.querySelector('[data-lightbox-image]');
                    var lbCaption = root.querySelector('[data-lightbox-caption]');
                    var lbUser = root.querySelector('[data-lightbox-user]');
                    var lbPermalink = root.querySelector('[data-lightbox-permalink]');
                    var lbLikes = root.querySelector('[data-lightbox-likes]');
                    var lbComments = root.querySelector('[data-lightbox-comments]');
                    var lbDate = root.querySelector('[data-lightbox-date]');
                    var lbDots = root.querySelector('[data-lightbox-dots]');

                    function renderDots() {
                        if (!lbDots) return;
                        lbDots.innerHTML = '';
                        if (posts.length < 2) return;

                        posts.forEach(function (post, index) {
                            var dot = document.createElement('button');
                            dot.type = 'button';
                            dot.className = 'h-1.5 rounded-full transition-all duration-300';
                            dot.className +=
                                index === activeIndex ? ' w-6 bg-white' : ' w-1.5 bg-white/40';
                            dot.setAttribute('aria-label', 'Go to post ' + (index + 1));
                            dot.addEventListener('click', function () {
                                goTo(index);
                            });
                            lbDots.appendChild(dot);
                        });
                    }

                    function render() {
                        if (!lightbox) return;

                        var post = posts[activeIndex];
                        if (!post) return;

                        // Instagram API doesn't provide direct video URLs for VIDEO type posts
                        // Use thumbnail/image for all types, link to Instagram for videos
                        lbImage.hidden = false;
                        lbImage.src = post.image || '';
                        lbImage.alt = post.title || 'Instagram post';

                        lbCaption.textContent = post.caption || post.excerpt || '';
                        lbUser.textContent = '@' + (post.username || '');
                        lbUser.href = profileUrl;
                        lbPermalink.href = post.permalink || '#';
                        lbLikes.textContent = formatNumber(post.like_count) + ' likes';
                        lbComments.textContent = formatNumber(post.comments_count) + ' comments';
                        lbDate.textContent = post.date || '';

                        renderDots();
                    }

                    function open(index) {
                        if (!lightbox) return;
                        lastFocused = document.activeElement;
                        activeIndex = index;
                        lightbox.hidden = false;
                        document.body.style.overflow = 'hidden';
                        render();
                        root.querySelector('[data-lightbox-close]')?.focus();
                    }

                    function close() {
                        if (!lightbox) return;
                        lightbox.hidden = true;
                        document.body.style.overflow = '';
                        if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
                    }

                    function goTo(index) {
                        if (posts.length === 0) return;
                        if (index < 0) index = posts.length - 1;
                        if (index >= posts.length) index = 0;
                        activeIndex = index;
                        render();
                    }

                    function hasMore() {
                        return Boolean(nextCursor);
                    }

                    function syncLoadMore() {
                        if (!loadMoreWrap) return;
                        loadMoreWrap.hidden = !hasMore();
                    }

                    function loadMore() {
                        if (loading || !nextCursor) return;

                        loading = true;
                        if (loadMoreButton) loadMoreButton.disabled = true;
                        if (loadMoreLabel) loadMoreLabel.textContent = 'Loading...';

                        var url = new URL(root.dataset.feedUrl, window.location.origin);
                        url.searchParams.set('limit', perPage);
                        url.searchParams.set('after', nextCursor);

                        fetch(url.toString(), { headers: { Accept: 'application/json' } })
                            .then(function (response) {
                                if (!response.ok) throw new Error('Request failed');
                                return response.json();
                            })
                            .then(function (data) {
                                var seen = {};
                                posts.forEach(function (post) {
                                    seen[post.id] = true;
                                });

                                (data.posts || []).forEach(function (post) {
                                    if (seen[post.id]) return;
                                    seen[post.id] = true;
                                    posts.push(post);
                                    grid.appendChild(buildTile(post, posts.length - 1));
                                });

                                nextCursor = data.next_cursor || null;
                                syncLoadMore();
                            })
                            .catch(function (error) {
                                console.error('Instagram feed: unable to load more posts', error);
                            })
                            .finally(function () {
                                loading = false;
                                if (loadMoreButton) loadMoreButton.disabled = false;
                                if (loadMoreLabel) loadMoreLabel.textContent = 'Load More Posts';
                            });
                    }

                    grid.addEventListener('click', function (event) {
                        var tile = event.target.closest('[data-feed-index]');
                        if (!tile) return;
                        open(Number(tile.getAttribute('data-feed-index')));
                    });

                    root.querySelector('[data-lightbox-close]')?.addEventListener('click', close);
                    root.querySelector('[data-lightbox-backdrop]')?.addEventListener('click', close);
                    root.querySelector('[data-lightbox-prev]')?.addEventListener('click', function () {
                        goTo(activeIndex - 1);
                    });
                    root.querySelector('[data-lightbox-next]')?.addEventListener('click', function () {
                        goTo(activeIndex + 1);
                    });
                    loadMoreButton?.addEventListener('click', loadMore);

                    document.addEventListener('keydown', function (event) {
                        if (lightbox.hidden) return;

                        if (event.key === 'Escape') close();
                        if (event.key === 'ArrowRight') goTo(activeIndex + 1);
                        if (event.key === 'ArrowLeft') goTo(activeIndex - 1);
                    });

                    syncLoadMore();
                }

                function initAll() {
                    document
                        .querySelectorAll('.instagram-feed[data-feed-url]')
                        .forEach(initFeed);
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initAll);
                } else {
                    initAll();
                }

                window.initInstagramFeeds = initAll;
            })();
        </script>
    @endpush
@endonce