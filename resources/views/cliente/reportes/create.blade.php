{{-- resources/views/cliente/reportes/create.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Reportar Problema')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('cliente.pedidos.show', $pedido->id_pedido) }}" 
               class="text-green-600 hover:text-green-700">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Reportar Problema</h1>
        </div>
        <p class="text-gray-600">
            Pedido #{{ $pedido->id_pedido }} - {{ $pedido->fecha_pedido->format('d/m/Y') }}
        </p>
    </div>

    {{-- Formulario de reporte --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('cliente.reportes.store', $pedido->id_pedido) }}" method="POST">
            @csrf

            {{-- Selección de producto --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Producto a reportar *
                </label>
                <select name="id_producto" id="id_producto" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Selecciona un producto</option>
                    @foreach($pedido->detalles as $detalle)
                        <option value="{{ $detalle->producto->id_producto }}">
                            {{ $detalle->producto->nombre }} - 
                            {{ $detalle->cantidad }} {{ $detalle->producto->unidad_medida }}
                            ({{ $detalle->producto->agricultor->nombre }} {{ $detalle->producto->agricultor->apellido }})
                        </option>
                    @endforeach
                </select>
                @error('id_producto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Razón del reporte --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Motivo del reporte *
                </label>
                <select name="razon" id="razon" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Selecciona un motivo</option>
                    <option value="Producto en mal estado">Producto en mal estado</option>
                    <option value="Producto diferente al pedido">Producto diferente al pedido</option>
                    <option value="Cantidad incorrecta">Cantidad incorrecta</option>
                    <option value="Problema con el agricultor">Problema con el agricultor</option>
                    <option value="Reseña falsa o inapropiada">Reseña falsa o inapropiada</option>
                    <option value="Otro">Otro</option>
                </select>
                @error('razon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción detallada *
                </label>
                <textarea name="descripcion" id="descripcion" rows="5" required
                          placeholder="Describe detalladamente el problema que has experimentado..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
                <p class="text-gray-500 text-sm mt-1">Máximo 500 caracteres</p>
                @error('descripcion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Información importante --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <i data-lucide="info" class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="font-medium text-yellow-800 mb-1">Información importante</h3>
                        <ul class="text-yellow-700 text-sm space-y-1">
                            <li>• Tu reporte será enviado al equipo de administración de Indaluz</li>
                            <li>• Un administrador revisará tu caso y tomará las medidas necesarias</li>
                            <li>• Este proceso es confidencial y seguro</li>
                            <li>• No recibirás notificaciones adicionales sobre el estado del reporte</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('cliente.pedidos.show', $pedido->id_pedido) }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i data-lucide="flag" class="w-4 h-4 inline mr-2"></i>
                    Enviar Reporte
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Contador de caracteres para descripción
document.getElementById('descripcion').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    // Actualizar contador (puedes agregar un elemento para mostrar esto)
    if (currentLength > maxLength) {
        this.value = this.value.substring(0, maxLength);
    }
});
</script>
@endsection