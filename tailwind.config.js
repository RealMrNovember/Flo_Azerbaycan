export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Livewire/**/*.php',
        './app/Filament/**/*.php',
        './app/View/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                flo: {
                    orange: {
                        50: '#fff2e9',
                        100: '#ffe1d0',
                        200: '#ffc1a1',
                        300: '#ff9a66',
                        400: '#ff7e3d',
                        500: '#ff6a00',
                        600: '#e85f00',
                        700: '#c94f00',
                        800: '#a64100',
                        900: '#7a3000',
                    },
                    blue: {
                        50: '#eef5ff',
                        100: '#dbeaff',
                        200: '#b8d6ff',
                        300: '#89bbff',
                        400: '#5b9cff',
                        500: '#2f79ff',
                        600: '#1e5fe0',
                        700: '#184bb3',
                        800: '#143e91',
                        900: '#0f2b63',
                    },
                    ink: '#0b0f1a',
                    slate: '#0f172a',
                },
                glass: {
                    DEFAULT: 'rgba(255, 255, 255, 0.08)',
                    strong: 'rgba(255, 255, 255, 0.12)',
                    border: 'rgba(255, 255, 255, 0.18)',
                },
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                serif: ['"Playfair Display"', 'ui-serif', 'Georgia', 'serif'],
            },
            boxShadow: {
                'soft-xl': '0 20px 60px -30px rgba(2, 6, 23, 0.55)',
                glass: '0 10px 35px -20px rgba(2, 6, 23, 0.65)',
                'glass-inset': 'inset 0 1px 0 rgba(255, 255, 255, 0.18)',
            },
            backdropBlur: {
                xs: '2px',
                '2xl': '30px',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-6px)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '0% 50%' },
                    '100%': { backgroundPosition: '100% 50%' },
                },
            },
            animation: {
                float: 'float 6s ease-in-out infinite',
                shimmer: 'shimmer 10s ease-in-out infinite',
            },
        },
    },
    plugins: [],
};
