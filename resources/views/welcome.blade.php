<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Higa Agribusiness Group IMS</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-white text-gray-900 antialiased">

<!-- HEADER -->
<header class="border-b bg-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('higalog.jpg') }}" class="h-9 w-9 rounded-xl object-cover">
            <span class="font-extrabold tracking-tight text-lg">
                HIGA Agribusiness Group<span class="text-[#2E7D32]">IMS</span>
            </span>
        </div>

        <!-- AUTH -->
        @auth
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-xl bg-[#2E7D32] text-white font-bold hover:opacity-90">
                    Dashboard
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 font-bold hover:bg-gray-50">
                    Profile
                </a>
            </div>
        @else
            <a href="{{ route('login') }}"
               class="px-4 py-2 rounded-xl bg-[#2E7D32] text-white font-bold hover:opacity-90">
                Sign in
            </a>
        @endauth

    </div>
</header>

<!-- HERO -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">

        <!-- LEFT -->
        <div>

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#D4A017]/40 bg-yellow-50 text-sm font-semibold text-[#8B5E3C]">
                <i class="fas fa-seedling text-[#4CAF50]"></i>
                IMS • Agribusiness Operations System
            </div>

            <!-- Title -->
            <h1 class="mt-6 text-5xl font-black leading-tight">
                Inventory Management System
                <span class="text-[#2E7D32]">for Agribusiness</span>
            </h1>

            <!-- Description -->
            <p class="mt-5 text-gray-600 text-lg max-w-xl">
                Manage maize collection, production, inventory, sales, and finance in one structured system designed for real operations.
            </p>

            <!-- CTA -->
            <div class="mt-8 flex flex-wrap gap-3">

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 rounded-xl bg-[#2E7D32] text-white font-bold hover:opacity-90">
                        <i class="fas fa-chart-line mr-2"></i>
                        Go to dashboard
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="px-6 py-3 rounded-xl border border-gray-200 font-bold hover:bg-gray-50">
                        <i class="fas fa-user mr-2"></i>
                        Profile
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-xl bg-[#2E7D32] text-white font-bold hover:opacity-90">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign in
                    </a>

                    <!-- VIEW DASHBOARD (restored properly) -->
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-xl border border-gray-200 font-bold hover:bg-gray-50">
                        <i class="fas fa-chart-line mr-2"></i>
                        View dashboard
                    </a>
                @endauth

            </div>

        </div>

        <!-- RIGHT (fix empty space) -->
        <div class="grid gap-4">

            <div class="p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <i class="fas fa-wheat-awn text-[#4CAF50] text-2xl"></i>
                <div>
                    <p class="font-bold">Collections</p>
                    <p class="text-sm text-gray-500">Quality intake tracking</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <i class="fas fa-industry text-[#F9A825] text-2xl"></i>
                <div>
                    <p class="font-bold">Production</p>
                    <p class="text-sm text-gray-500">Batch processing control</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <i class="fas fa-warehouse text-[#8B5E3C] text-2xl"></i>
                <div>
                    <p class="font-bold">Inventory</p>
                    <p class="text-sm text-gray-500">Real-time stock visibility</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <i class="fas fa-receipt text-[#2E7D32] text-2xl"></i>
                <div>
                    <p class="font-bold">Finance</p>
                    <p class="text-sm text-gray-500">Sales & payment tracking</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="border-t py-8 text-center text-sm text-gray-500">
    © 2026 Higa Agribusiness Group LTD IMS
</footer>

</body>
</html>