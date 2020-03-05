const extendColors = {
    "grey-light": "#F5F6F9",
    "grey": "rgba(0,0,0,0.4)",
    "blue": "#47cdff",
    "blue-light": "#8ae2fe"
};

const colors = {
    'default': 'var(--text-default-color)',
    'accent': 'var(--text-accent-color)',
    'accent-light': 'var(--text-accent-light-color)',
    'muted': 'var(--text-muted-color)',
    'muted-light': 'var(--text-muted-light-color)',
    'error': 'var(--text-error-color)',
};

const backgroundColor = {
    page: 'var(--page-background-color)',
    button: 'var(--button-background-color)',
    card: 'var(--card-background-color)',
    header: 'var(--header-background-color)',
    error: 'var(--error-background-color)',
};

module.exports = {
    theme: {
        extend: {
            colors: extendColors
        },
        colors: colors,
        backgroundColor: backgroundColor,
    },
    variants: {},
    plugins: [],
};

