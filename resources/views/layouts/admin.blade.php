{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') - Indaluz</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    {{-- Alpine.js para interactividad --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Configuración de Tailwind --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false }">
    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
             :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            
            {{-- Logo --}}
            <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-white font-bold text-lg">Indaluz Admin</span>
                </div>
            </div>

            {{-- Navegación --}}
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                        <i data-lucide="home" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Información del Sistema
                        </h3>
                    </div>
                    
                    <div class="px-4 py-2 text-gray-400 text-sm">
                        <div class="flex items-center space-x-2 mb-1">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ Auth::user()->nombre }}</span>
                        </div>
                        <div class="flex items-center space-x-2 mb-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ now()->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>{{ now()->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Botón de cierre en móvil --}}
            <div class="lg:hidden absolute top-4 right-4">
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        {{-- Overlay para móvil --}}
        <div class="lg:hidden fixed inset-0 z-40 bg-black bg-opacity-50" 
             x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-cloak></div>

        {{-- Contenido principal --}}
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            {{-- Header móvil --}}
            <div class="lg:hidden bg-white shadow-sm border-b border-gray-200 px-4 py-3">
                <div class="flex items-center justify-between">
                    <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">
                        @yield('title', 'Administración')
                    </h1>
                    <div class="w-6"></div> {{-- Espaciador --}}
                </div>
            </div>

            {{-- Contenido --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Inicializar iconos de Lucide
        lucide.createIcons();
        
        // Auto-ocultar mensajes después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[x-data*="show: true"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>
</html>