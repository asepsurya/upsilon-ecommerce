<nav class="space-y-1">
    <a href="{{ route('account.dashboard') }}"
        class="block px-4 py-3 text-sm {{ request()->routeIs('account.dashboard') ? 'bg-surface-container-lowest text-on-surface tracking-wider' : 'hover:bg-surface-container-high transition-colors' }}">Dashboard</a>
    <a href="{{ route('account.orders') }}"
        class="block px-4 py-3 text-sm {{ request()->routeIs('account.orders*') ? 'bg-surface-container-lowest text-on-surface tracking-wider' : 'hover:bg-surface-container-high transition-colors' }}">Orders</a>
    <a href="{{ route('account.profile') }}"
        class="block px-4 py-3 text-sm {{ request()->routeIs('account.profile') ? 'bg-surface-container-lowest text-on-surface tracking-wider' : 'hover:bg-surface-container-high transition-colors' }}">Profile</a>
    <a href="{{ route('account.addresses') }}"
        class="block px-4 py-3 text-sm {{ request()->routeIs('account.addresses*') ? 'bg-surface-container-lowest text-on-surface tracking-wider' : 'hover:bg-surface-container-high transition-colors' }}">Addresses</a>
    <a href="{{ route('wishlist') }}"
        class="block px-4 py-3 text-sm hover:bg-surface-container-high transition-colors">Wishlist</a>
</nav>