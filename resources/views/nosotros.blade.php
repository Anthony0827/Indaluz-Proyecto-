@extends('layouts.app')

@section('title', 'Nosotros - Indaluz')

@section('content')

<!-- HERO NOSOTROS -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/equipo-indaluz.jpg')">
    <div class="absolute inset-0 bg-green-800 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Conoce Indaluz</h1>
            <p class="text-lg max-w-2xl">Conectando el campo andaluz con tu mesa</p>
        </div>
    </div>
</section>

<!-- NUESTRA HISTORIA -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestra Historia</h2>
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-gray-700 mb-4">
                    Indaluz surge de la pasión por la agricultura andaluza y el deseo de modernizar la forma en que los productos frescos llegan desde el campo hasta los hogares de Almería.
                </p>
                <p class="text-gray-700 mb-4">
                    Nuestra plataforma nace como una solución innovadora que elimina intermediarios innecesarios, permitiendo que agricultores locales conecten directamente con consumidores que valoran la calidad y la frescura.
                </p>
                <p class="text-gray-700">
                    Trabajamos cada día para fortalecer el sector agrícola local, promoviendo prácticas sostenibles y creando una comunidad comprometida con el producto de calidad.
                </p>
            </div>
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-green-700 mb-4">¿Por qué elegir local?</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
                        <span class="text-gray-700">Productos más frescos y sabrosos</span>
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
                        <span class="text-gray-700">Apoyo a la economía local</span>
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
                        <span class="text-gray-700">Menor huella medioambiental</span>
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
                        <span class="text-gray-700">Precios más justos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NUESTROS VALORES -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestros Valores</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Transparencia -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="eye" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Transparencia</h3>
                <p class="text-gray-700">
                    Conoce exactamente de dónde vienen tus productos: quién los cultiva, cómo se producen y cuál es su historia.
                </p>
            </div>
            
            <!-- Sostenibilidad -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="leaf" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Sostenibilidad</h3>
                <p class="text-gray-700">
                    Promovemos prácticas agrícolas responsables que cuiden nuestro entorno y preserven la tierra para el futuro.
                </p>
            </div>
            
            <!-- Comunidad -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Comunidad</h3>
                <p class="text-gray-700">
                    Creamos vínculos sólidos entre agricultores y consumidores, fortaleciendo el tejido social de nuestra región.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- NUESTRO COMPROMISO -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestro Compromiso</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Con los Agricultores -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="wheat" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-green-700">Con los Agricultores</h3>
                </div>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Herramientas digitales fáciles de usar
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Comisiones transparentes y justas
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Soporte técnico personalizado
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Promoción de sus productos de calidad
                    </li>
                </ul>
            </div>
            
            <!-- Con los Consumidores -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="shopping-basket" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-green-700">Con los Consumidores</h3>
                </div>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Productos frescos y de temporada
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Entrega rápida y confiable
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Precios competitivos sin intermediarios
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-green-600 mr-2 mt-1"></i>
                        Atención al cliente excepcional
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- MISIÓN Y VISIÓN -->
<section class="grid md:grid-cols-2 gap-8 mb-16">
    <!-- Misión -->
    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i data-lucide="target" class="w-6 h-6 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-green-700">Nuestra Misión</h3>
        </div>
        <p class="text-gray-700 leading-relaxed">
            Revolucionar la forma en que se comercializan los productos agrícolas en Almería, creando un puente digital entre el campo y la mesa que beneficie tanto a productores como a consumidores, promoviendo la calidad, la sostenibilidad y el comercio justo.
        </p>
    </div>
    
    <!-- Visión -->
    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i data-lucide="compass" class="w-6 h-6 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-green-700">Nuestra Visión</h3>
        </div>
        <p class="text-gray-700 leading-relaxed">
            Convertirnos en la plataforma de referencia para el comercio de productos agrícolas locales en Andalucía, donde cada compra sea una inversión en nuestra comunidad y cada agricultor tenga las herramientas necesarias para prosperar en el mercado digital.
        </p>
    </div>
</section>

<!-- ¿CÓMO FUNCIONA? -->
<section class="bg-gray-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">¿Cómo Funciona Indaluz?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Agricultores Publican</h3>
                <p class="text-gray-700">
                    Los productores locales suben sus productos frescos con información detallada sobre origen y métodos de cultivo.
                </p>
            </div>
            
            <!-- Paso 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Consumidores Eligen</h3>
                <p class="text-gray-700">
                    Los clientes navegan por nuestra selección de productos locales y realizan sus pedidos de forma sencilla.
                </p>
            </div>
            
            <!-- Paso 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Entregamos Frescura</h3>
                <p class="text-gray-700">
                    Coordinamos la entrega para que los productos lleguen frescos del campo a tu puerta en el menor tiempo posible.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA ÚNETE -->
<section class="text-center bg-gradient-to-r from-green-600 to-green-700 text-white py-12 rounded-xl">
    <h3 class="text-2xl font-semibold mb-4">¿Quieres formar parte de Indaluz?</h3>
    <p class="mb-6 max-w-2xl mx-auto">
        Únete a nuestra comunidad y forma parte de la revolución agrícola digital. Tanto si produces como si consumes, tenemos un lugar para ti.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register.role', 'agricultor') }}" class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
            <i data-lucide="wheat" class="w-5 h-5 inline mr-2"></i>
            Soy Agricultor
        </a>
        <a href="{{ route('register.role', 'cliente') }}" class="bg-green-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-900 transition border border-green-400">
            <i data-lucide="shopping-basket" class="w-5 h-5 inline mr-2"></i>
            Soy Consumidor
        </a>
    </div>
    
    <div class="mt-6 text-center">
        <p class="text-green-100 text-sm mb-2">¿Ya tienes cuenta?</p>
        <a href="{{ route('login') }}" class="text-white hover:text-green-100 underline font-medium">
            Inicia sesión aquí
        </a>
    </div>
</section>

@endsection