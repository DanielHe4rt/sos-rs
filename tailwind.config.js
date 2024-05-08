const defaultTheme = require('tailwindcss/defaultTheme')
import preset from './vendor/filament/support/tailwind.config.preset'

module.exports = {
    presets: [preset],

    // theme: {
    //     extend: {
    //         fontFamily: {
    //             sans: ['Inter var', ...defaultTheme.fontFamily.sans],
    //         },
    //     },
    // },

    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },

    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.php',
        './vendor/filament/**/*.blade.php',

        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
