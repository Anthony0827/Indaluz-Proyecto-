{{-- resources/views/layouts/cliente.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indaluz - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo-indaluz.png') }}" type="image/png" sizes="64x64">

    <!-- Alpine.js para interactividad -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header x-data="{ open: false, userMenu: false, cartOpen: false }" class="bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('cliente.home') }}" class="flex items-center">
                        <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-10 w-auto">
                        <span class="ml-2 text-xl font-bold text-green-700">Indaluz</span>
                    </a>
                </div>

                <!-- Barra de búsqueda (desktop) -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <form action="{{ route('cliente.home') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="buscar" 
                                   value="{{ request('buscar') }}"
                                   placeholder="Buscar productos frescos..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            <i data-lucide="search" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
                        </div>
                    </form>
                </div>

                <!-- Menú derecha -->
                {{-- Parte del header que debes reemplazar en cliente.blade.php --}}

                    <!-- Menú derecha -->
                    <div class="flex items-center space-x-4">
                        <!-- Carrito - Solo botón sin dropdown -->
                        <div class="relative">
                            <a href="{{ route('cliente.carrito') }}" class="relative p-2 text-gray-600 hover:text-green-600 transition flex items-center space-x-2">
                                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                                <span class="absolute -top-1 -right-1 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center cart-count">
                                    0
                                </span>
                                <span class="hidden sm:inline text-sm font-medium"></span>
                            </a>
                        </div>

                        <!-- Perfil del usuario -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-green-600 transition">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <span class="hidden sm:inline font-medium">{{ Auth::user()->nombre }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </button>

                            <!-- Dropdown del perfil -->
                            <div x-show="open" 
                                x-cloak
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('cliente.perfil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                                    Mi perfil
                                </a>
                                <a href="{{ route('cliente.pedidos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i data-lucide="package" class="w-4 h-4 inline mr-2"></i>
                                    Mis pedidos
                                </a>
                                <div class="border-t my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Barra de búsqueda móvil -->
            <div class="md:hidden py-2">
                <form action="{{ route('cliente.home') }}" method="GET">
                    <div class="relative">
                        <input type="text" 
                               name="buscar" 
                               value="{{ request('buscar') }}"
                               placeholder="Buscar productos..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menú móvil -->
        <div x-show="open" x-cloak class="md:hidden bg-white border-t">
            <nav class="px-4 py-2">
                <a href="{{ route('cliente.home') }}" class="block py-2 text-gray-700 hover:text-green-600">Inicio</a>
                <a href="{{ route('cliente.perfil') }}" class="block py-2 text-gray-700 hover:text-green-600">Mi Perfil</a>
                    <a href="{{ route('cliente.pedidos') }}" class="block py-2 text-gray-700 hover:text-green-600">
                                Mis Pedidos
                            </a>                <a href="{{ route('cliente.direcciones') }}" class="block py-2 text-gray-700 hover:text-green-600">Direcciones</a>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="min-h-screen">
        {{-- Mensajes de éxito/error --}}
        @if(session('success'))
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 rounded p-4">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 rounded p-4">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-800 text-white mt-12">
        
            
            <div class="mt-8 pt-8 border-t border-green-700 text-center text-sm text-green-100">
                © {{ date('Y') }} Indaluz. Todos los derechos reservados.
            </div><br>
        
    </footer>

    <!-- Scripts -->
    <script>
        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        // Re-inicializar iconos después de cambios en el DOM
        document.addEventListener('alpine:init', () => {
            Alpine.data('reinitIcons', () => ({
                init() {
                    this.$nextTick(() => {
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    });
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>