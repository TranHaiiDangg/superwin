// Flash Deals Slider Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.querySelector('.flash-deals-slider .slider-track');
    const prevBtn = document.getElementById('flashDealsPrev');
    const nextBtn = document.getElementById('flashDealsNext');
    
    if (!sliderTrack) return;
    
    let currentPosition = 0;
    const itemWidth = 300; // Width of each deal item including gap
    const visibleItems = Math.floor(sliderTrack.parentElement.offsetWidth / itemWidth);
    const totalItems = sliderTrack.children.length;
    const maxPosition = Math.max(0, totalItems - visibleItems);
    
    // Initialize slider
    updateSlider();
    
    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentPosition = Math.max(0, currentPosition - 1);
            updateSlider();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentPosition = Math.min(maxPosition, currentPosition + 1);
            updateSlider();
        });
    }
    
    function updateSlider() {
        const translateX = -currentPosition * itemWidth;
        sliderTrack.style.transform = `translateX(${translateX}px)`;
        
        // Update button states
        if (prevBtn) {
            prevBtn.style.opacity = currentPosition === 0 ? '0.5' : '1';
            prevBtn.style.pointerEvents = currentPosition === 0 ? 'none' : 'auto';
        }
        
        if (nextBtn) {
            nextBtn.style.opacity = currentPosition >= maxPosition ? '0.5' : '1';
            nextBtn.style.pointerEvents = currentPosition >= maxPosition ? 'none' : 'auto';
        }
    }
    
    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    sliderTrack.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });
    
    sliderTrack.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next
                currentPosition = Math.min(maxPosition, currentPosition + 1);
            } else {
                // Swipe right - previous
                currentPosition = Math.max(0, currentPosition - 1);
            }
            updateSlider();
        }
    }
    
    // Auto-scroll functionality
    let autoScrollInterval;
    
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            if (currentPosition >= maxPosition) {
                currentPosition = 0;
            } else {
                currentPosition++;
            }
            updateSlider();
        }, 60000); // Auto-scroll every 1 minute
    }
    
    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }
    
    // Start auto-scroll
    startAutoScroll();
    
    // Pause auto-scroll on hover
    sliderTrack.addEventListener('mouseenter', stopAutoScroll);
    sliderTrack.addEventListener('mouseleave', startAutoScroll);
    
    // Countdown Timer Functionality
    const hoursElement = document.querySelector('.hours');
    const minutesElement = document.querySelector('.minutes');
    const secondsElement = document.querySelector('.seconds');
    
    if (hoursElement && minutesElement && secondsElement) {
        // Set countdown time (6 hours 50 minutes from now)
        let totalSeconds = 6 * 3600 + 50 * 60; // 6 hours 50 minutes
        
        function updateCountdown() {
            if (totalSeconds <= 0) {
                // Reset countdown when it reaches zero
                totalSeconds = 6 * 3600 + 50 * 60;
            }
            
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
            
            totalSeconds--;
        }
        
        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
    
    // Responsive handling
    function handleResize() {
        const newVisibleItems = Math.floor(sliderTrack.parentElement.offsetWidth / itemWidth);
        const newMaxPosition = Math.max(0, totalItems - newVisibleItems);
        
        if (currentPosition > newMaxPosition) {
            currentPosition = newMaxPosition;
            updateSlider();
        }
    }
    
    window.addEventListener('resize', handleResize);
});
