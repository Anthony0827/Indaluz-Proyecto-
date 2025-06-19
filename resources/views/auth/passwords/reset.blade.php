{{-- resources/views/auth/passwords/reset.blade.php --}}
@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
{{-- Mensajes de sesión --}}
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
            <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-green-700 mb-2">Nueva Contraseña</h2>
        <p class="text-gray-600 text-sm">
            Introduce tu nueva contraseña para completar el proceso de recuperación.
        </p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email (readonly) --}}
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
                    value="{{ $email ?? old('correo') }}"
                    required
                    readonly
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                >
            </div>
        </div>

        {{-- Nueva contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Nueva Contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="Mínimo 8 caracteres"
                >
            </div>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Confirmar Nueva Contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Confirma tu nueva contraseña"
                >
            </div>
        </div>

        {{-- Requisitos de contraseña --}}
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-gray-700 mb-2">Requisitos de la contraseña:</p>
            <ul class="text-xs text-gray-600 space-y-1">
                <li class="flex items-center">
                    <i data-lucide="check" class="w-3 h-3 text-green-500 mr-2"></i>
                    Mínimo 8 caracteres
                </li>
                <li class="flex items-center">
                    <i data-lucide="check" class="w-3 h-3 text-green-500 mr-2"></i>
                    Se recomienda incluir números y símbolos
                </li>
                <li class="flex items-center">
                    <i data-lucide="check" class="w-3 h-3 text-green-500 mr-2"></i>
                    Evita contraseñas muy comunes
                </li>
            </ul>
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors"
        >
            <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
            Cambiar Contraseña
        </button>
    </form>

    {{-- Información de seguridad --}}
    <div class="mt-8 p-4 bg-yellow-50 rounded-lg">
        <div class="flex items-start">
            <i data-lucide="shield" class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0"></i>
            <div class="text-sm">
                <p class="text-yellow-800 font-medium mb-1">Consejos de Seguridad</p>
                <ul class="text-yellow-600 space-y-1 text-xs">
                    <li>• Usa una contraseña única para Indaluz</li>
                    <li>• No compartas tu contraseña con nadie</li>
                    <li>• Cierra sesión en dispositivos públicos</li>
                    <li>• Cambia tu contraseña regularmente</li>
                </ul>
            </div>
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