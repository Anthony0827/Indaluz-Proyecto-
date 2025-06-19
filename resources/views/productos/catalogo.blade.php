{{-- resources/views/productos/catalogo.blade.php --}}
@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')

<!-- HERO SIMPLE -->
<section class="text-center mb-8">
    <h1 class="text-3xl font-bold text-green-700 mb-4">Catálogo de Productos</h1>
    <p class="text-gray-600 max-w-2xl mx-auto">
        Descubre todos los productos frescos y de calidad que nuestros agricultores locales tienen para ofrecerte.
    </p>
</section>

<!-- FILTROS SENCILLOS -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <form method="GET" class="flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-48">
            <input type="text" 
                   name="buscar" 
                   value="{{ request('buscar') }}" 
                   placeholder="Buscar productos..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
        </div>
        
        <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <option value="">Todas las categorías</option>
            <option value="fruta" {{ request('categoria') == 'fruta' ? 'selected' : '' }}>Frutas</option>
            <option value="verdura" {{ request('categoria') == 'verdura' ? 'selected' : '' }}>Verduras</option>
        </select>
        
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
            Buscar
        </button>
        
        @if(request()->hasAny(['buscar', 'categoria']))
            <a href="{{ route('productos.catalogo') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                <i data-lucide="x" class="w-4 h-4 inline mr-2"></i>
                Limpiar
            </a>
        @endif
    </form>
</section>

<!-- GRID DE PRODUCTOS -->
@if($productos->count() > 0)
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-8">
        @foreach($productos as $producto)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Imagen del producto -->
                <div class="relative h-48 bg-gray-200">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i data-lucide="image-off" class="w-12 h-12"></i>
                        </div>
                    @endif
                    
                    <!-- Badge de categoría -->
                    <div class="absolute top-2 left-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $producto->categoria == 'fruta' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($producto->categoria) }}
                        </span>
                    </div>
                </div>

                <!-- Información del producto -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2 text-sm">{{ $producto->nombre }}</h3>
                    
                    <!-- Precio -->
                    <div class="mb-3">
                        <span class="text-lg font-bold text-green-600">
                            €{{ number_format($producto->precio, 2) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            /{{ $producto->unidad_medida }}
                        </span>
                    </div>

                    <!-- Agricultor -->
                    <div class="mb-3">
                        <p class="text-xs text-gray-600 flex items-center">
                            <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                            {{ $producto->agricultor->nombre }}
                        </p>
                    </div>

                    <!-- Stock -->
                    @if($producto->cantidad_inventario > 0)
                        <div class="mb-3">
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                Disponible
                            </span>
                        </div>
                    @else
                        <div class="mb-3">
                            <span class="inline-flex px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                                <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                                Sin stock
                            </span>
                        </div>
                    @endif

                    <!-- Botón Comprar -->
                    <button onclick="window.location.href='{{ route('login') }}'" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium {{ $producto->cantidad_inventario <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $producto->cantidad_inventario <= 0 ? 'disabled' : '' }}>
                        <i data-lucide="shopping-cart" class="w-4 h-4 inline mr-2"></i>
                        Comprar
                    </button>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Paginación -->
    @if($productos->hasPages())
        <div class="flex justify-center">
            {{ $productos->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Estado vacío -->
    <section class="text-center py-12">
        <div class="bg-white rounded-lg shadow-md p-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="search-x" class="w-12 h-12 text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No se encontraron productos</h3>
            @if(request()->hasAny(['buscar', 'categoria']))
                <p class="text-gray-600 mb-6">
                    No hay productos que coincidan con tu búsqueda. Prueba con otros términos.
                </p>
                <a href="{{ route('productos.catalogo') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i data-lucide="refresh-cw" class="w-5 h-5 mr-2"></i>
                    Ver todos los productos
                </a>
            @else
                <p class="text-gray-600">
                    Aún no hay productos disponibles en nuestro catálogo.
                </p>
            @endif
        </div>
    </section>
@endif

<!-- CTA PARA REGISTRARSE -->
<section class="bg-green-600 text-white py-8 rounded-lg text-center">
    <h3 class="text-2xl font-semibold mb-4">¿Te gusta lo que ves?</h3>
    <p class="mb-6 max-w-2xl mx-auto">
        Regístrate para poder comprar productos frescos directamente a nuestros agricultores locales.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register.role', 'cliente') }}" 
           class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 transition-colors">
            <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
            Registrarse como Cliente
        </a>
        <a href="{{ route('register.role', 'agricultor') }}" 
           class="inline-flex items-center px-6 py-3 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800 transition-colors border border-green-400">
            <i data-lucide="sprout" class="w-5 h-5 mr-2"></i>
            Vender como Agricultor
        </a>
    </div>
</section>

<script>
// Inicializar iconos de Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

@endsection