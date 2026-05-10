document.addEventListener('DOMContentLoaded', function() {
    // === Custom Cursor (Subtle) ===
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor hidden md:block';
    document.body.appendChild(cursor);

    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    const animateCursor = () => {
        cursorX += (mouseX - cursorX) * 0.15;
        cursorY += (mouseY - cursorY) * 0.15;
        cursor.style.left = cursorX + 'px';
        cursor.style.top = cursorY + 'px';
        requestAnimationFrame(animateCursor);
    };
    animateCursor();

    const interactiveElements = document.querySelectorAll('a, button, .editorial-card');
    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
    });

    // === Scroll Progress ===
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    }, { passive: true });

    // === Intersection Observer ===
    const revealOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                if (entry.target.hasAttribute('data-counter')) {
                    const targetValue = parseInt(entry.target.getAttribute('data-counter'));
                    animateCounter(entry.target, targetValue);
                }
            }
        });
    }, revealOptions);

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, [data-counter]').forEach(el => {
        revealObserver.observe(el);
    });

    const animateCounter = (element, targetValue) => {
        if (!element || element.classList.contains('counted')) return;
        element.classList.add('counted');
        
        const duration = 2000;
        const startTime = performance.now();

        const updateCounter = (currentTime) => {
            const elapsedTime = currentTime - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            const easeProgress = 1 - Math.pow(1 - progress, 4);
            const currentValue = Math.floor(targetValue * easeProgress);

            element.textContent = currentValue.toLocaleString() + (targetValue >= 1000 ? '+' : (targetValue >= 9 ? '+' : ''));

            if (progress < 1) requestAnimationFrame(updateCounter);
            else element.textContent = targetValue.toLocaleString() + (targetValue >= 9 ? '+' : '');
        };
        requestAnimationFrame(updateCounter);
    };

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        });
    });
});

function searchPackages() {
    var search = document.getElementById('searchInput').value;
    var date = document.getElementById('dateInput').value;
    var travelers = document.getElementById('travelersInput').value;
    var button = document.querySelector('.bg-amber-600') || document.querySelector('.btn-champagne');
    if(button) button.innerHTML = 'Searching...';
    window.location.href = 'packages.php?search=' + search + '&date=' + date + '&travelers=' + travelers;
}