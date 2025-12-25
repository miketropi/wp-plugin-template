module.exports = {
	corePlugins: {
		preflight: false,
	},
	content: [
		'./assets/**/*.{ts,tsx,js,jsx}',
		'./index.php',
		'./src/**/*.php',
		'./src/blocks/**/*.{ts,tsx,js,php}',
	],
	prefix: '__PLUGIN_SLUG__-',
	theme: {
		extend: {},
	},
	plugins: [],
};
