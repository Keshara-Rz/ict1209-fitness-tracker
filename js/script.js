document.addEventListener("DOMContentLoaded", () => {
    
    /* Custom Animations: Scroll Reveal using Intersection Observer */
    const elementsToAnimate = document.querySelectorAll('.glass-card, .glass-panel, .stat-item, .icon-box');
    
    elementsToAnimate.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    });

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                setTimeout(() => {
                    entry.target.style.transform = '';
                    entry.target.style.transition = '';
                }, 800);

                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    elementsToAnimate.forEach(el => scrollObserver.observe(el));


    /* Smoothness & Effects */
    const navbar = document.querySelector('.glass-nav');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(1, 3, 8, 0.95)';
            navbar.style.borderBottom = '1px solid rgba(0, 210, 255, 0.3)';
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
        } else {
            navbar.style.background = 'rgba(3, 7, 18, 0.7)';
            navbar.style.borderBottom = '1px solid rgba(0, 210, 255, 0.15)';
            navbar.style.boxShadow = 'none';
        }
    });


    /* Form Validation (Updated for PHP Backend) */
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            // Check if form is missing any required fields
            if (!form.checkValidity()) {
                event.preventDefault(); // Stop submission only if INVALID
                event.stopPropagation();
            } 
            // If the form IS valid, we do nothing and let the standard PHP POST request take over!
            
            form.classList.add('was-validated');
        }, false);
    });

    /* Authentication Routing - Home Page "Get Started" Button */
    const getStartedBtn = document.getElementById('getStartedBtn');
    if (getStartedBtn) {
        // Simple UI check (Actual security is now handled by PHP Session Lock in dashboard.php)
        if (localStorage.getItem('fitpulse_logged_in') === 'true') {
            getStartedBtn.href = 'dashboard.php';
            getStartedBtn.innerHTML = 'Go To Dashboard <i class="bi bi-arrow-right ms-2"></i>';
        }
    } 

});