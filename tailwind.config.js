/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './app/Http/Controllers/**/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                cairo: ['Cairo', 'sans-serif'],
            },
            colors: {
                brand: {
                    50: '#F8FAFC',
                    100: '#E5E7EB',
                    200: '#C8D0D8',
                    500: '#3B82F6',
                    600: '#1F2A36',
                    700: '#101820',
                },
                whatsapp: {
                    500: '#25D366',
                },
            },
        },
    },
    plugins: [],
};
