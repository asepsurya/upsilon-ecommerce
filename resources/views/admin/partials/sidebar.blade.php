<aside class="admin-sidebar" id="sidebar">
    <div class="admin-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
            <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name', 'Upsilon') }}"
                class="h-7 w-auto">
        </a>
    </div>
    <nav class="admin-sidebar-nav">
        <div class="admin-sidebar-nav-group">
            <div class="admin-sidebar-nav-group-title">Main</div>
            <a href="{{ route('admin.dashboard') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">dashboard</span>
                Dashboard
            </a>
        </div>
        <div class="admin-sidebar-nav-group">
            <div class="admin-sidebar-nav-group-title">Management</div>
            <a href="{{ route('admin.products.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">inventory_2</span>
                Products
            </a>
            <a href="{{ route('admin.bundles.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.bundles*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">inventory_2</span>
                Bundles
            </a>
            <a href="{{ route('admin.orders.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">shopping_bag</span>
                Orders
            </a>
            <a href="{{ route('admin.customers.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">people</span>
                Customers
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">category</span>
                Categories
            </a>
            <a href="{{ route('admin.vouchers.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.vouchers*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">local_offer</span>
                Vouchers
            </a>
            <a href="{{ route('admin.reviews.index') }}"
                class="admin-sidebar-nav-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <span class="nav-icon material-symbols-outlined text-lg">star</span>
                Reviews
            </a>

        </div>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebar-toggle');
        let isOpen = true;

        if (toggle && sidebar) {
            toggle.addEventListener('click', function () {
                isOpen = !isOpen;
                if (isOpen) {
                    sidebar.style.transform = 'translateX(0)';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                }
            });
        }
    });
</script>