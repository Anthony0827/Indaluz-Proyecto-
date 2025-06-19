@extends('layouts.app')

@section('title', 'Para Agricultores - Indaluz')

@section('content')

<!-- HERO AGRICULTORES -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/agricultor-campo.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Vende Directamente</h1>
            <p class="text-lg max-w-3xl">Conecta con consumidores locales y elimina intermediarios innecesarios</p>
        </div>
    </div>
</section>

<!-- BENEFICIOS PARA AGRICULTORES -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">¿Por qué elegir Indaluz?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Beneficio 1 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="trending-up" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Venta Directa</h3>
                <p class="text-gray-600">
                    Elimina intermediarios y vende directamente al consumidor final. Tú decides el precio de tus productos.
                </p>
            </div>

            <!-- Beneficio 2 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Mercado Local</h3>
                <p class="text-gray-600">
                    Accede a consumidores de Almería que valoran la frescura y calidad de los productos locales.
                </p>
            </div>

            <!-- Beneficio 3 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="smartphone" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Gestión Simple</h3>
                <p class="text-gray-600">
                    Plataforma fácil de usar para gestionar productos, pedidos y comunicarte con clientes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CÓMO FUNCIONA -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Cómo Empezar en 3 Pasos</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Regístrate</h3>
                <p class="text-gray-700">
                    Crea tu perfil con información sobre tu explotación, ubicación y tipos de cultivos.
                </p>
            </div>

            <!-- Paso 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Publica Productos</h3>
                <p class="text-gray-700">
                    Sube fotos de tus productos, describe su calidad y establece precios competitivos.
                </p>
            </div>

            <!-- Paso 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Recibe Pedidos</h3>
                <p class="text-gray-700">
                    Los clientes hacen pedidos y tú gestionas la entrega según tu disponibilidad.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- HERRAMIENTAS DISPONIBLES -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Herramientas que Incluimos</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Gestión de Productos -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="package" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Gestión de Productos</h3>
                        <p class="text-gray-600 mb-3">
                            Administra tu catálogo de productos de forma sencilla y mantén actualizado tu inventario.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Añadir productos con fotos y descripciones</li>
                            <li>• Actualizar precios y disponibilidad</li>
                            <li>• Gestionar stock y cantidades</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Panel de Pedidos -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Panel de Pedidos</h3>
                        <p class="text-gray-600 mb-3">
                            Visualiza y gestiona todos los pedidos recibidos desde un panel centralizado.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Lista de pedidos por estado</li>
                            <li>• Información de contacto del cliente</li>
                            <li>• Detalles de productos pedidos</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Perfil Público -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Perfil de Agricultor</h3>
                        <p class="text-gray-600 mb-3">
                            Crea tu perfil público para que los clientes conozcan tu historia y métodos de cultivo.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Información sobre tu explotación</li>
                            <li>• Fotos de tu finca y cultivos</li>
                            <li>• Sistema de reseñas de clientes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Análisis de Ventas -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="bar-chart-3" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Análisis de Ventas</h3>
                        <p class="text-gray-600 mb-3">
                            Consulta estadísticas básicas de tus ventas y productos más demandados.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Resumen de ventas mensuales</li>
                            <li>• Productos más vendidos</li>
                            <li>• Histórico de pedidos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- CTA REGISTRO -->
<section class="text-center bg-green-50 py-12 rounded-xl">
    <h3 class="text-3xl font-bold text-green-700 mb-4">¿Listo para Empezar?</h3>
    <p class="text-gray-700 mb-8 max-w-2xl mx-auto">
        Únete a la comunidad de agricultores que ya están vendiendo directamente a los consumidores de Almería. 
        El registro es sencillo y puedes empezar a publicar productos inmediatamente.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register.role', 'agricultor') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Registrarse como Agricultor
        </a>
        <a href="{{ route('contacto') }}" class="bg-white text-green-700 px-8 py-3 rounded-lg font-semibold border-2 border-green-600 hover:bg-green-50 transition">
            Solicitar Información
        </a>
    </div>
    <p class="text-sm text-gray-600 mt-4">
        ¿Tienes dudas? <a href="{{ route('contacto') }}" class="text-green-600 underline">Contáctanos</a> y te ayudamos sin compromiso.
    </p>
</section>

@endsection