@php
$menuItems = [
    ['route' => 'dashboard', 'icon' => 'fas fa-chart-line', 'label' => 'Dashboard', 'roles' => [1,2]],
    ['route' => 'inventory', 'icon' => 'fas fa-boxes', 'label' => 'Inventory', 'roles' => [1, 2, 3]],
    ['route' => 'supplier', 'icon' => 'fas fa-truck', 'label' => 'Supplier', 'roles' => [1, 2, 3]],
    ['route' => 'material', 'icon' => 'fas fa-box', 'label' => 'Material', 'roles' => [1, 2, 3 ]],
    ['route' => 'order', 'icon' => 'fas fa-shopping-cart', 'label' => 'Purchase', 'roles' => [1, 2, 3 ]],
    ['route' => 'pos', 'icon' => 'fas fa-cash-register', 'label' => 'POS', 'roles' => [1, 2, 4]],
    ['route' => 'sale_detail', 'icon' => 'fas fa-receipt', 'label' => 'Sale Detail', 'roles' => [1, 2, 4]],
    ['route' => 'menu', 'icon' => 'fas fa-utensils', 'label' => 'Menu', 'roles' => [1, 2, 4]],
    ['route' => 'employee', 'icon' => 'fas fa-users', 'label' => 'Employee', 'roles' => [1, 2]],
    ['route' => 'report.index', 'icon' => 'fas fa-file-alt', 'label' => 'Report', 'roles' => [1, 2]],
    ['route' => 'expense', 'icon' => 'fas fa-file-invoice-dollar', 'label' => 'Expense', 'roles' => [1, 2]],
    ['route' => 'profit_lose', 'icon' => 'fas fa-calculator', 'label' => 'Profit / Lose', 'roles' => [1,2]],
    ['route' => 'setting', 'icon' => 'fas fa-cog', 'label' => 'Setting', 'roles' => [1,2]],
];
$user = Auth::user();
$modules = $user->InvRole->modules ?? collect();

$modulesData = $modules->map(function ($module) {
    return $module->only(['status', 'SM_id']); 
});
$modulesWithSysModule = $modules->map(function ($module) {
    return $module->SysModule->only(['SM_label', 'SM_id', 'status']);
});
$modulesDataWithLabel = $modulesData->map(function ($module, $index) use ($modulesWithSysModule) {
    $module['SM_label'] = isset($modulesWithSysModule[$index]['SM_label']) 
        ? strtolower($modulesWithSysModule[$index]['SM_label']) 
        : null; 
    return $module;
});
$activeModules = $modulesDataWithLabel->filter(function ($module) {
    return $module['status'] == 1;
});

$currentRoute = Route::currentRouteName();
@endphp
@php
    $userRoleItems = array_filter($menuItems, function($item) {
        return in_array(Auth::user()->InvRole->R_id, $item['roles']);
    });
    $dashboardModule = $modulesDataWithLabel->firstWhere('SM_label', 'dashboard');
    $settingModule = $modulesDataWithLabel->firstWhere('SM_label', 'setting');
    $allowedMenuItems = collect($menuItems)->filter(function ($item) use ($user, $activeModules) {
        return in_array($user->InvRole->R_id, $item['roles']) || $activeModules->contains('SM_label', strtolower($item['label']));
    });
    $countAllowed = $allowedMenuItems->count();
    $gridClass = match (true) {
        $countAllowed === 1 => 'grid grid-cols-1',
        $countAllowed === 2 => 'grid grid-cols-2',
        $countAllowed === 3 => 'grid grid-cols-3',
        default => 'grid grid-cols-4', 
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your meta tags and other head content here -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="min-h-screen bg-background text-foreground flex flex-col">
    <header class="flex flex-row items-center space-x-4 mt-2">
        <div class="ml-5">
            @if(Auth::check() && Auth::user()->invshop && Auth::user()->invshop->S_logo)
                <img src="{{ asset('storage/' . Auth::user()->invshop->S_logo) }}" alt="Shop Logo" class="h-10 w-12 rounded">
            @else
                <img src="{{ asset('images/official_logo.png') }}" alt="Default Logo" class="h-10 w-12 rounded">
            @endif
        </div>
        <div class="bg-primary p-3 shadow-md flex items-end justify-end flex-1">
            <div class="space-x-2 items-end justify-end">
                <h1 class="text-sm font-bold text-primary-foreground">{{ Auth::user()->sys_name }}</h1>
            </div>
        </div>
        <div class="relative">
            <img src="{{ Auth::user()->U_photo ? asset('storage/' . Auth::user()->U_photo) : asset('images/user.jpg') }}" 
            alt="Admin Profile" 
            class="h-10 w-10 rounded-full mr-5 cursor-pointer" 
            id="profileDropdownToggle">
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border-2 border-bsicolor z-10">
                <div class="py-1">
                    @if ( $dashboardModule['status'] == '1')
                    <a href="dashboard" class="block px-4 py-2 text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900">DASHBOARD</a>
                    @endif
                    <a href="#" class="block px-5 py-3 text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900" id="editProfile">PROFILE</a>
                    @if ( $settingModule['status'] == '1')
                    <a href="setting" class="block px-4 py-2 text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 border-b-2 border-bsicolor">SETTING</a>
                    @endif
                    <a class="block px-4 py-2 text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('LOG OUT') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        @include('popups.edit-profile-popup')
    </header>
    <!-- Main content section -->
    <main class="flex-grow flex items-center justify-center">
        <div class="p-6 w-4/5 mx-auto">
            <div class="{{ $gridClass }} gap-8">
                @foreach($allowedMenuItems as $item)
                    <a href="{{ $item['route'] }}" class="flex flex-col items-center">
                        <div class="h-20 w-20 sm:h-24 sm:w-24 border-4 border-bsicolor rounded-md flex items-center justify-center">
                            <i class="{{ $item['icon'] }} text-4xl sm:text-6xl text-primary"></i>
                        </div>
                        <span class="mt-0 text-lg text-muted-foreground text-center">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
    @include('layouts.footer')
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileDropdownToggle.addEventListener('click', function () {
        profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        if (!profileDropdownToggle.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
});
</script>
</body>
</html>
<style>
    .custom-grid {
        margin-left: 8%;
        width: 80%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        justify-items: center;
        align-items: center;
    }

    .custom-grid > div:nth-child(4) {
        grid-column: 2 / 3;
        margin-left: -110%;
    }

    .custom-grid > div:nth-child(5) {
        grid-column: 3 / 4;
        margin-left: -110%;
    }
</style>
