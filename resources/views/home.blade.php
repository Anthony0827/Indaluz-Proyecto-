@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<!-- HERO -->
<section class="relative w-full h-96 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/frutas-header.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-50 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Frescura directa desde el campo</h1>
            <p class="mb-6 text-lg">Conecta con agricultores locales y disfruta productos frescos, sostenibles y saludables.</p>
            <a href="{{ route('register') }}" class="bg-white text-green-700 px-6 py-2 rounded font-semibold hover:bg-green-100 transition">Empieza ahora</a>
        </div>
    </div>
</section>

<!-- ICONOS DE BENEFICIOS -->
<section class="grid grid-cols-2 md:grid-cols-5 text-center gap-6 mb-12">
    <div>
        <i data-lucide="truck" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Envíos</p>
    </div>
    <div>
        <i data-lucide="rotate-ccw" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Devoluciones</p>
    </div>
    <div>
        <i data-lucide="lock" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Pagos seguros</p>
    </div>
    <div>
        <i data-lucide="badge-dollar-sign" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Precios justos</p>
    </div>
    <div>
        <i data-lucide="check-circle" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Máxima calidad</p>
    </div>
</section>

<!-- ¿POR QUÉ ELEGIRNOS? -->
<section class="text-center mb-16">
    <h2 class="text-3xl font-bold text-green-700 mb-6">¿Por qué elegirnos?</h2>
    <div class="grid md:grid-cols-2 gap-6 max-w-5xl mx-auto">
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Ofrecemos productos frescos y de calidad directamente del agricultor a su mesa.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Comprometidos con prácticas sostenibles para cuidar el medio ambiente.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Pagos seguros y políticas de devolución flexibles.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Precios justos que benefician tanto al consumidor como al agricultor.</p>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="text-center bg-green-700 text-white py-12 rounded-xl mb-16">
    <h3 class="text-2xl font-semibold mb-4">¡Únete a la revolución verde!</h3>
    <p class="mb-6">Crea tu cuenta y empieza a apoyar el comercio local hoy mismo.</p>
    <a href="{{ route('register') }}" class="bg-white text-green-700 px-6 py-2 rounded hover:bg-green-100 transition">Registrarse</a>
</section>

<!-- CONTACTO Y REDES SOCIALES PROFESIONAL -->
<section class="grid md:grid-cols-2 gap-8 mb-16">
    <!-- Información de Contacto y Redes Sociales -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h4 class="text-2xl font-bold text-green-700 mb-6">Conecta con Nosotros</h4>
        
        <!-- Información de Contacto -->
        <div class="mb-8">
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Información de Contacto</h5>
            <div class="space-y-3">
                <div class="flex items-center text-gray-700">
                    <i data-lucide="mail" class="w-5 h-5 text-green-600 mr-3"></i>
                    <div>
                        <p class="font-medium">Email</p>
                        <a href="mailto:contacto@indaluz.com" class="text-green-600 hover:text-green-700">contacto@indaluz.com</a>
                    </div>
                </div>
                <div class="flex items-center text-gray-700">
                    <i data-lucide="phone" class="w-5 h-5 text-green-600 mr-3"></i>
                    <div>
                        <p class="font-medium">Teléfono</p>
                        <a href="tel:+34950123456" class="text-green-600 hover:text-green-700">+34 950 123 456</a>
                    </div>
                </div>
                <div class="flex items-center text-gray-700">
                    <i data-lucide="map-pin" class="w-5 h-5 text-green-600 mr-3"></i>
                    <div>
                        <p class="font-medium">Ubicación</p>
                        <p class="text-gray-600">Almería, Andalucía</p>
                    </div>
                </div>
                <div class="flex items-center text-gray-700">
                    <i data-lucide="clock" class="w-5 h-5 text-green-600 mr-3"></i>
                    <div>
                        <p class="font-medium">Horario</p>
                        <p class="text-gray-600">Lun - Vie: 9:00 - 18:00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div>
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Síguenos en Redes Sociales</h5>
            <p class="text-gray-600 mb-4 text-sm">Mantente conectado con las últimas novedades, productos de temporada y consejos de nuestros agricultores.</p>
            
            <div class="flex space-x-4">
                <a href="#" class="flex items-center justify-center w-10 h-10 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors" title="Facebook">
                    <i data-lucide="facebook" class="w-5 h-5"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-10 h-10 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors" title="Instagram">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-10 h-10 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors" title="Twitter">
                    <i data-lucide="twitter" class="w-5 h-5"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-10 h-10 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors" title="LinkedIn">
                    <i data-lucide="linkedin" class="w-5 h-5"></i>
                </a>
            </div>

            
        </div>
    </div>

    <!-- Botón de Contacto -->
    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-lg shadow-md p-8 text-white text-center flex flex-col justify-center">
        <div class="mb-6">
            <i data-lucide="message-circle" class="w-16 h-16 mx-auto mb-4 text-green-100"></i>
            <h4 class="text-2xl font-bold mb-3">¿Tienes alguna consulta?</h4>
            <p class="text-green-100 mb-6">
                Nuestro equipo está aquí para ayudarte. Envíanos tu consulta y te responderemos en menos de 24 horas.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('contacto') }}" 
               class="inline-block w-full bg-white text-green-700 py-3 px-6 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                <i data-lucide="send" class="w-5 h-5 inline mr-2"></i>
                Enviar Consulta
            </a>
            
            <div class="text-center text-green-100 text-sm">
                <p>También puedes llamarnos directamente:</p>
                <a href="tel:+34950123456" class="font-semibold text-white hover:text-green-100">
                    +34 950 123 456
                </a>
            </div>
        </div>
    </div>
</section>

@endsection