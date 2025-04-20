<header class="bg-white shadow-sm">
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center">
            <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-600 lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div class="flex items-center">
            <div class="relative">
                <button class="flex items-center text-gray-700 hover:text-gray-900">
                    <span class="mr-2"><?= htmlspecialchars($_SESSION['admin_name']) ?></span>
                    <span class="text-sm bg-gray-100 text-gray-800 py-1 px-2 rounded">
                        <?= ucfirst($_SESSION['admin_role']) ?>
                    </span>
                </button>
            </div>
        </div>
    </div>
</header>