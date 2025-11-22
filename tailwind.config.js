/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Livewire/**/*.php",
    ],

    theme: {
    extend: {
        fontFamily: {
<<<<<<< HEAD
            sans: ["Mooli", ...defaultTheme.fontFamily.sans],
            titan: ['Titan One', 'cursive'],                                            
            tegak: ['"Tegak Bersambung_IWK"', 'cursive'],                         
            'cursive-iwk': ['"Tegak Bersambung_IWK"', 'cursive'],
        }        
=======
            sans: [
                "Mooli",
                ...defaultTheme.fontFamily.sans, 
            ],
            'titan': ['Titan One', 'cursive'],
            'cursive-iwk': ['Tegak Bersambung IWK', 'cursive'],
        },
        extend: {
            colors: {
                "iqrain-pink": "#F387A9",
                "iqrain-yellow": "#FFC801",
                "iqrain-blue": "#56B1F3",
                "iqrain-dark-blue": "#234275",
            },
        },
>>>>>>> origin/dev-kay
    },
},
plugins: [],
}
