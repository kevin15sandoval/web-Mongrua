/**
 * Main JavaScript for Formación y Enseñanza Mogruas
 * 
 * @package Mongruas
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const navMenu = $('.nav-menu');

        menuToggle.on('click', function() {
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !isExpanded);
            navMenu.toggleClass('active');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation').length) {
                menuToggle.attr('aria-expanded', 'false');
                navMenu.removeClass('active');
            }
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });
    }

    /**
     * Track CTA Button Clicks
     */
    function initCTATracking() {
        $('.btn, .cta-button').on('click', function() {
            const ctaText = $(this).text().trim();
            const ctaLocation = $(this).closest('section').attr('id') || 'unknown';

            if (typeof mongruasAjax !== 'undefined') {
                $.ajax({
                    url: mongruasAjax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'mongruas_track_cta',
                        nonce: mongruasAjax.nonce,
                        cta_text: ctaText,
                        cta_location: ctaLocation
                    }
                });
            }

            // Fire Google Analytics event if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cta_click', {
                    'event_category': 'engagement',
                    'event_label': ctaText,
                    'value': ctaLocation
                });
            }

            // Fire Facebook Pixel event if available
            if (typeof fbq !== 'undefined') {
                fbq('track', 'Lead', {
                    content_name: ctaText
                });
            }
        });
    }

    /**
     * Lazy Load Images
     */
    function initLazyLoad() {
        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
            });
        } else {
            // Fallback for browsers that don't support native lazy loading
            const lazyImages = document.querySelectorAll('img[data-src]');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        }
    }

    /**
     * Sticky Header on Scroll
     */
    function initStickyHeader() {
        const header = $('.site-header');
        let lastScroll = 0;

        $(window).on('scroll', function() {
            const currentScroll = $(this).scrollTop();

            if (currentScroll > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }

            lastScroll = currentScroll;
        });
    }

    /**
     * Counter Animation for Statistics
     */
    function initCounterAnimation() {
        const counters = $('.stat-number');
        
        if (counters.length && 'IntersectionObserver' in window) {
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-target'));
                        const duration = 2000;
                        const increment = target / (duration / 16);
                        let current = 0;

                        const updateCounter = () => {
                            current += increment;
                            if (current < target) {
                                counter.textContent = Math.floor(current);
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target;
                            }
                        };

                        updateCounter();
                        counterObserver.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            counters.each(function() {
                counterObserver.observe(this);
            });
        }
    }

    /**
     * FAQ Accordion
     */
    function initFAQAccordion() {
        $('.faq-question').on('click', function() {
            const faqItem = $(this).parent();
            const faqAnswer = faqItem.find('.faq-answer');
            const isActive = faqItem.hasClass('active');

            // Close all other FAQ items
            $('.faq-item').removeClass('active');
            $('.faq-answer').slideUp(300);

            // Toggle current item
            if (!isActive) {
                faqItem.addClass('active');
                faqAnswer.slideDown(300);
            }
        });
    }

    /**
     * Initialize all functions on document ready
     */
    $(document).ready(function() {
        initMobileMenu();
        initSmoothScroll();
        initCTATracking();
        initLazyLoad();
        initStickyHeader();
        initCounterAnimation();
        initFAQAccordion();
    });

})(jQuery);


    /**
     * Testimonials Carousel
     */
    function initTestimonialsCarousel() {
        const carousel = $('.testimonials-carousel');
        if (!carousel.length) return;

        const items = carousel.find('.testimonial-item');
        const dotsContainer = carousel.find('.carousel-dots');
        let currentIndex = 0;
        let autoplayInterval;

        // Create dots
        items.each(function(index) {
            const dot = $('<button>')
                .addClass('carousel-dot')
                .attr('aria-label', 'Go to testimonial ' + (index + 1))
                .on('click', function() {
                    showTestimonial(index);
                });
            if (index === 0) dot.addClass('active');
            dotsContainer.append(dot);
        });

        function showTestimonial(index) {
            items.hide().eq(index).fadeIn(300);
            $('.carousel-dot').removeClass('active').eq(index).addClass('active');
            currentIndex = index;
        }

        // Navigation buttons
        carousel.find('.carousel-nav.prev').on('click', function() {
            const newIndex = (currentIndex - 1 + items.length) % items.length;
            showTestimonial(newIndex);
            resetAutoplay();
        });

        carousel.find('.carousel-nav.next').on('click', function() {
            const newIndex = (currentIndex + 1) % items.length;
            showTestimonial(newIndex);
            resetAutoplay();
        });

        // Autoplay
        function startAutoplay() {
            autoplayInterval = setInterval(function() {
                const newIndex = (currentIndex + 1) % items.length;
                showTestimonial(newIndex);
            }, 5000);
        }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        startAutoplay();

        // Pause on hover
        carousel.on('mouseenter', function() {
            clearInterval(autoplayInterval);
        }).on('mouseleave', function() {
            startAutoplay();
        });
    }

    // Add to document ready
    $(document).ready(function() {
        // ... existing code ...
        initTestimonialsCarousel();
    });
