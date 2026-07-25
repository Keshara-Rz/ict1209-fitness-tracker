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


    /* Form Validation */
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            // Check if form is valid
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.preventDefault(); 
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Futuristic success state
                submitBtn.innerHTML = 'SYSTEM UPDATED <i class="bi bi-check2-circle ms-2"></i>';
                submitBtn.classList.replace('btn-glow-cyan', 'btn-success');
                submitBtn.classList.replace('btn-glow-yellow', 'btn-success');
                submitBtn.style.boxShadow = '0 0 20px rgba(25, 135, 84, 0.6)';

                // Reset after 3 seconds
                setTimeout(() => {
                    form.reset();
                    form.classList.remove('was-validated');
                    submitBtn.innerHTML = originalText;
                    submitBtn.classList.replace('btn-success', originalText.includes('Log') ? 'btn-glow-yellow' : 'btn-glow-cyan');
                    submitBtn.style.boxShadow = '';
                }, 3000);
            }
            
            form.classList.add('was-validated');
        }, false);
    });


    /* Authentication Routing & Memory (Login/Signup Logic) */
    
    // Check Login State for the "Get Started" Button on the Home Page
    const getStartedBtn = document.getElementById('getStartedBtn');
    if (getStartedBtn) {
        // If the browser remembers the user is logged in, change the button's destination
        if (localStorage.getItem('fitpulse_logged_in') === 'true') {
            getStartedBtn.href = 'dashboard.html';
            getStartedBtn.innerHTML = 'Go To Dashboard <i class="bi bi-arrow-right ms-2"></i>';
        }
    }

    // 2. Handle Login Form Submission
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop standard form submission
            if (this.checkValidity()) {
                // Save "logged in" state to browser memory
                localStorage.setItem('fitpulse_logged_in', 'true'); 
                // Redirect user to the dashboard
                window.location.href = 'dashboard.html'; 
            }
        });
    }

    // 3. Handle Sign Up Form Submission
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            if (this.checkValidity()) {
                // Save "logged in" state to browser memory
                localStorage.setItem('fitpulse_logged_in', 'true'); 
                // Redirect user to the dashboard
                window.location.href = 'dashboard.html'; 
            }
        });
    }

    /* Smooth Page Exit Transition */
document.addEventListener("DOMContentLoaded", () => {
    // Find every link on the page
    const allLinks = document.querySelectorAll('a[href]');

    allLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetUrl = this.getAttribute('href');

            if (this.target === '_blank' || targetUrl.startsWith('#')) {
                return;
            }

            // Stop the link from loading instantly
            e.preventDefault();

            // Add the fade-out CSS class to the body
            document.body.classList.add('page-exit');

            // Wait 400 milliseconds then load the new page
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 400);
        });
    });
});

    
});


