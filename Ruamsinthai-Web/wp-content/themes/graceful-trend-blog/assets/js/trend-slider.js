/**
 * Trend Slider JavaScript
 * 
 * Handles Owl Carousel initialization and configuration
 * 
 * Note: This script depends on jQuery and Owl Carousel being loaded by the parent theme.
 * Customizer options are passed via trendSliderOptions global variable.
 * 
 * @package Graceful Trend Blog
 * @since 1.0.0
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Check if trendSliderOptions is available
    if (typeof trendSliderOptions === 'undefined') {
        var trendSliderOptions = {
            showArrows: true,
            showDots: true
        };
    }
    
    // Initialize Owl Carousel with customizer options
    $('.graceful-trend-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: trendSliderOptions.showArrows,
        navText: ['<span class="gracearrow">‹</span>', '<span class="gracearrow">›</span>'],
        dots: trendSliderOptions.showDots,
        smartSpeed: 600,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsive: {
            0: {
                items: 1,
                nav: false, // Always hide arrows on mobile
                dots: trendSliderOptions.showDots
            },
            481: {
                items: 1,
                nav: trendSliderOptions.showArrows,
                dots: trendSliderOptions.showDots
            },
            769: {
                items: 1,
                nav: trendSliderOptions.showArrows,
                dots: trendSliderOptions.showDots
            }
        }
    });
});