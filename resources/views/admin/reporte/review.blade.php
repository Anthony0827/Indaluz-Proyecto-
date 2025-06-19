{{-- resources/views/admin/reporte/review.blade.php --}}
@extends('layouts.admin')

@section('title', 'Revisar Reporte #' . $reporte->id_reporte)

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center space-x-4 mb-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-green-600 hover:text-green-700">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Caso #{{ $reporte->id_reporte }}</h1>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                               {{ $reporte->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                  ($reporte->estado === 'en_revision' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $reporte->estado)) }}
                    </span>
                </div>
                <p class="text-gray-600">
                    Reportado el {{ $reporte->fecha_reporte->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>
            
            @if($reporte->estado !== 'resuelto')
                <form action="{{ route('admin.reporte.resolve', $reporte->token_acceso) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                            onclick="return confirm('¿Marcar este reporte como resuelto sin tomar acción?')">
                        <i data-lucide="check" class="w-4 h-4 inline mr-2"></i>
                        Marcar como Resuelto
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Información del reporte --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Detalles del reporte --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Detalles del Reporte</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Motivo</label>
                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $reporte->razon }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $reporte->descripcion }}</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reportado por</label>
                    <div class="mt-1 flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <i data-lucide="user" class="w-4 h-4 text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $reporte->usuarioReporta->nombre }} {{ $reporte->usuarioReporta->apellido }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst($reporte->tipo_usuario) }} - {{ $reporte->usuarioReporta->correo }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pedido relacionado</label>
                    <p class="mt-1 text-sm text-gray-900">
                        #{{ $reporte->pedido->id_pedido }} - {{ $reporte->pedido->fecha_pedido->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Información del producto --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Producto Reportado</h2>
            
            <div class="space-y-4">
                @if($reporte->producto->imagen)
                    <div>
                        <img src="{{ asset('storage/' . $reporte->producto->imagen) }}" 
                             alt="{{ $reporte->producto->nombre }}"
                             class="w-full h-48 object-cover rounded-lg">
                    </div>
                @endif
                
                <div>
                    <h3 class="font-medium text-gray-900">{{ $reporte->producto->nombre }}</h3>
                    <p class="text-sm text-gray-600">{{ $reporte->producto->descripcion }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Precio:</span>
                        <span class="font-medium">€{{ number_format($reporte->producto->precio, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Categoría:</span>
                        <span class="font-medium">{{ ucfirst($reporte->producto->categoria) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Stock:</span>
                        <span class="font-medium">{{ $reporte->producto->cantidad_inventario }} {{ $reporte->producto->unidad_medida }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Estado:</span>
                        <span class="font-medium">{{ ucfirst($reporte->producto->estado) }}</span>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <h4 class="font-medium text-gray-900 mb-2">Agricultor</h4>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="user" class="w-4 h-4 text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $reporte->producto->agricultor->nombre }} {{ $reporte->producto->agricultor->apellido }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $reporte->producto->agricultor->correo }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reseñas del producto --}}
    @if($reporte->producto->resenas->count() > 0)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Reseñas del Producto ({{ $reporte->producto->resenas->count() }})</h2>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($reporte->producto->resenas as $resena)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $resena->cliente->nombre }} {{ $resena->cliente->apellido }}
                                    </p>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i data-lucide="star" class="w-4 h-4 {{ $i <= $resena->rating ? 'fill-current' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500">{{ 
                                            is_string($resena->fecha_reseña) 
                                            ? \Carbon\Carbon::parse($resena->fecha_reseña)->format('d/m/Y')
                                            : $resena->fecha_reseña->format('d/m/Y') 
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.reporte.delete-resena', [$reporte->token_acceso, $resena->id_reseña]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-700 text-sm"
                                        onclick="return confirm('¿Eliminar esta reseña?')">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                        
                        @if($resena->comentario)
                            <p class="text-sm text-gray-700 pl-11">{{ $resena->comentario }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 pt-4 border-t">
                <form action="{{ route('admin.reporte.delete-resenas', $reporte->token_acceso) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                            onclick="return confirm('¿Eliminar TODAS las reseñas de este agricultor?')">
                        <i data-lucide="trash-2" class="w-4 h-4 inline mr-2"></i>
                        Eliminar Todas las Reseñas
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- Acciones administrativas --}}
    @if($reporte->estado !== 'resuelto')
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Acciones Administrativas</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Eliminar producto --}}
                <form action="{{ route('admin.reporte.delete-producto', $reporte->token_acceso) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                            onclick="return confirm('¿ELIMINAR completamente este producto? Esta acción no se puede deshacer.')">
                        <i data-lucide="package-x" class="w-5 h-5 mx-auto mb-2"></i>
                        <div class="text-sm font-medium">Eliminar Producto</div>
                        <div class="text-xs opacity-90">Completo + imagen</div>
                    </button>
                </form>

                {{-- Eliminar solo imagen --}}
                @if($reporte->producto->imagen)
                    <form action="{{ route('admin.reporte.delete-image', $reporte->token_acceso) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors"
                                onclick="return confirm('¿Eliminar la imagen del producto?')">
                            <i data-lucide="image-off" class="w-5 h-5 mx-auto mb-2"></i>
                            <div class="text-sm font-medium">Eliminar Imagen</div>
                            <div class="text-xs opacity-90">Solo la foto</div>
                        </button>
                    </form>
                @endif

                {{-- Bloquear usuario que reportó --}}
                <form action="{{ route('admin.reporte.block-user', $reporte->token_acceso) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $reporte->id_usuario_reporta }}">
                    <input type="hidden" name="user_type" value="{{ $reporte->tipo_usuario }}">
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors"
                            onclick="return confirm('¿Bloquear al usuario que hizo el reporte?')">
                        <i data-lucide="user-x" class="w-5 h-5 mx-auto mb-2"></i>
                        <div class="text-sm font-medium">Bloquear Reportante</div>
                        <div class="text-xs opacity-90">{{ ucfirst($reporte->tipo_usuario) }}</div>
                    </button>
                </form>

                {{-- Bloquear agricultor --}}
                <form action="{{ route('admin.reporte.block-user', $reporte->token_acceso) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $reporte->producto->id_agricultor }}">
                    <input type="hidden" name="user_type" value="agricultor">
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                            onclick="return confirm('¿Bloquear al agricultor dueño del producto?')">
                        <i data-lucide="user-x" class="w-5 h-5 mx-auto mb-2"></i>
                        <div class="text-sm font-medium">Bloquear Agricultor</div>
                        <div class="text-xs opacity-90">Dueño del producto</div>
                    </button>
                </form>
            </div>

            {{-- Información importante --}}
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start space-x-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="font-medium text-yellow-800 mb-1">Precauciones</h3>
                        <ul class="text-yellow-700 text-sm space-y-1">
                            <li>• <strong>Eliminar producto</strong>: Borra completamente el producto, su imagen y todas las referencias</li>
                            <li>• <strong>Bloquear usuario</strong>: Marca al usuario como no verificado, impidiendo el acceso</li>
                            <li>• <strong>Eliminar reseñas</strong>: Acción irreversible, úsala solo en casos graves</li>
                            <li>• Todas las acciones quedan registradas por seguridad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection