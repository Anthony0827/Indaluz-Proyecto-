<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indaluz - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo-indaluz.png') }}" type="image/png" sizes="64x64">

    <!-- Iconos Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js (para el menú móvil) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
<header x-data="{ open: false, userMenu: false }" class="relative z-50 bg-green-600 text-white shadow">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-14 w-auto">
            <span class="hidden sm:inline text-2xl font-bold">Indaluz</span>
        </a>

        <!-- Navegación escritorio -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" class="hover:text-green-200 {{ request()->routeIs('home') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Inicio</a>
            <a href="{{ route('productos.catalogo') }}" class="hover:text-green-200 {{ request()->routeIs('productos.catalogo') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Productos</a>
            <a href="{{ route('nosotros') }}" class="hover:text-green-200 {{ request()->routeIs('nosotros') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Nosotros</a>
            <a href="{{ route('sostenibilidad') }}" class="hover:text-green-200 {{ request()->routeIs('sostenibilidad') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Sostenibilidad</a>
            <a href="{{ route('agricultores') }}" class="hover:text-green-200 {{ request()->routeIs('agricultores') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Agricultores</a>
            <a href="{{ route('contacto') }}" class="hover:text-green-200 {{ request()->routeIs('contacto') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Contacto</a>

            <!-- Usuario con dropdown -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="p-2 hover:text-green-200">
                    <i data-lucide="user"></i>
                </button>
                <div x-show="userMenu" x-cloak
                     class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-lg py-2 z-50">
                    <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-green-50">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-green-50">Register</a>
                </div>
            </div>
        </nav>

        <!-- CORREGIDO: Usuario + hamburguesa móvil (SIN búsqueda ni carrito) -->
        <div class="flex md:hidden items-center space-x-4">
            <!-- Usuario móvil -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="p-2 hover:text-green-200">
                    <i data-lucide="user"></i>
                </button>
                <div x-show="userMenu" x-cloak
                     class="absolute top-full right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-lg py-2 z-50">
                    <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-green-50">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-green-50">Register</a>
                </div>
            </div>

            <!-- Botón hamburguesa -->
            <button @click="open = !open" class="p-2 hover:text-green-200">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>

    <!-- Menú móvil desplegable -->
    <div x-show="open" x-cloak @click.away="open = false"
         class="md:hidden bg-green-600 text-white z-40">
        <nav class="flex flex-col space-y-2 p-4">
            <a href="{{ route('home') }}" class="hover:text-green-200 {{ request()->routeIs('home') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Inicio</a>
            <a href="{{ route('productos.catalogo') }}" class="hover:text-green-200 {{ request()->routeIs('productos.catalogo') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Productos</a>
            <a href="{{ route('nosotros') }}" class="hover:text-green-200 {{ request()->routeIs('nosotros') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Nosotros</a>
            <a href="{{ route('sostenibilidad') }}" class="hover:text-green-200 {{ request()->routeIs('sostenibilidad') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Sostenibilidad</a>
            <a href="{{ route('agricultores') }}" class="hover:text-green-200 {{ request()->routeIs('agricultores') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Agricultores</a>
            <a href="{{ route('contacto') }}" class="hover:text-green-200 {{ request()->routeIs('contacto') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Contacto</a>
        </nav>
    </div>
</header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo y descripción -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-12 w-auto">
                        <span class="text-2xl font-bold">Indaluz</span>
                    </div>
                    <p class="text-green-100 leading-relaxed">
                        Conectamos agricultores locales de Almería con consumidores que valoran 
                        la frescura, calidad y sostenibilidad. Productos del campo directo a tu mesa.
                    </p>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-green-100">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="{{ route('productos.catalogo') }}" class="hover:text-white transition">Productos</a></li>
                        <li><a href="{{ route('nosotros') }}" class="hover:text-white transition">Nosotros</a></li>
                        <li><a href="{{ route('contacto') }}" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-green-100">
                        <li><a href="#" class="hover:text-white transition">Política de Privacidad</a></li>
                        <li><a href="#" class="hover:text-white transition">Términos y Condiciones</a></li>
                        <li><a href="#" class="hover:text-white transition">Política de Cookies</a></li>
                        <li><a href="#" class="hover:text-white transition">Aviso Legal</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-green-700 text-center text-sm text-green-100">
                © {{ date('Y') }} Indaluz. Todos los derechos reservados.
            </div>
        </div>
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