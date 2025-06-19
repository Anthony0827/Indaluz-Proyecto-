{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
{{-- Mensajes de sesión --}}
@if(session('success'))
    <div class="max-w-md mx-auto mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-md mx-auto mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    {{-- Header con icono --}}
    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="key" class="w-8 h-8 text-green-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-green-700 mb-2">Recuperar Contraseña</h2>
        <p class="text-gray-600 text-sm">
            Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    required
                    autofocus
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('correo') border-red-500 @enderror"
                    placeholder="ejemplo@correo.com"
                >
            </div>
            @error('correo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors"
        >
            <i data-lucide="send" class="w-5 h-5 inline mr-2"></i>
            Enviar Enlace de Recuperación
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-green-600 hover:underline flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                Volver al Login
            </a>
        </div>
    </form>

    {{-- Información adicional --}}
    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
        <div class="flex items-start">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0"></i>
            <div class="text-sm">
                <p class="text-blue-800 font-medium mb-1">¿Cómo funciona?</p>
                <ul class="text-blue-600 space-y-1 text-xs">
                    <li>• Introduce tu correo electrónico registrado</li>
                    <li>• Recibirás un enlace seguro en tu email</li>
                    <li>• Haz clic en el enlace para cambiar tu contraseña</li>
                    <li>• El enlace expira en 60 minutos por seguridad</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Ayuda adicional --}}
    <div class="mt-6 text-center text-sm text-gray-600">
        <p class="mb-2">¿No recibes el correo?</p>
        <div class="space-y-1">
            <p>• Revisa tu carpeta de spam</p>
            <p>• Verifica que el correo esté bien escrito</p>
            <p>• <a href="{{ route('contacto') }}" class="text-green-600 hover:underline">Contacta con soporte</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection