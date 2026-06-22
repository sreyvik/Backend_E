<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - ShopHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col">
            <div class="p-5 border-b border-indigo-800">
                <h1 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-store"></i>
                    ShopHub Admin
                </h1>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition-colors {{ request()->is('admin/dashboard') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    <span>Dashboard</span>
                </a>

                <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition-colors {{ request()->is('admin/categories*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span>Categories</span>
                </a>

                <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition-colors {{ request()->is('admin/products*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span>Products</span>
                </a>

                <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition-colors {{ request()->is('admin/orders*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>Orders</span>
                </a>

                <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition-colors {{ request()->is('admin/users*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Users</span>
                </a>
            </nav>

            <div class="p-4 border-t border-indigo-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-300">Admin</p>
                    </div>
                </div>
                <a href="/admin/logout" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-red-300 hover:text-white">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i>
                            {{ now()->format('M d, Y h:i A') }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4 rounded shadow-sm flex items-center justify-between" id="flash-success">
                    <span>{{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded shadow-sm flex items-center justify-between" id="flash-error">
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-error').remove()" class="text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
