@extends('layouts.app')

@section('title', 'Sostenibilidad - Indaluz')

@section('content')

<!-- HERO SOSTENIBILIDAD -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/agricultura-sostenible.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Agricultura Sostenible</h1>
            <p class="text-lg max-w-3xl">Conectando productores locales con consumidores responsables en Almería</p>
        </div>
    </div>
</section>

<!-- INTRODUCCIÓN -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Promoviendo la Agricultura Local</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
            En Indaluz creemos en la importancia de la agricultura local y sostenible. Nuestra plataforma conecta a agricultores de Almería con consumidores que valoran la frescura, la calidad y el origen de sus alimentos.
        </p>
    </div>
</section>

<!-- NUESTROS VALORES -->
<section class="mb-16">
    <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestros Valores</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Valor 1: Producto Local -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="map-pin" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Producto Local</h3>
            <p class="text-gray-600 text-sm text-center">
                Todos nuestros productos provienen de agricultores de Almería, reduciendo la distancia del campo a tu mesa.
            </p>
        </div>

        <!-- Valor 2: Frescura -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="clock" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Máxima Frescura</h3>
            <p class="text-gray-600 text-sm text-center">
                Entrega rápida y directa desde el agricultor, garantizando que recibas productos en su mejor momento.
            </p>
        </div>

        <!-- Valor 3: Precios Justos -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="handshake" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Precios Justos</h3>
            <p class="text-gray-600 text-sm text-center">
                Los agricultores reciben un precio justo por sus productos, sin intermediarios innecesarios.
            </p>
        </div>

        <!-- Valor 4: Transparencia -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="eye" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Transparencia</h3>
            <p class="text-gray-600 text-sm text-center">
                Conoce exactamente quién cultiva tus alimentos y cómo los produce. Total trazabilidad.
            </p>
        </div>
    </div>
</section>

<!-- BENEFICIOS DE LA AGRICULTURA LOCAL -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Beneficios de Comprar Local</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Beneficio 1 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Apoyas la Economía Local</h3>
                    <p class="text-gray-700">
                        Cada compra ayuda directamente a las familias agricultoras de Almería, fortaleciendo nuestra comunidad local.
                    </p>
                </div>
            </div>

            <!-- Beneficio 2 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="truck" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Menor Huella de Carbono</h3>
                    <p class="text-gray-700">
                        Los productos viajan menos distancia, reduciendo las emisiones de transporte y el impacto ambiental.
                    </p>
                </div>
            </div>

            <!-- Beneficio 3 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Productos de Temporada</h3>
                    <p class="text-gray-700">
                        Disfruta de frutas y verduras en su momento óptimo, cuando están más sabrosas y nutritivas.
                    </p>
                </div>
            </div>

            <!-- Beneficio 4 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Conexión con el Agricultor</h3>
                    <p class="text-gray-700">
                        Conoce a quien cultiva tus alimentos, su historia y sus métodos de cultivo tradicionales.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ALMERÍA: HUERTA DE EUROPA -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Almería: La Huerta de Europa</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Información de Almería -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-green-700 mb-6">Datos de Nuestra Provincia</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Hectáreas de invernadero:</span>
                        <span class="text-lg font-bold text-green-600">35,000 ha</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Días de sol al año:</span>
                        <span class="text-lg font-bold text-green-600">320+</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Principales cultivos:</span>
                        <span class="text-lg font-bold text-green-600">Tomate, Pimiento</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Destino exportación:</span>
                        <span class="text-lg font-bold text-green-600">Europa</span>
                    </div>
                </div>
            </div>

            <!-- Nuestro Compromiso -->
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-green-700 mb-6">Nuestro Compromiso</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Apoyo a agricultores locales</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Productos frescos y de calidad</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Precios justos para todos</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Reducción de intermediarios</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- CONSEJOS PARA CONSUMIDORES -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Consejos para una Compra Consciente</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">🕒 Compra de Temporada</h3>
                <p class="text-gray-700 text-sm">
                    Los productos de temporada no solo son más sabrosos y nutritivos, sino también más económicos y sostenibles.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">📋 Planifica tu Compra</h3>
                <p class="text-gray-700 text-sm">
                    Revisa qué tienes en casa antes de comprar. Planificar te ayuda a evitar desperdicios y a ahorrar dinero.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">🏠 Conservación Adecuada</h3>
                <p class="text-gray-700 text-sm">
                    Aprende a conservar correctamente frutas y verduras para mantener su frescura por más tiempo.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">👨‍🌾 Conoce al Agricultor</h3>
                <p class="text-gray-700 text-sm">
                    Lee los perfiles de nuestros agricultores para conocer sus métodos de cultivo y su historia familiar.
                </p>
            </div>
        </div>
    </div>
</section>



@endsection