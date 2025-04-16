document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuBtn && mobileMenu) {
        // Toggle mobile menu
        menuBtn.addEventListener('click', function() {
            const isOpen = mobileMenu.getAttribute('data-open') === 'true';
            mobileMenu.setAttribute('data-open', !isOpen);
            
            if (!isOpen) {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Close menu when clicking close button
        const closeBtn = document.querySelector('.close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenu.setAttribute('data-open', 'false');
                document.body.style.overflow = 'auto';
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!menuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenu.setAttribute('data-open', 'false');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
                entry.target.classList.add('visible');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const counterData = [
            { selector: '#unesco-counter', value: 9 },
            { selector: '#ethnic-counter', value: 80 },
            { selector: '#history-counter', value: 3000 }
        ];
    
        const animateCounter = (element, targetValue) => {
            const duration = 2000; // Duration of the animation in milliseconds
            const startTime = performance.now();
            const initialValue = 0;
    
            const updateCounter = (currentTime) => {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1);
                const currentValue = Math.floor(initialValue + (targetValue - initialValue) * progress);
    
                element.textContent = currentValue;
    
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = targetValue + '+'; // Add '+' after reaching the target value
                }
            };
    
            requestAnimationFrame(updateCounter);
        };
    
        counterData.forEach(counter => {
            const element = document.querySelector(counter.selector);
            animateCounter(element, counter.value);
        });
    });
// Simple search function for packages
function searchPackages() {
    // Get input values
    var search = document.getElementById('searchInput').value;
    var date = document.getElementById('dateInput').value;
    var travelers = document.getElementById('travelersInput').value;

    // Change button text to show loading
    var button = document.querySelector('.bg-amber-600');
    button.innerHTML = 'Searching...';

    // Redirect to packages page with search parameters
    window.location.href = 'packages.php?search=' + search + '&date=' + date + '&travelers=' + travelers;
}});