document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    // Counter animation logic and other utilities will go here.
    // (Mobile menu logic is now handled in includes/header.php for enhanced transitions)

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

    const counterData = [
        { selector: '#unesco-counter', value: 9 },
        { selector: '#ethnic-counter', value: 80 },
        { selector: '#history-counter', value: 3000 }
    ];

    const animateCounter = (element, targetValue) => {
        if (!element) return;
        const duration = 2000;
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
                element.textContent = targetValue + '+';
            }
        };

        requestAnimationFrame(updateCounter);
    };

    counterData.forEach(counter => {
        const element = document.querySelector(counter.selector);
        if (element) animateCounter(element, counter.value);
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