{{-- resources/views/cliente/pedidos/index.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Mis Pedidos</h1>
        <p class="text-gray-600">Aquí puedes ver todos tus pedidos y su estado actual</p>
    </div>

    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Estadísticas rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i data-lucide="shopping-bag" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Pedidos</p>
                    <p class="text-xl font-bold text-gray-800">{{ $pedidos->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-xl font-bold text-gray-800">{{ $pedidos->where('estado', 'pendiente')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Entregados</p>
                    <p class="text-xl font-bold text-gray-800">{{ $pedidos->where('estado', 'entregado')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i data-lucide="euro" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Gastado</p>
                    <p class="text-xl font-bold text-gray-800">€{{ number_format($pedidos->sum('total'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de pedidos --}}
    @if($pedidos->count() > 0)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            {{-- Header de la tabla --}}
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Historial de Pedidos</h2>
            </div>

            {{-- Tabla responsive --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pedido
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Productos
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Entrega
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pedidos as $pedido)
                            @php
                                $reseña = \App\Models\Resena::where('id_pedido', $pedido->id_pedido)
                                            ->where('id_cliente', auth()->id())
                                            ->first();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                {{-- Número de pedido --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ str_pad($pedido->id_pedido, 6, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $pedido->metodo_pago == 'tarjeta' ? 'Tarjeta' : 'Efectivo' }}
                                    </div>
                                </td>

                                {{-- Fecha --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $pedido->fecha_pedido->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $pedido->fecha_pedido->format('H:i') }}
                                    </div>
                                </td>

                                {{-- Productos --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $pedido->detalles->count() }} producto{{ $pedido->detalles->count() !== 1 ? 's' : '' }}
                                    </div>
                                    <div class="text-xs text-gray-500 max-w-xs truncate">
                                        @foreach($pedido->detalles->take(2) as $detalle)
                                            {{ $detalle->producto->nombre }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        @if($pedido->detalles->count() > 2)
                                            <span class="text-gray-400">...</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Total --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        €{{ number_format($pedido->total, 2) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $pedido->metodo_entrega == 'domicilio' ? 'A domicilio' : 'Recogida' }}
                                    </div>
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $estadoClases = [
                                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'confirmado' => 'bg-blue-100 text-blue-800',
                                            'entregado' => 'bg-green-100 text-green-800',
                                            'cancelado' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClases[$pedido->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>

                                {{-- Información de entrega --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pedido->fecha_entrega)
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') }}
                                        </div>
                                        @if($pedido->hora_entrega)
                                            <div class="text-xs text-gray-500">
                                                {{ $pedido->hora_entrega }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">Por confirmar</span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Botón ver detalle --}}
                                        <a href="{{ route('cliente.pedidos.show', $pedido->id_pedido) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"
                                           title="Ver detalles del pedido">
                                            <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                            Ver
                                        </a>
                                        
                                        {{-- NUEVO: Botón de reporte --}}
                                        <a href="{{ route('cliente.reportes.create', $pedido->id_pedido) }}" 
                                           class="inline-flex items-center justify-center w-10 h-10 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                           title="Reportar problema con este pedido">
                                            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                                        </a>
                                    </div>

                                    {{-- Indicador de reseña (TU LÓGICA ORIGINAL MEJORADA) --}}
                                    @if($pedido->estado === 'entregado')
                                        <div class="mt-2">
                                            @if($reseña)
                                                <div x-data="{ modalOpen: false, rating: {{ $reseña->rating }}, hoverRating: 0, comentario: '{{ $reseña->comentario }}' }">
                                                    <!-- Mostrar reseña existente con diseño mejorado -->
                                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-2">
                                                        <div class="flex items-center justify-between">
                                                            <div>
                                                                <div class="flex items-center space-x-1 mb-1">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i data-lucide="star" 
                                                                           class="w-4 h-4 {{ $i <= $reseña->rating ? 'text-yellow-500 fill-current' : 'text-gray-300' }}"></i>
                                                                    @endfor
                                                                    <span class="ml-2 text-sm font-medium text-yellow-700">{{ $reseña->rating }}/5</span>
                                                                </div>
                                                                @if($reseña->comentario)
                                                                    <p class="text-xs text-gray-600 max-w-xs truncate">
                                                                        "{{ $reseña->comentario }}"
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <button @click="modalOpen = true" 
                                                                    class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 transition-colors text-xs font-medium">
                                                                <i data-lucide="edit-2" class="w-3 h-3 mr-1"></i>
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Modal para editar reseña (TU LÓGICA ORIGINAL) -->
                                                    <div x-show="modalOpen" 
                                                         x-cloak
                                                         @click.away="modalOpen = false"
                                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                                                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Editar tu reseña</h3>
                                                                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                                                                    <i data-lucide="x" class="w-5 h-5"></i>
                                                                </button>
                                                            </div>
                                                            
                                                            <form action="{{ route('cliente.pedidos.reseña.update', $pedido->id_pedido) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                
                                                                {{-- Puntuación con hover effect --}}
                                                                <div class="mb-4">
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Puntuación</label>
                                                                    <div class="flex items-center space-x-1 p-3 bg-gray-50 rounded-lg" @mouseleave="hoverRating = 0">
                                                                        <template x-for="i in 5" :key="i">
                                                                            <button type="button"
                                                                                    class="focus:outline-none transform transition hover:scale-110 active:scale-125"
                                                                                    @mouseover="hoverRating = i"
                                                                                    @click="rating = i">
                                                                                <i data-lucide="star"
                                                                                   class="w-7 h-7 transition-colors duration-150"
                                                                                   :class="{
                                                                                     'text-yellow-500 fill-current': i <= (hoverRating || rating),
                                                                                     'text-gray-300': i > (hoverRating || rating)
                                                                                   }"></i>
                                                                            </button>
                                                                        </template>
                                                                        <span class="ml-3 text-sm font-medium text-gray-600" x-text="(hoverRating || rating) + '/5'"></span>
                                                                        <input type="hidden" name="rating" x-model="rating">
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- Comentario --}}
                                                                <div class="mb-6">
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                                                                    <textarea name="comentario"
                                                                              x-model="comentario"
                                                                              rows="4"
                                                                              class="w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"
                                                                              placeholder="Comparte tu experiencia con este pedido..."></textarea>
                                                                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                                                                </div>
                                                                
                                                                <div class="flex justify-end space-x-3">
                                                                    <button type="button" 
                                                                            @click="modalOpen = false"
                                                                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                                                        Cancelar
                                                                    </button>
                                                                    <button type="submit" 
                                                                            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors font-medium">
                                                                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                                                        Actualizar Reseña
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div x-data="{ modalOpen: false, rating: 0, hoverRating: 0, comentario: '' }">
                                                    <button @click="modalOpen = true" 
                                                            class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 text-sm font-medium shadow-sm">
                                                        <i data-lucide="star" class="w-4 h-4 mr-2"></i>
                                                        Escribir reseña
                                                    </button>

                                                    <!-- Modal para nueva reseña (MISMO DISEÑO ELEGANTE) -->
                                                    <div x-show="modalOpen" 
                                                         x-cloak
                                                         @click.away="modalOpen = false"
                                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                                                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Escribir reseña</h3>
                                                                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                                                                    <i data-lucide="x" class="w-5 h-5"></i>
                                                                </button>
                                                            </div>
                                                            
                                                            <form action="{{ route('cliente.pedidos.reseña.store', $pedido->id_pedido) }}" method="POST">
                                                                @csrf
                                                                
                                                                {{-- Puntuación con hover effect (MISMO DISEÑO ELEGANTE) --}}
                                                                <div class="mb-4">
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Puntuación</label>
                                                                    <div class="flex items-center space-x-1 p-3 bg-gray-50 rounded-lg" @mouseleave="hoverRating = 0">
                                                                        <template x-for="i in 5" :key="i">
                                                                            <button type="button"
                                                                                    class="focus:outline-none transform transition hover:scale-110 active:scale-125"
                                                                                    @mouseover="hoverRating = i"
                                                                                    @click="rating = i">
                                                                                <i data-lucide="star"
                                                                                   class="w-7 h-7 transition-colors duration-150"
                                                                                   :class="{
                                                                                     'text-yellow-500 fill-current': i <= (hoverRating || rating),
                                                                                     'text-gray-300': i > (hoverRating || rating)
                                                                                   }"></i>
                                                                            </button>
                                                                        </template>
                                                                        <span class="ml-3 text-sm font-medium text-gray-600" x-text="(hoverRating || rating) + '/5'"></span>
                                                                        <input type="hidden" name="rating" x-model="rating">
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- Comentario (MISMO DISEÑO ELEGANTE) --}}
                                                                <div class="mb-6">
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                                                                    <textarea name="comentario"
                                                                              x-model="comentario"
                                                                              rows="4"
                                                                              class="w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                                                              placeholder="Comparte tu experiencia con este pedido..."></textarea>
                                                                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                                                                </div>
                                                                
                                                                <div class="flex justify-end space-x-3">
                                                                    <button type="button" 
                                                                            @click="modalOpen = false"
                                                                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                                                        Cancelar
                                                                    </button>
                                                                    <button type="submit" 
                                                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                                                        <i data-lucide="send" class="w-4 h-4 inline mr-2"></i>
                                                                        Enviar Reseña
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($pedidos->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $pedidos->links() }}
                </div>
            @endif
        </div>
    @else
        {{-- Estado vacío --}}
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="shopping-bag" class="w-12 h-12 text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes pedidos aún</h3>
            <p class="text-gray-600 mb-6">
                Explora nuestro catálogo y realiza tu primer pedido de productos frescos locales.
            </p>
            <a href="{{ route('cliente.catalogo') }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i>
                Ir al Catálogo
            </a>
        </div>
    @endif
</div>


<script>
// Solo funciones para inicializar iconos
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection