 tailwind.config = {
            darkMode: 'class',
        };
        
        // Initialize dark mode immediately to prevent flash
        (function() {
            const theme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (!theme && systemDark)) {
                document.documentElement.classList.add('dark');
            }
        })();