<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        @media (max-width: 767px) {
            .sidebar-open .sidebar-overlay {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Mobile Nav -->
    <nav class="bg-gray-800 p-4 md:hidden flex justify-between items-center">
        <button class="text-white focus:outline-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="text-white text-xl font-semibold">Admin Dashboard</div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-gray-900 text-white w-72 space-y-8 py-7 px-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-50">
        <!-- Profile Section -->
        <div class="px-4 mb-8">
            <div class="flex items-center space-x-4">
                <div class="h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold">Admin User</p>
                    <p class="text-sm text-gray-400">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-tachometer-alt text-xl w-6 text-center"></i>
                <span class="text-lg">Dashboard</span>
            </a>
            <a href="{{ route('customers.index') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('customers.index') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-users text-xl w-6 text-center"></i>
                <span class="text-lg">Customers</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('products.index') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-boxes text-xl w-6 text-center"></i>
                <span class="text-lg">Products</span>
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('orders.index') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-list text-xl w-6 text-center"></i>
                <span class="text-lg">Orders</span>
            </a>
            <a href="{{ route('invoices.index') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('invoices.index') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-file-invoice-dollar text-xl w-6 text-center"></i>
                <span class="text-lg">Invoices</span>
            </a>
            <a href="{{ route('receipts.index') }}" class="flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('receipts.index') ? 'bg-blue-600' : '' }}">
                <i class="fas fa-receipt text-xl w-6 text-center"></i>
                <span class="text-lg">Receipts</span>
            </a>
            <div class="border-t border-gray-700 my-4"></div>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-4 px-4 py-3 rounded-lg hover:bg-gray-700 text-left">
                    <i class="fas fa-sign-out-alt text-xl w-6 text-center"></i>
                    <span class="text-lg">Logout</span>
                </button>
            </form>
        </nav>

        <!-- Copyright -->
        <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} InvoicerPro
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="md:ml-72 p-4 md:p-6 min-h-screen">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            sidebar.classList.toggle('-translate-x-full');
            body.classList.toggle('sidebar-open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            if (window.innerWidth <= 767 &&
                !sidebar.contains(event.target) &&
                !event.target.closest('nav')) {
                sidebar.classList.add('-translate-x-full');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Close sidebar on ESC key press
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && window.innerWidth <= 767) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.body.classList.remove('sidebar-open');
            }
        });
    </script>
</body>
</html>
