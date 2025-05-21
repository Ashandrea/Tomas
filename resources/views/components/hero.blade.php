<!-- Hero Section -->
<section class="relative w-full h-screen max-h-[90vh] overflow-hidden bg-gray-900">
  <!-- Slider Container -->
  <div class="relative w-full h-full">
    <!-- Slides -->
    @foreach (['event1.png', 'event2.png', 'event3.png'] as $index => $img)
      <div class="absolute inset-0 transition-all duration-1000 ease-[cubic-bezier(0.77,0,0.18,1)] slide opacity-0">
        <!-- Image with overlay -->
        <div class="absolute inset-0"></div>
        <img src="{{ asset('img/' . $img) }}"
             class="w-full h-full object-cover"
             alt="Event {{ $index + 1 }}" />
        
        <!-- Content -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4">
          <div class="max-w-4xl transform translate-y-10 opacity-0 transition-all duration-700 delay-300 content">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Acara Spesial {{ $index + 1 }}</h1>
            <p class="text-xl md:text-2xl text-white mb-8">Segera Hadir</p>
            <a href="{{ route('event') }}" class="px-8 py-3 bg-white text-gray-900 font-medium rounded-full hover:bg-gray-200 transition-all transform hover:scale-105 inline-block">
              Selengkapnya
            </a>
          </div>
        </div>
      </div>
    @endforeach
    
    <!-- Navigation Arrows -->
    <button class="absolute left-8 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/20 text-white hover:bg-white/30 transition-all prev-btn">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button class="absolute right-8 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/20 text-white hover:bg-white/30 transition-all next-btn">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
    
    <!-- Pagination Dots -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex space-x-2 dots-container">
      @foreach (['event1.jpg', 'event2.jpg', 'event3.jpg'] as $index => $img)
        <button class="w-3 h-3 rounded-full bg-white hover:bg-white transition-all dot" data-index="{{ $index }}"></button>
      @endforeach
    </div>
  </div>
</section>

<style>
  .slide.active {
    opacity: 1;
    z-index: 10;
  }
  
  .slide.active .content {
    opacity: 1;
    transform: translateY(0);
  }
  
  .dot.active {
    background-color: #213448;
    width: 1.5rem;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.slide');
  const dots = document.querySelectorAll('.dot');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  let currentIndex = 0;
  let autoSlideInterval;

  // Initialize slider
  function initSlider() {
    slides[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active');
    startAutoSlide();
  }

  // Show slide
  function showSlide(index) {
    // Reset all slides
    slides.forEach(slide => {
      slide.classList.remove('active');
      slide.querySelector('.content').style.opacity = '0';
      slide.querySelector('.content').style.transform = 'translateY(10px)';
    });
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Update current index
    currentIndex = (index + slides.length) % slides.length;
    
    // Show new slide
    slides[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active');
    
    // Trigger reflow to restart animation
    void slides[currentIndex].offsetWidth;
    
    // Animate content
    setTimeout(() => {
      slides[currentIndex].querySelector('.content').style.opacity = '1';
      slides[currentIndex].querySelector('.content').style.transform = 'translateY(0)';
    }, 50);
  }

  // Auto slide
  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      showSlide(currentIndex + 1);
    }, 5000);
  }

  // Event listeners
  prevBtn.addEventListener('click', () => {
    clearInterval(autoSlideInterval);
    showSlide(currentIndex - 1);
    startAutoSlide();
  });

  nextBtn.addEventListener('click', () => {
    clearInterval(autoSlideInterval);
    showSlide(currentIndex + 1);
    startAutoSlide();
  });

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      clearInterval(autoSlideInterval);
      showSlide(parseInt(dot.dataset.index));
      startAutoSlide();
    });
  });

  // Initialize
  initSlider();
});
</script>