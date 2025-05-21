<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#213448] to-[#547792] opacity-10 pattern-grid"></div>
                    
                    <div class="relative p-8 md:p-12">
                        <div class="text-center space-y-6">
                            <div class="inline-block">
                                <span class="bg-[#213448] text-white px-4 py-2 rounded-full text-sm font-semibold tracking-wide">
                                    Segera Hadir
                                </span>
                            </div>
                            
                            <h1 class="text-4xl md:text-5xl font-bold text-[#213448]">
                                Acara Spesial
                            </h1>
                            
                            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                                Bersiaplah untuk pengalaman luar biasa! Acara spesial kami akan segera hadir dengan sesuatu yang istimewa untuk Anda.
                            </p>
                            
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="text-2xl font-semibold text-[#547792]">
                                    Tandai kalender Anda
                                </div>
                                <div class="text-4xl md:text-5xl font-bold text-[#213448]">
                                    1 Januari 2026
                                </div>
                            </div>
                            
                            <!-- Countdown Timer -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto mt-8">
                                <div class="bg-white rounded-lg shadow-lg p-4">
                                    <div class="text-3xl font-bold text-[#213448]" id="days">--</div>
                                    <div class="text-gray-600">Hari</div>
                                </div>
                                <div class="bg-white rounded-lg shadow-lg p-4">
                                    <div class="text-3xl font-bold text-[#213448]" id="hours">--</div>
                                    <div class="text-gray-600">Jam</div>
                                </div>
                                <div class="bg-white rounded-lg shadow-lg p-4">
                                    <div class="text-3xl font-bold text-[#213448]" id="minutes">--</div>
                                    <div class="text-gray-600">Menit</div>
                                </div>
                                <div class="bg-white rounded-lg shadow-lg p-4">
                                    <div class="text-3xl font-bold text-[#213448]" id="seconds">--</div>
                                    <div class="text-gray-600">Detik</div>
                                </div>
                            </div>
                            
                            <!-- <div class="mt-8">
                                <button class="bg-[#213448] text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-[#547792] transition duration-300">
                                    Beri Tahu Saya
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pattern-grid {
            background-image: radial-gradient(#547792 1px, transparent 1px);
            background-size: 20px 20px;
        }
        /* Ensure images maintain aspect ratio and cover the container */
        .event-image {
            transition: opacity 1s ease-in-out;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>

    <script>
        // Image Carousel
        document.addEventListener('DOMContentLoaded', function() {
            const images = [
                document.getElementById('event-image-1'),
                document.getElementById('event-image-2'),
                document.getElementById('event-image-3')
            ];
            
            let currentImageIndex = 0;
            
            function showNextImage() {
                // Hide current image
                images[currentImageIndex].classList.remove('opacity-100');
                images[currentImageIndex].classList.add('opacity-0');
                
                // Move to next image
                currentImageIndex = (currentImageIndex + 1) % images.length;
                
                // Show next image
                images[currentImageIndex].classList.remove('opacity-0');
                images[currentImageIndex].classList.add('opacity-100');
            }
            
            // Change image every 5 seconds
            setInterval(showNextImage, 5000);
            
            // Initialize first image
            images[0].classList.add('opacity-100');
        });
        
        function updateCountdown() {
            const eventDate = new Date('January 1, 2026 00:00:00').getTime();
            
            function update() {
                const now = new Date().getTime();
                const distance = eventDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = days;
                document.getElementById('hours').textContent = hours;
                document.getElementById('minutes').textContent = minutes;
                document.getElementById('seconds').textContent = seconds;
            }


            // Update immediately
            update();
            
            // Update every second
            setInterval(update, 1000);
        }


        // Start countdown when page loads
        document.addEventListener('DOMContentLoaded', updateCountdown);
    </script>
</x-app-layout>
