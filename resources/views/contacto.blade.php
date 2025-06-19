@extends('layouts.app')

@section('title', 'Contacto - Indaluz')

@section('content')

<!-- HERO CONTACTO -->
<section class="relative w-full h-64 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/almeria-paisaje.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contacta con Nosotros</h1>
            <p class="text-lg">Estamos aquí para ayudarte con cualquier consulta</p>
        </div>
    </div>
</section>

<!-- INFORMACIÓN DE CONTACTO -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Teléfono -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="phone" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Teléfono</h3>
                <p class="text-gray-600 mb-2">Llámanos de lunes a viernes</p>
                <p class="font-semibold text-green-700">+34 950 123 456</p>
                <p class="text-sm text-gray-500 mt-1">9:00 - 18:00 h</p>
            </div>

            <!-- Email -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="mail" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Email</h3>
                <p class="text-gray-600 mb-2">Escríbenos cuando quieras</p>
                <p class="font-semibold text-green-700">contacto@indaluz.com</p>
                <p class="text-sm text-gray-500 mt-1">Respuesta en 24h</p>
            </div>

            <!-- Ubicación -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="map-pin" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Ubicación</h3>
                <p class="text-gray-600 mb-2">Oficinas centrales</p>
                <p class="font-semibold text-green-700">Almería, Andalucía</p>
                <p class="text-sm text-gray-500 mt-1">España</p>
            </div>
        </div>
    </div>
</section>

