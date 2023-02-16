module.exports = {
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
          },
        extend: {
            colors: {
                'primary': 'var(--color-primary)',
                'body': 'var(--color-body)',
                'hovercolor': 'var(--color-hover)',
            },
            fontFamily: {
                TimesNewRoman: ["Times New Roman", 'serif'],


            },

        },

    },
    plugins: [],
}