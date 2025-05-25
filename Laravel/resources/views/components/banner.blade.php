<div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold text-white mb-2 text-center">{{ $title }}</h2>
        @if(isset($subtitle))
            <p class="text-blue-100 text-center">{{ $subtitle }}</p>
        @endif
    </div>
</div> 