<!-- FORMULARIO DE CONTACTO Y MAPA -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Formulario -->
            <div>
                <h2 class="text-3xl font-bold text-green-700 mb-6">Envíanos un Mensaje</h2>
                <form class="space-y-6" action="{{ route('contacto.enviar') }}" method="POST">
                    @csrf
                    
                    <!-- Nombre y Email -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre completo *
                            </label>
                            <input 
                                type="text" 
                                id="nombre" 
                                name="nombre" 
                                required
                                value="{{ old('nombre') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="Tu nombre completo"
                            >
                            @error('nombre')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="tu@email.com"
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Teléfono y Tipo de Usuario -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                id="telefono" 
                                name="telefono"
                                value="{{ old('telefono') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="+34 600 000 000"
                            >
                            @error('telefono')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tipo_usuario" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de usuario *
                            </label>
                            <select 
                                id="tipo_usuario" 
                                name="tipo_usuario" 
                                required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            >
                                <option value="">Seleccionar...</option>
                                <option value="consumidor" {{ old('tipo_usuario') == 'consumidor' ? 'selected' : '' }}>Consumidor</option>
                                <option value="agricultor" {{ old('tipo_usuario') == 'agricultor' ? 'selected' : '' }}>Agricultor</option>
                                <option value="empresa" {{ old('tipo_usuario') == 'empresa' ? 'selected' : '' }}>Empresa/Restaurante</option>
                                <option value="otro" {{ old('tipo_usuario') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_usuario')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Asunto -->
                    <div>
                        <label for="asunto" class="block text-sm font-medium text-gray-700 mb-2">
                            Asunto *
                        </label>
                        <select 
                            id="asunto" 
                            name="asunto" 
                            required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        >
                            <option value="">Selecciona un tema...</option>
                            <option value="soporte_tecnico" {{ old('asunto') == 'soporte_tecnico' ? 'selected' : '' }}>Soporte técnico</option>
                            <option value="info_productos" {{ old('asunto') == 'info_productos' ? 'selected' : '' }}>Información sobre productos</option>
                            <option value="registro_agricultor" {{ old('asunto') == 'registro_agricultor' ? 'selected' : '' }}>Registro como agricultor</option>
                            <option value="problemas_pedido" {{ old('asunto') == 'problemas_pedido' ? 'selected' : '' }}>Problemas con pedido</option>
                            <option value="sugerencias" {{ old('asunto') == 'sugerencias' ? 'selected' : '' }}>Sugerencias y mejoras</option>
                            <option value="colaboraciones" {{ old('asunto') == 'colaboraciones' ? 'selected' : '' }}>Colaboraciones empresariales</option>
                            <option value="otro" {{ old('asunto') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('asunto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mensaje -->
                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">
                            Mensaje *
                        </label>
                        <textarea 
                            id="mensaje" 
                            name="mensaje" 
                            rows="6" 
                            required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition resize-none"
                            placeholder="Describe tu consulta o mensaje con el mayor detalle posible..."
                        >{{ old('mensaje') }}</textarea>
                        @error('mensaje')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Consentimiento RGPD -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="rgpd" 
                            name="rgpd" 
                            required
                            {{ old('rgpd') ? 'checked' : '' }}
                            class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <label for="rgpd" class="text-sm text-gray-600">
                            Acepto que Indaluz trate mis datos personales para responder a mi consulta según la 
                            <a href="#" class="text-green-600 underline">Política de Privacidad</a> *
                        </label>
                    </div>
                    @error('rgpd')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Newsletter -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="newsletter" 
                            name="newsletter"
                            {{ old('newsletter') ? 'checked' : '' }}
                            class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <label for="newsletter" class="text-sm text-gray-600">
                            Quiero recibir novedades y ofertas especiales de Indaluz por email
                        </label>
                    </div>

                    <!-- Botón Enviar -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition"
                        >
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mapa e Información Adicional -->
            <div>
                <h2 class="text-3xl font-bold text-green-700 mb-6">Nuestra Ubicación</h2>
                
                <!-- Mapa de Google centrado en Almería Ciudad -->
                <div class="h-64 rounded-xl mb-6 overflow-hidden shadow-md">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25234.359076479983!2d-2.4737436835937504!3d36.84047797332686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7078b47c3d76c5%3A0x49c0ca7b70fb3a5!2s04001%20Almer%C3%ADa%2C%20Spain!5e0!3m2!1sen!2sus!4v1735226517123!5m2!1sen!2sus" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Información Adicional -->
                <div class="space-y-6">
                    <div class="bg-green-50 p-6 rounded-xl">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Horarios de Atención</h3>
                        <div class="space-y-2 text-gray-700">
                            <div class="flex justify-between">
                                <span>Lunes - Viernes:</span>
                                <span class="font-medium">9:00 - 18:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sábados:</span>
                                <span class="font-medium">10:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Domingos:</span>
                                <span class="font-medium">Cerrado</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Información Adicional</h3>
                        <p class="text-gray-600 mb-3">
                            Nuestro equipo de atención al cliente está aquí para resolver todas tus dudas sobre productos, pedidos y servicios.
                        </p>
                        <div class="space-y-2">
                            <p class="flex items-center text-green-700">
                                <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                <span class="font-semibold">+34 950 123 456</span>
                            </p>
                            <p class="flex items-center text-green-700">
                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                                <span class="font-semibold">contacto@indaluz.com</span>
                            </p>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Tiempo de respuesta promedio: 24 horas
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ RÁPIDAS -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Preguntas Frecuentes</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- FAQ 1 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Cómo puedo registrarme como agricultor?</h3>
                <p class="text-gray-600 text-sm">
                    Es muy sencillo. Solo necesitas tu DNI, certificado de explotación agraria y una cuenta bancaria. 
                    El proceso de registro toma menos de 10 minutos.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Cuánto tarda en llegar mi pedido?</h3>
                <p class="text-gray-600 text-sm">
                    Los pedidos se entregan entre 24-48 horas desde la confirmación. Los productos más frescos 
                    pueden estar disponibles para recogida el mismo día.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Qué comisión cobráis a los agricultores?</h3>
                <p class="text-gray-600 text-sm">
                    Solo cobramos un 5% de comisión por venta realizada. Sin cuotas mensuales ni costes ocultos. 
                    Si no vendes, no pagas nada.
                </p>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Ofrecéis garantía de calidad?</h3>
                <p class="text-gray-600 text-sm">
                    Sí, todos nuestros productos están garantizados. Si no estás satisfecho, te devolvemos el dinero 
                    o reemplazamos el producto sin preguntas.
                </p>
            </div>
        </div>
        
        
    </div>
</section>

<!-- REDES SOCIALES -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Síguenos en Redes Sociales</h2>
        <p class="text-gray-600 mb-8">
            Mantente al día con las últimas novedades, productos de temporada y consejos de nuestros agricultores.
        </p>
        
        <div class="flex justify-center space-x-6 mb-8">
            <!-- Facebook -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="facebook" class="w-6 h-6"></i>
            </a>
            
            <!-- Instagram -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="instagram" class="w-6 h-6"></i>
            </a>
            
            <!-- Twitter -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="twitter" class="w-6 h-6"></i>
            </a>
            
            <!-- LinkedIn -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="linkedin" class="w-6 h-6"></i>
            </a>
            
            <!-- YouTube -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="youtube" class="w-6 h-6"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6 text-sm">
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="facebook" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">@IndaluzAlmeria</p>
                <p class="text-gray-600">Noticias y actualizaciones diarias</p>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="instagram" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">@indaluz_oficial</p>
                <p class="text-gray-600">Fotos de productos y recetas</p>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="youtube" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">Indaluz TV</p>
                <p class="text-gray-600">Tutoriales y documentales</p>
            </div>
        </div>
    </div>
</section>



@endsection