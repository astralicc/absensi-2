tailwind.config = {
    darkMode: 'class',
};

// Initialize dark mode on page load
if (
    localStorage.getItem('theme') === 'dark' ||
    (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    document.documentElement.classList.add('dark');
}

/* LOADER */
window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 800);
    }
});

// NAVBAR BLUR

const navBar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add(
            'bg-white/70',
            'dark:bg-[#020617]/70',
            'backdrop-blur-xl',
            'shadow-sm',
            'border-b',
            'border-gray-200',
            'dark:border-gray-800',
        );
    } else {
        navbar.classList.remove(
            'bg-white/70',
            'dark:bg-[#020617]/70',
            'backdrop-blur-xl',
            'shadow-sm',
            'border-b',
            'border-gray-200',
            'dark:border-gray-800',
        );
    }
});

/*  HAMBURGER */

const menuBtn = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const navbar = document.getElementById('navbar');

/* toggle mobile */
menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('menu-open');
    mobileMenu.classList.toggle('opacity-0');
    mobileMenu.classList.toggle('-translate-y-5');
    mobileMenu.classList.toggle('pointer-events-none');
});

/* scroll effect */
window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        navbar.classList.add(
            'shadow-md',
            'bg-white/90',
            'dark:bg-[#020617]/90',
        );
    } else {
        navbar.classList.remove(
            'shadow-md',
            'bg-white/90',
            'dark:bg-[#020617]/90',
        );
    }
});

/* DARK MODE */
// Dark mode toggle with smooth animation
function toggleDark() {
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');

    // Add spin animation
    darkIcon.style.transform = 'rotate(360deg) scale(0.8)';
    darkBtn.classList.add(
        'ring-2',
        'ring-blue-400',
        'ring-offset-2',
        'dark:ring-offset-gray-900',
    );

    setTimeout(() => {
        document.documentElement.classList.toggle('dark');

        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            darkIcon.innerHTML = '☀️';
        } else {
            localStorage.setItem('theme', 'light');
            darkIcon.innerHTML = '🌙';
        }

        // Reset animation
        setTimeout(() => {
            darkIcon.style.transform = 'rotate(0deg) scale(1)';
            darkBtn.classList.remove(
                'ring-2',
                'ring-blue-400',
                'ring-offset-2',
                'dark:ring-offset-gray-900',
            );
        }, 250);
    }, 200);
}

// Initialize button state
(function () {
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');
    if (darkBtn && darkIcon) {
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.innerHTML = '☀️';
        } else {
            darkIcon.innerHTML = '🌙';
        }
    }
})();

/* SCROLL REVEAL */
function reveal() {
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length > 0) {
        revealElements.forEach((el) => {
            if (el.getBoundingClientRect().top < window.innerHeight - 100) {
                el.classList.add('active');
            }
        });
    }
}
window.addEventListener('scroll', reveal);
reveal();
// COUNTER
const counterElements = document.querySelectorAll('.counter');

if (counterElements.length > 0) {
    counterElements.forEach((counter) => {
        const rawTarget = counter.dataset.target;
        if (isNaN(rawTarget)) {
            counter.innerText = rawTarget;
            return;
        }

        const target = +rawTarget;
        let count = 0;
        const step = target / 200;

        function update() {
            count += step;
            if (count < target) {
                counter.innerText = Math.ceil(count);
                requestAnimationFrame(update);
            } else {
                counter.innerText = target.toLocaleString();
            }
        }

        setTimeout(update, 1000);
    });
}
/* RIPPLE */
const rippleButtons = document.querySelectorAll('.ripple');
if (rippleButtons.length > 0) {
    rippleButtons.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const circle = document.createElement('span');
            const d = Math.max(btn.clientWidth, btn.clientHeight);
            circle.style.width = circle.style.height = d + 'px';
            circle.style.left = e.offsetX - d / 2 + 'px';
            circle.style.top = e.offsetY - d / 2 + 'px';
            btn.appendChild(circle);
            setTimeout(() => circle.remove(), 600);
        });
    });
}

// DROPDOWN FAQ

const faqBtns = document.querySelectorAll('.faq-btn');

faqBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        const content = btn.nextElementSibling;
        const icon = btn.querySelector('span');

        // 👉 Tutup semua dulu (accordion style)
        document.querySelectorAll('.faq-content').forEach((item) => {
            if (item !== content) item.classList.add('hidden');
        });

        document.querySelectorAll('.faq-btn span').forEach((i) => {
            if (i !== icon) i.classList.remove('rotate-180');
        });

        // 👉 Toggle item yg diklik
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
});

/* ================= SCROLL REVEAL ================= */
const reveals = document.querySelectorAll('.reveal');

const revealOnScroll = () => {
    const windowHeight = window.innerHeight;

    reveals.forEach((el) => {
        const elementTop = el.getBoundingClientRect().top;

        if (elementTop < windowHeight - 80) {
            el.classList.add('active');
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
