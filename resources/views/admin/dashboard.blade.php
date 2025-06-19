{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>
                <p class="text-gray-600 mt-1">Gestión de reportes y moderación de contenido</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    Último acceso: {{ now()->format('d/m/Y H:i') }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i data-lucide="flag" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Reportes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['total_reportes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['reportes_pendientes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Resueltos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['reportes_resueltos'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <i data-lucide="user-x" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Usuarios Bloqueados</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['usuarios_bloqueados'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de reportes pendientes --}}
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Reportes Pendientes</h2>
            <p class="text-gray-600 mt-1">Casos que requieren revisión inmediata</p>
        </div>

        <div class="overflow-x-auto">
            @if($reportesPendientes->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Caso
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reportado por
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Producto
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Motivo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reportesPendientes as $reporte)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ $reporte->id_reporte }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Pedido #{{ $reporte->id_pedido }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i data-lucide="user" class="w-4 h-4 text-gray-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reporte->usuarioReporta->nombre }} {{ $reporte->usuarioReporta->apellido }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ ucfirst($reporte->tipo_usuario) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reporte->producto->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $reporte->producto->agricultor->nombre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reporte->razon }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ 
                                        is_string($reporte->fecha_reporte) 
                                        ? \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y H:i')
                                        : $reporte->fecha_reporte->format('d/m/Y H:i') 
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                               {{ $reporte->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                  ($reporte->estado === 'en_revision' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $reporte->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.reporte.review', $reporte->token_acceso) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                        Revisar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center">
                    <i data-lucide="check-circle" class="w-16 h-16 text-green-500 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reportes pendientes</h3>
                    <p class="text-gray-600">Todos los reportes han sido procesados correctamente.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection