{{-- resources/views/cliente/carrito.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Mi Carrito')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Mi Carrito de Compras</h1>

    {{-- Contenedor del carrito --}}
    <div id="carrito-container" class="grid lg:grid-cols-3 gap-8">
        {{-- Lista de productos --}}
        <div class="lg:col-span-2">
            <div id="productos-carrito" class="bg-white rounded-lg shadow">
                {{-- Se llenará dinámicamente con JavaScript --}}
                <div class="p-8 text-center text-gray-500">
                    <div class="animate-pulse">
                        <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/3 mx-auto"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen del pedido --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>
                
                <div id="resumen-carrito" class="space-y-3">
                    {{-- Se llenará dinámicamente con JavaScript --}}
                </div>

                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span id="total-carrito">0.00€</span>
                    </div>
                </div>

                <button id="proceder-pago" 
                        class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                    Proceder al pago
                </button>

                <a href="{{ route('cliente.home') }}" 
                   class="block text-center mt-4 text-green-600 hover:text-green-700">
                    Continuar comprando
                </a>
            </div>
        </div>
    </div>

    {{-- Productos recomendados --}}
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">También te puede interesar</h2>
        <div id="productos-recomendados" class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- Se puede llenar con productos aleatorios --}}
        </div>
    </div>
</div>

@push('scripts')
<script>
// Variables globales para el script
window.carritoRoutes = {
    validar: "{{ route('cliente.carrito.validar') }}",
    checkout: "{{ route('cliente.checkout') }}",
    home: "{{ route('cliente.home') }}"
};

document.addEventListener('DOMContentLoaded', function() {
    // Gestión del carrito
    const carritoManager = {
        items: [],
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        
        init() {
            console.log('Inicializando carrito manager...');
            this.loadFromStorage();
            this.render();
            // Validar carrito con delay para evitar sobrecarga
            setTimeout(() => this.validarCarrito(), 500);
        },
        
        loadFromStorage() {
            try {
                const stored = localStorage.getItem('carrito');
                this.items = stored ? JSON.parse(stored) : [];
                
                // Asegurar que items sea siempre un array válido
                if (!Array.isArray(this.items)) {
                    console.warn('Carrito en localStorage no es array válido:', this.items);
                    this.items = [];
                    localStorage.removeItem('carrito');
                    return;
                }
                
                // Validar estructura de cada item y limpiar items inválidos
                this.items = this.items.filter((item, index) => {
                    const isValid = item && 
                           typeof item.id !== 'undefined' && 
                           typeof item.nombre !== 'undefined' && 
                           typeof item.cantidad !== 'undefined' &&
                           item.cantidad > 0;
                    
                    if (!isValid) {
                        console.warn('Item inválido en carrito:', item, 'en índice:', index);
                    }
                    
                    return isValid;
                });
                
                console.log('Carrito cargado desde localStorage:', this.items);
                
            } catch (e) {
                console.error('Error loading cart:', e);
                this.items = [];
                localStorage.removeItem('carrito');
                this.showNotification('Error al cargar el carrito. Se ha reiniciado.', 'error');
            }
        },
        
        saveToStorage() {
            try {
                console.log('Guardando carrito:', this.items);
                localStorage.setItem('carrito', JSON.stringify(this.items));
                this.updateCartCount();
                this.updateHeaderCart();
            } catch (e) {
                console.error('Error saving cart:', e);
                this.showNotification('Error al guardar el carrito', 'error');
            }
        },
        
        updateCartCount() {
            const total = this.items.reduce((sum, item) => sum + (parseInt(item.cantidad) || 0), 0);
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = total;
            });
        },
        
        updateHeaderCart() {
            const cartItems = document.getElementById('cart-items');
            if (cartItems) {
                if (this.items.length === 0) {
                    cartItems.innerHTML = '<p class="px-4 py-8 text-center text-gray-500">Tu carrito está vacío</p>';
                } else {
                    let html = '<div class="max-h-96 overflow-y-auto">';
                    this.items.forEach(item => {
                        const precio = parseFloat(item.precio) || 0;
                        const cantidad = parseInt(item.cantidad) || 0;
                        html += `
                            <div class="px-4 py-3 border-b hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-sm">${this.escapeHtml(item.nombre)}</h4>
                                        <p class="text-xs text-gray-600">${cantidad} x ${precio.toFixed(2)}€/${item.unidad || 'unidad'}</p>
                                    </div>
                                    <span class="font-semibold text-sm">${(cantidad * precio).toFixed(2)}€</span>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    cartItems.innerHTML = html;
                }
            }
        },
        
        async validarCarrito() {
            if (this.items.length === 0) {
                console.log('Carrito vacío, saltando validación');
                return;
            }
            
            try {
                console.log('Iniciando validación del carrito con items:', this.items);
                console.log('CSRF Token:', this.csrfToken);
                console.log('URL de validación:', window.carritoRoutes.validar);
                
                const requestBody = { items: this.items };
                console.log('Enviando:', JSON.stringify(requestBody));
                
                const response = await fetch(window.carritoRoutes.validar, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                });
                
                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error response body:', errorText);
                    
                    if (response.status === 419) {
                        this.showNotification('Sesión expirada. Recargando página...', 'error');
                        setTimeout(() => window.location.reload(), 2000);
                        return;
                    }
                    
                    if (response.status === 500) {
                        this.showNotification('Error interno del servidor. Intenta recargar la página.', 'error');
                        return;
                    }
                    
                    throw new Error(`HTTP ${response.status}: ${response.statusText}\n${errorText}`);
                }
                
                const data = await response.json();
                console.log('Respuesta exitosa del servidor:', data);
                
                if (data.productos && Array.isArray(data.productos)) {
                    console.log('Actualizando items con productos validados:', data.productos);
                    this.items = data.productos;
                    this.saveToStorage();
                    this.render();
                }
                
                if (data.errores && data.errores.length > 0) {
                    console.log('Mostrando errores:', data.errores);
                    // Mostrar errores uno por uno con delay
                    data.errores.forEach((error, index) => {
                        setTimeout(() => {
                            this.showNotification(error, 'error');
                        }, index * 1000);
                    });
                }
                
            } catch (error) {
                console.error('Error completo en validación del carrito:', error);
                console.error('Stack trace:', error.stack);
                this.showNotification('Error al validar el carrito. Verifica tu conexión a internet.', 'error');
            }
        },
        
        updateQuantity(id, cantidad) {
            console.log('Actualizando cantidad:', { id, cantidad });
            const itemIndex = this.items.findIndex(i => i.id == id);
            if (itemIndex !== -1) {
                const item = this.items[itemIndex];
                const newQuantity = Math.max(1, Math.min(parseInt(cantidad) || 1, parseInt(item.max) || 99));
                console.log('Nueva cantidad calculada:', newQuantity);
                this.items[itemIndex].cantidad = newQuantity;
                this.saveToStorage();
                this.render();
                
                // Validar después de cambiar cantidad
                setTimeout(() => this.validarCarrito(), 500);
            } else {
                console.error('Item no encontrado para actualizar cantidad:', id);
            }
        },
        
        removeItem(id) {
            console.log('Eliminando item:', id);
            const originalLength = this.items.length;
            this.items = this.items.filter(item => item.id != id);
            
            if (this.items.length < originalLength) {
                this.saveToStorage();
                this.render();
                this.showNotification('Producto eliminado del carrito', 'success');
                console.log('Item eliminado exitosamente');
            } else {
                console.error('No se pudo eliminar el producto con id:', id);
                this.showNotification('Error al eliminar el producto', 'error');
            }
        },
        
        clearCart() {
            if (confirm('¿Estás seguro de vaciar el carrito?')) {
                console.log('Vaciando carrito');
                this.items = [];
                this.saveToStorage();
                this.render();
                this.showNotification('Carrito vaciado', 'success');
            }
        },
        
        calculateTotal() {
            const total = this.items.reduce((sum, item) => {
                const precio = parseFloat(item.precio) || 0;
                const cantidad = parseInt(item.cantidad) || 0;
                return sum + (precio * cantidad);
            }, 0);
            console.log('Total calculado:', total);
            return total;
        },
        
        render() {
            console.log('Renderizando carrito con', this.items.length, 'items');
            const container = document.getElementById('productos-carrito');
            const resumen = document.getElementById('resumen-carrito');
            const total = document.getElementById('total-carrito');
            const btnPago = document.getElementById('proceder-pago');
            
            if (!container || !resumen || !total || !btnPago) {
                console.error('Elementos del carrito no encontrados:', {
                    container: !!container,
                    resumen: !!resumen,
                    total: !!total,
                    btnPago: !!btnPago
                });
                return;
            }
            
            if (this.items.length === 0) {
                container.innerHTML = `
                    <div class="p-12 text-center">
                        <i data-lucide="shopping-cart" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tu carrito está vacío</h3>
                        <p class="text-gray-600 mb-6">Agrega algunos productos frescos para empezar</p>
                        <a href="${window.carritoRoutes.home}" 
                           class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            Ir a comprar
                        </a>
                    </div>
                `;
                resumen.innerHTML = '<p class="text-gray-500 text-center">No hay productos</p>';
                total.textContent = '0.00€';
                btnPago.disabled = true;
            } else {
                // Renderizar productos
                let htmlProductos = `
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Productos (${this.items.length})</h2>
                            <button onclick="window.carritoManager.clearCart()" 
                                    class="text-red-600 hover:text-red-700 text-sm">
                                Vaciar carrito
                            </button>
                        </div>
                        <div class="space-y-4">
                `;
                
                this.items.forEach(item => {
                    const precio = parseFloat(item.precio) || 0;
                    const cantidad = parseInt(item.cantidad) || 1;
                    const max = parseInt(item.max) || 99;
                    
                    htmlProductos += `
                        <div class="flex gap-4 p-4 border rounded-lg ${item.precio_cambio ? 'border-yellow-400 bg-yellow-50' : ''}">
                            <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                ${item.imagen 
                                    ? `<img src="${item.imagen}" alt="${this.escapeHtml(item.nombre)}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\\"w-full h-full flex items-center justify-center text-gray-400\\"><i data-lucide=\\"image-off\\" class=\\"w-8 h-8\\"></i></div>'">`
                                    : '<div class="w-full h-full flex items-center justify-center text-gray-400"><i data-lucide="image-off" class="w-8 h-8"></i></div>'
                                }
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">${this.escapeHtml(item.nombre)}</h3>
                                <p class="text-sm text-gray-600">Vendido por: ${this.escapeHtml(item.agricultor || 'Agricultor')}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-green-600 font-semibold">
                                        ${precio.toFixed(2)}€/${item.unidad || 'unidad'}
                                    </span>
                                    ${item.precio_cambio ? `
                                        <span class="text-sm text-yellow-600">
                                            (Precio actualizado)
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center border rounded-lg">
                                    <button onclick="window.carritoManager.updateQuantity('${item.id}', ${cantidad - 1})"
                                            class="px-3 py-1 hover:bg-gray-100 ${cantidad <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                                            ${cantidad <= 1 ? 'disabled' : ''}>
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </button>
                                    <input type="number" 
                                           value="${cantidad}" 
                                           min="1" 
                                           max="${max}"
                                           onchange="window.carritoManager.updateQuantity('${item.id}', parseInt(this.value) || 1)"
                                           class="w-16 text-center border-0 focus:outline-none">
                                    <button onclick="window.carritoManager.updateQuantity('${item.id}', ${cantidad + 1})"
                                            class="px-3 py-1 hover:bg-gray-100 ${cantidad >= max ? 'opacity-50 cursor-not-allowed' : ''}"
                                            ${cantidad >= max ? 'disabled' : ''}>
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <button onclick="window.carritoManager.removeItem('${item.id}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                
                htmlProductos += `
                        </div>
                    </div>
                `;
                
                container.innerHTML = htmlProductos;
                
                // Renderizar resumen
                let htmlResumen = '';
                this.items.forEach(item => {
                    const precio = parseFloat(item.precio) || 0;
                    const cantidad = parseInt(item.cantidad) || 1;
                    const subtotal = precio * cantidad;
                    
                    htmlResumen += `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">${this.escapeHtml(item.nombre)} x${cantidad}</span>
                            <span class="font-medium">${subtotal.toFixed(2)}€</span>
                        </div>
                    `;
                });
                resumen.innerHTML = htmlResumen;
                
                // Actualizar total
                const totalAmount = this.calculateTotal();
                total.textContent = totalAmount.toFixed(2) + '€';
                btnPago.disabled = totalAmount <= 0;
            }
            
            // Reinicializar iconos de Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            console.log('Renderizado completado');
        },
        
        showNotification(message, type = 'info') {
            console.log('Mostrando notificación:', { message, type });
            
            // Evitar notificaciones duplicadas
            const existingNotifications = document.querySelectorAll('.notification-popup');
            for (let notif of existingNotifications) {
                if (notif.textContent.includes(message)) {
                    console.log('Notificación duplicada evitada');
                    return;
                }
            }
            
            const notification = document.createElement('div');
            notification.className = `notification-popup fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm ${
                type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' : 
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 
                'bg-blue-100 text-blue-800 border border-blue-200'
            }`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info'}" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm flex-1">${this.escapeHtml(message)}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-600 hover:text-gray-800 flex-shrink-0">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Auto-remover después de 5 segundos
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        },
        
        escapeHtml(text) {
            if (typeof text !== 'string') return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };
    
    // Hacer carritoManager global
    window.carritoManager = carritoManager;
    
    // Inicializar carrito
    console.log('Iniciando aplicación del carrito...');
    carritoManager.init();
    
    // Botón proceder al pago
    const btnProcederPago = document.getElementById('proceder-pago');
    if (btnProcederPago) {
        console.log('Configurando botón de pago');
        btnProcederPago.addEventListener('click', async function () {
            console.log('Botón pago clickeado');
            
            if (carritoManager.items.length > 0) {
                try {
                    console.log('Validando carrito antes del checkout...');
                    
                    const response = await fetch(window.carritoRoutes.validar, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': carritoManager.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ items: carritoManager.items })
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    console.log('Respuesta de validación pre-checkout:', data);
                    
                    if (data.success) {
                        console.log('Validación exitosa, redirigiendo a checkout...');
                        window.location.href = window.carritoRoutes.checkout;
                    } else {
                        carritoManager.showNotification('Algunos productos no están disponibles. Por favor revisa tu carrito.', 'error');
                    }
                } catch (error) {
                    console.error('Error en la validación pre-checkout:', error);
                    carritoManager.showNotification('Ha ocurrido un error al validar el carrito.', 'error');
                }
            } else {
                console.log('Carrito vacío al intentar pagar');
                carritoManager.showNotification('Tu carrito está vacío', 'error');
            }
        });
    } else {
        console.error('Botón de proceder al pago no encontrado');
    }
    
    console.log('Inicialización completa del carrito');
});
</script>
@endpush
@endsection
