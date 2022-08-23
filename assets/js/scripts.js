(function() {
  'use strict';

  /**
   * Adjust other elements when navbar is fixed top.
   */
  if (
    document.querySelector('body:not(.home) .navbar.fixed-top') ||
    document.querySelector('.navbar.fixed-top:not(.navbar-transparent)')
  ) {
    const navbar = document.getElementsByClassName('navbar')[0];
    const mainElement = document.getElementsByTagName('main')[0];

    ['load', 'resize'].forEach(function(event) {
      window.addEventListener(event, function() {
        const height = navbar.offsetHeight;
        mainElement.style.marginTop = height + 'px';
      });
    });
  }

  /**
   * Adjust other elements when navbar is transparent. Only apply on home page.
   */
  if (document.querySelector('.navbar.navbar-transparent')) {
    
    if (document.querySelector('.navbar:not(.fixed-top)')) {
      const mainElement = document.getElementsByTagName('main')[0];

      ['load', 'resize'].forEach(function(event) {
        window.addEventListener(event, function() {
          const height = document.getElementsByClassName('navbar')[0].offsetHeight;
  
          if (window.innerWidth >= 992) {
            mainElement.style.marginTop = -height + 'px';
          }
          else if (! document.querySelector('.navbar.fixed-top')) {
            mainElement.style.marginTop = 0;
          }
        });
      });
    }

    // Only transparent when it's on top.
    window.addEventListener('scroll', function() {
      const navbar = document.getElementsByClassName('navbar')[0];

      if (window.scrollY > 100) {
        navbar.classList.add('navbar-shrink');
      } else {
        navbar.classList.remove('navbar-shrink');
      }
    });
  }

  /**
   * Prevent dropdown menu to collape on click inside
   */
  const dropdownSubMenu = document.querySelectorAll('.navbar .dropdown-menu .menu-item-has-children');
  dropdownSubMenu.forEach(function(element) {
    element.addEventListener('click', function(event) {
      event.stopPropagation();
    });
  });

  /**
   * Scroll to top smooth scrolling
   */
  const scrollToTop = function() {
    const to        = 0; // To top
    const duration  = 800;
    const element   = document.scrollingElement || document.documentElement;
    const start     = element.scrollTop;
    const change    = to - start;
    const startDate = +new Date();
    
    // t = current time
    // b = start value
    // c = change in value
    // d = duration
    const easeInOutQuad = function(t, b, c, d) {
      t /= d/2;
      if (t < 1) return c/2*t*t + b;
      t--;
      return -c/2 * (t*(t-2) - 1) + b;
    }
    
    const animateScroll = function() {
      const currentDate = +new Date();
      const currentTime = currentDate - startDate;
      element.scrollTop = parseInt(easeInOutQuad(currentTime, start, change, duration));
      if (currentTime < duration) {
        requestAnimationFrame(animateScroll);
      } else {
        element.scrollTop = to;
      }
    };
    animateScroll();
  };

  const toTopButton = document.getElementsByClassName('to-top-btn')[0];

  toTopButton.addEventListener('click', scrollToTop);

  ['load', 'scroll'].forEach(function(event) {
    window.addEventListener(event, function() {
      if (window.scrollY > 200) {
        toTopButton.classList.add('show-btn');
        toTopButton.style.right = 25 + 'px';
      } else {
        toTopButton.classList.remove('show-btn');
        toTopButton.style.right = `${ -(toTopButton.offsetWidth + 25) }px`;
      }
    });
  });

  /**
   * Initialize slider for banner section.
   */
  if (document.getElementById('wing-banner')) {
    const splide = new Splide('#banner-slider', {
      speed: 500,
      height: 700
    }).mount();

    const heroTitle = document.querySelector('#wing-banner .banner-title').innerText;
    document.getElementById('hero-title').innerHTML = heroTitle;

    const slideCount = splide.Components.Slides.getLength(true);
    if (slideCount === 1) {
      splide.options = {
        arrows: false,
        pagination: false
      };
    }
  }

  /**
   * Initialize slider for testimonial section.
   */
  if (document.getElementById('wing-testimonial')) {
    const slider = document.getElementById('testimonial-slider');
    const columnCount = slider.getAttribute('data-column');

    const splide = new Splide('#testimonial-slider', {
      speed: 500,
      gap: '1.5rem',
      perPage: columnCount,
      pagination: false,
      breakpoints: {
        767.98: { perPage: 1 },
        // Force 1-column if user wants it to be 1-column
        991.98: { perPage: (columnCount == 1) ? 1 : 2 }
      }
    }).mount();

    const slideCount = splide.Components.Slides.getLength(true);
    if (slideCount == columnCount) {
      splide.options = { arrows: false };
    }
  }
})();