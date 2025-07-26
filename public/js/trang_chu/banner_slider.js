class ResponsiveSlider {
    constructor(selector = '.main-slider') {
        this.slider = document.querySelector(selector);
        if (!this.slider) {
            console.error('Slider element not found');
            return;
        }
        
        this.container = this.slider.querySelector('.slide-container');
        this.slides = this.slider.querySelectorAll('.slide');
        this.prevBtn = this.slider.querySelector('.prev');
        this.nextBtn = this.slider.querySelector('.next');
        this.dotsContainer = this.slider.querySelector('.pagination-dots');
        
        // State
        this.totalSlides = this.slides.length;
        this.realSlidesCount = this.totalSlides - 2;
        this.currentIndex = 1;
        this.slideWidth = 0;
        this.isTransitioning = false;
        this.autoSlideInterval = null;
        
        // Enhanced touch/drag handling
        this.isDragging = false;
        this.startX = 0;
        this.startY = 0;
        this.currentX = 0;
        this.currentY = 0;
        this.dragOffset = 0;
        this.startTime = 0;
        this.baseTranslateX = 0;
        this.dragThreshold = 50;
        this.velocityThreshold = 0.5;
        this.maxDragDistance = 0;
        
        // Configuration
        this.config = {
            transitionDuration: 400,
            autoSlideDelay: 4000,
            dragResistance: 0.8,
            snapBackDuration: 300,
            quickSwipeThreshold: 200,
            minSwipeDistance: 30
        };
        
        this.init();
    }
    
    init() {
        try {
            this.setupSlider();
            this.createPaginationDots();
            this.bindEvents();
            this.updateDots();
            this.startAutoSlide();
        } catch (error) {
            console.error('Error initializing slider:', error);
        }
    }
    
    setupSlider() {
        this.calculateDimensions();
        this.baseTranslateX = -this.currentIndex * this.slideWidth;
        this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
        this.container.style.transition = `transform ${this.config.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
    }
    
    calculateDimensions() {
        this.slideWidth = this.slider.offsetWidth;
        this.maxDragDistance = this.slideWidth * 0.8;
    }
    
    createPaginationDots() {
        if (!this.dotsContainer) return;
        
        this.dotsContainer.innerHTML = '';
        
        for (let i = 0; i < this.realSlidesCount; i++) {
            const dot = document.createElement('button');
            dot.className = 'dot';
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.setAttribute('role', 'tab');
            dot.dataset.slideIndex = i + 1;
            
            dot.addEventListener('click', (e) => {
                e.preventDefault();
                if (!this.isTransitioning && !this.isDragging) {
                    this.goToSlide(parseInt(dot.dataset.slideIndex));
                }
            });
            
            this.dotsContainer.appendChild(dot);
        }
    }
    
    updateDots() {
        if (!this.dotsContainer) return;
        
        const dots = this.dotsContainer.querySelectorAll('.dot');
        dots.forEach(dot => {
            dot.classList.remove('active');
            dot.setAttribute('aria-selected', 'false');
        });
        
        let activeDotIndex = this.getRealSlideIndex() - 1;
        
        if (dots[activeDotIndex]) {
            dots[activeDotIndex].classList.add('active');
            dots[activeDotIndex].setAttribute('aria-selected', 'true');
        }
    }
    
    getRealSlideIndex() {
        if (this.currentIndex === 0) {
            return this.realSlidesCount;
        } else if (this.currentIndex === this.totalSlides - 1) {
            return 1;
        } else {
            return this.currentIndex;
        }
    }
    
    goToSlide(index) {
        if (this.isTransitioning || this.isDragging) return;
        
        this.currentIndex = index;
        this.animateToSlide();
        this.updateDots();
        this.resetAutoSlide();
    }
    
    animateToSlide() {
        this.isTransitioning = true;
        this.baseTranslateX = -this.currentIndex * this.slideWidth;
        
        this.container.style.transition = `transform ${this.config.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
        this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
        
        setTimeout(() => {
            this.handleInfiniteScroll();
            this.isTransitioning = false;
        }, this.config.transitionDuration);
    }
    
    moveSlide(direction) {
        if (this.isTransitioning || this.isDragging) return;
        
        if (direction === 'next') {
            this.currentIndex++;
        } else {
            this.currentIndex--;
        }
        
        this.animateToSlide();
        this.updateDots();
        this.resetAutoSlide();
    }
    
    handleInfiniteScroll() {
        if (this.currentIndex === this.totalSlides - 1) {
            this.container.style.transition = 'none';
            this.currentIndex = 1;
            this.baseTranslateX = -this.currentIndex * this.slideWidth;
            this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
            this.restoreTransition();
            this.updateDots();
        } else if (this.currentIndex === 0) {
            this.container.style.transition = 'none';
            this.currentIndex = this.realSlidesCount;
            this.baseTranslateX = -this.currentIndex * this.slideWidth;
            this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
            this.restoreTransition();
            this.updateDots();
        }
    }
    
    restoreTransition() {
        requestAnimationFrame(() => {
            this.container.style.transition = `transform ${this.config.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
        });
    }
    
    bindEvents() {
        // Navigation buttons
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.moveSlide('prev');
            });
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.moveSlide('next');
            });
        }
        
        // Auto-slide controls
        this.slider.addEventListener('mouseenter', () => this.pauseAutoSlide());
        this.slider.addEventListener('mouseleave', () => {
            if (!this.isDragging) this.startAutoSlide();
        });
        
        // Enhanced touch events
        this.setupTouchEvents();
        
        // Enhanced mouse events
        this.setupMouseEvents();
        
        // Keyboard events
        this.setupKeyboardEvents();
        
        // Window resize
        window.addEventListener('resize', () => this.handleResize());
        
        // Visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseAutoSlide();
            } else if (!this.isDragging) {
                this.startAutoSlide();
            }
        });
    }
    
    setupTouchEvents() {
        this.slider.addEventListener('touchstart', (e) => {
            this.startDrag(e.touches[0].clientX, e.touches[0].clientY);
        }, { passive: true });
        
        this.slider.addEventListener('touchmove', (e) => {
            if (this.isDragging) {
                e.preventDefault();
                this.updateDrag(e.touches[0].clientX, e.touches[0].clientY);
            }
        }, { passive: false });
        
        this.slider.addEventListener('touchend', (e) => {
            if (this.isDragging) {
                this.endDrag();
            }
        }, { passive: true });
    }
    
    setupMouseEvents() {
        this.slider.addEventListener('mousedown', (e) => {
            e.preventDefault();
            this.startDrag(e.clientX, e.clientY);
            this.slider.classList.add('dragging');
        });
        
        document.addEventListener('mousemove', (e) => {
            if (this.isDragging) {
                e.preventDefault();
                this.updateDrag(e.clientX, e.clientY);
            }
        });
        
        document.addEventListener('mouseup', () => {
            if (this.isDragging) {
                this.endDrag();
                this.slider.classList.remove('dragging');
            }
        });
        
        this.slider.addEventListener('mouseleave', () => {
            if (this.isDragging) {
                this.endDrag();
                this.slider.classList.remove('dragging');
            }
        });
    }
    
    startDrag(x, y) {
        if (this.isTransitioning) return;
        
        this.isDragging = true;
        this.startX = x;
        this.startY = y;
        this.startTime = Date.now();
        this.dragOffset = 0;
        
        // Remove transition for smooth dragging
        this.container.style.transition = 'none';
        this.pauseAutoSlide();
        
        console.log('🎯 Drag started');
    }
    
    updateDrag(x, y) {
        if (!this.isDragging) return;
        
        const deltaX = x - this.startX;
        const deltaY = y - this.startY;
        
        // Check if this is a horizontal drag
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            this.dragOffset = deltaX * this.config.dragResistance;
            
            // Limit drag distance
            const maxDrag = this.maxDragDistance;
            if (Math.abs(this.dragOffset) > maxDrag) {
                this.dragOffset = this.dragOffset > 0 ? maxDrag : -maxDrag;
            }
            
            // Apply real-time transform
            const newTranslateX = this.baseTranslateX + this.dragOffset;
            this.container.style.transform = `translateX(${newTranslateX}px)`;
            
            console.log('↔️ Dragging:', {
                offset: this.dragOffset,
                translateX: newTranslateX
            });
        }
    }
    
    endDrag() {
        if (!this.isDragging) return;
        
        this.isDragging = false;
        const dragTime = Date.now() - this.startTime;
        const dragDistance = Math.abs(this.dragOffset);
        const dragVelocity = dragDistance / dragTime;
        
        console.log('✋ Drag ended:', {
            distance: dragDistance,
            time: dragTime,
            velocity: dragVelocity
        });
        
        // Restore transition
        this.container.style.transition = `transform ${this.config.snapBackDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
        
        // Determine if we should change slide
        const shouldChangeSlide = 
            dragDistance > this.config.minSwipeDistance && 
            (dragDistance > this.dragThreshold || 
             (dragVelocity > this.velocityThreshold && dragTime < this.config.quickSwipeThreshold));
        
        if (shouldChangeSlide) {
            if (this.dragOffset > 0) {
                // Dragged right -> go to previous
                this.currentIndex--;
                console.log('⬅️ Slide to previous');
            } else {
                // Dragged left -> go to next
                this.currentIndex++;
                console.log('➡️ Slide to next');
            }
            
            this.baseTranslateX = -this.currentIndex * this.slideWidth;
            this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
            
            this.updateDots();
            
            // Handle infinite scroll after transition
            setTimeout(() => {
                this.handleInfiniteScroll();
            }, this.config.snapBackDuration);
            
        } else {
            // Snap back to current slide
            this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
            console.log('↩️ Snap back to current slide');
        }
        
        this.resetAutoSlide();
    }
    
    setupKeyboardEvents() {
        this.slider.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.moveSlide('prev');
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.moveSlide('next');
            }
        });
    }
    
    handleResize() {
        const newSlideWidth = this.slider.offsetWidth;
        
        if (newSlideWidth !== this.slideWidth) {
            this.slideWidth = newSlideWidth;
            this.maxDragDistance = this.slideWidth * 0.8;
            this.baseTranslateX = -this.currentIndex * this.slideWidth;
            this.container.style.transition = 'none';
            this.container.style.transform = `translateX(${this.baseTranslateX}px)`;
            this.restoreTransition();
        }
    }
    
    startAutoSlide() {
        if (this.isDragging) return;
        this.pauseAutoSlide();
        this.autoSlideInterval = setInterval(() => {
            if (!this.isDragging) {
                this.moveSlide('next');
            }
        }, this.config.autoSlideDelay);
    }
    
    pauseAutoSlide() {
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
            this.autoSlideInterval = null;
        }
    }
    
    resetAutoSlide() {
        setTimeout(() => {
            if (!this.isDragging) {
                this.startAutoSlide();
            }
        }, 1000);
    }
    
    // Public methods
    destroy() {
        this.pauseAutoSlide();
        window.removeEventListener('resize', this.handleResize);
    }
    
    goToNext() {
        this.moveSlide('next');
    }
    
    goToPrev() {
        this.moveSlide('prev');
    }
    
    getCurrentSlide() {
        return this.getRealSlideIndex();
    }
}

// Initialize slider when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const slider = new ResponsiveSlider('.main-slider');
    window.slider = slider;
    
    console.log('🚀 Enhanced Touch Slider Initialized');
    console.log('📱 Touch Support:', 'ontouchstart' in window ? 'Yes' : 'No');
    
    // Handle intersection observer for performance
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    slider.startAutoSlide();
                } else {
                    slider.pauseAutoSlide();
                }
            });
        });
        
        observer.observe(slider.slider);
    }
    
    // Debug functions
    window.testSlider = {
        next: () => slider.goToNext(),
        prev: () => slider.goToPrev(),
        goTo: (index) => slider.goToSlide(index),
        current: () => slider.getCurrentSlide()
    };
});