{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Indaluz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
            {{-- Logo y título --}}
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Panel de Administración</h1>
                <p class="text-gray-600">Indaluz - Acceso Restringido</p>
            </div>

            {{-- Mensajes de éxito/error --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Formulario de login --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf

                {{-- Token de reporte (si viene de un enlace) --}}
                @if(request('token'))
                    <input type="hidden" name="token" value="{{ request('token') }}">
                @endif

                {{-- Email --}}
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="email" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo') }}"
                               required
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="admin@indaluz.com">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="••••••••">
                    </div>
                </div>

                {{-- Botón de login --}}
                <button type="submit" 
                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                    <i data-lucide="log-in" class="w-5 h-5 mr-2"></i>
                    Acceder al Panel
                </button>
            </form>

            {{-- Información de seguridad --}}
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-start space-x-3">
                    <i data-lucide="shield" class="w-5 h-5 text-gray-500 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="text-sm font-medium text-gray-800 mb-1">Área Restringida</h3>
                        <p class="text-xs text-gray-600">
                            Este panel está destinado únicamente para administradores autorizados. 
                            Todos los accesos quedan registrados por seguridad.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Link de regreso --}}
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" 
                   class="text-sm text-green-600 hover:text-green-700 flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                    Volver a Indaluz
                </a>
            </div>
        </div>
    </div>

    <script>
        // Inicializar iconos de Lucide
        lucide.createIcons();
    </script>
</body>
</html>