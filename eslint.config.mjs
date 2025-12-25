import js from '@eslint/js';
import tseslint from 'typescript-eslint';
import prettier from 'eslint-plugin-prettier';
import parser from '@typescript-eslint/parser';

export default [
	// 1️⃣ Ignore
	{
		ignores: ['node_modules/**', 'vendor/**', 'dist/**', 'build/**'],
	},

	// 2️⃣ App JS / TS
	{
		files: ['**/*.{js,jsx,ts,tsx}'],
		languageOptions: {
			parser,
			parserOptions: {
				ecmaVersion: 'latest',
				sourceType: 'module',
				ecmaFeatures: {
					jsx: true, // enable JSX
				},
			},
		},

		// 🔑 REGISTER PLUGINS HERE
		plugins: {
			prettier,
			'@typescript-eslint': tseslint.plugin,
		},

		rules: {
			// Base JS
			...js.configs.recommended.rules,

			// TS rules
			...tseslint.configs.recommended.rules,

			// Custom
			'prettier/prettier': 'error',
			'no-unused-vars': 'off',
			'@typescript-eslint/no-unused-vars': ['warn'],
		},
	},

	// 3️⃣ Node / config files
	{
		files: ['*.config.js', 'webpack.mix.js'],
		languageOptions: {
			ecmaVersion: 'latest',
			sourceType: 'commonjs',
			globals: {
				module: 'readonly',
				require: 'readonly',
				process: 'readonly',
			},
		},
		rules: {
			'@typescript-eslint/no-require-imports': 'off',
			'no-undef': 'off',
		},
	},
];
