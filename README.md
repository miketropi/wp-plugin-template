# WordPress Plugin Template

A modern, production-ready WordPress plugin template with TypeScript, React, Tailwind CSS, and comprehensive development tools.

## Features

- 🚀 **Modern Stack**: TypeScript, React, Tailwind CSS
- 🎨 **Gutenberg Blocks**: Built-in support for custom Gutenberg blocks
- 🛠️ **Development Tools**: ESLint, Prettier, PHPCS, PHPStan
- 🔄 **Hot Reloading**: BrowserSync and React Refresh for seamless development
- 📦 **Asset Pipeline**: Laravel Mix for optimized builds
- ✅ **Code Quality**: Automated linting and formatting with Git hooks
- 🧪 **Testing**: PHPUnit setup included

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Getting Started](#getting-started)
  - [Step 1: Replace Placeholders](#step-1-replace-placeholders)
  - [Step 2: Installation](#step-2-installation)
- [Development Setup](#development-setup)
- [Project Structure](#project-structure)
- [Building Assets](#building-assets)
- [Code Quality](#code-quality)
- [Testing](#testing)
- [Contributing](#contributing)
- [Troubleshooting](#troubleshooting)
- [Additional Resources](#additional-resources)

## Requirements

- **WordPress**: 6.0 or higher
- **PHP**: 8.2 or higher
- **Node.js**: v20.x or higher
- **Composer**: Latest version

## Getting Started

### Step 1: Replace Placeholders

Before using this template, you need to replace the following placeholders throughout the codebase:

- `__PLUGIN_SLUG__` - Your plugin slug (e.g., `my-awesome-plugin`)
- `__PLUGIN_NAME__` - Your plugin name (e.g., `My Awesome Plugin`)
- `__NAMESPACE__` - Your PHP namespace (e.g., `MyAwesomePlugin`)
- `__TEXT_DOMAIN__` - Your text domain for translations (usually same as slug)
- `__AUTHOR__` - Your name or organization

**Quick Find & Replace:**

1. Search for `__PLUGIN_SLUG__` and replace with your plugin slug
2. Search for `__PLUGIN_NAME__` and replace with your plugin name
3. Search for `__NAMESPACE__` and replace with your namespace (PascalCase, no underscores)
4. Search for `__TEXT_DOMAIN__` and replace with your text domain
5. Search for `__AUTHOR__` and replace with your name

**Files to update:**

- `index.php` - Plugin header
- `package.json` - Package name
- `src/class-plugin.php` - Namespace and class references
- `src/blocks/blocks.php` - Function names
- `webpack.mix.js` - Bundle names
- `tailwind.config.js` - CSS prefix (if needed)
- All PHP files in `src/` directory

### Step 2: Installation

1. Clone or copy this template:

   ```bash
   git clone <repository-url>
   cd your-plugin-name
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install Node.js dependencies:

   ```bash
   npm install
   ```

4. Build assets for production:

   ```bash
   npm run build
   ```

## Development Setup

### Prerequisites

Before starting development, ensure you have:

- A local WordPress development environment
- All dependencies installed (see [Installation](#installation))

### Environment Variables

Create a `.env` file in the plugin root (optional, for BrowserSync):

```env
WP_HOME_URL=http://your-local-site.test
```

### Development Workflow

1. **Start development server with hot reloading:**

   ```bash
   npm run dev
   ```

   This will:
   - Watch for file changes in `assets/` directory
   - Automatically rebuild assets to `dist/` directory
   - Enable BrowserSync for live reloading (if `WP_HOME_URL` is configured)
   - Enable React Refresh for hot reloading of React components

2. **Build Gutenberg blocks:**

   ```bash
   npm run dev:block
   ```

   Or for production:

   ```bash
   npm run build:block
   ```

3. **Build for production:**

   ```bash
   npm run build
   ```

4. **Code quality checks:**

   ```bash
   # Lint and format JavaScript/TypeScript
   npm run lint:js
   npm run format

   # Lint PHP code
   composer lint
   ```

### Git Hooks and Automation

The project uses **Husky** and **lint-staged** for automated code quality checks:

- **Pre-commit hooks**: Automatically run linting and formatting on staged files
- **JavaScript/TypeScript files**: Linted with ESLint and formatted with Prettier
- **PHP files**: Linted with PHPCS using WordPress standards

These hooks are automatically set up when you run `npm install`.

## Project Structure

```
your-plugin-name/
├── assets/                    # Frontend source assets
│   ├── components/           # React components
│   ├── hooks/                # React hooks
│   ├── types/                # TypeScript type definitions
│   ├── script.main.ts        # Main TypeScript entry point
│   └── style.css             # Main stylesheet (Tailwind CSS)
├── build/                     # Gutenberg blocks build output
│   └── blocks/               # Compiled block files
│       └── [block-name]/     # Individual block builds
├── dist/                      # Compiled assets (build output)
│   ├── your-plugin.main.bundle.js    # Compiled JavaScript
│   ├── your-plugin.main.bundle.css   # Compiled CSS
│   └── mix-manifest.json      # Laravel Mix manifest
├── src/                       # PHP source files
│   ├── blocks/               # Gutenberg block source files
│   │   ├── blocks.php       # Block registration
│   │   └── [block-name]/    # Individual block source
│   │       ├── block.json   # Block configuration
│   │       ├── block.jsx    # Block editor component
│   │       ├── render.php   # Block frontend render
│   │       └── style.css    # Block styles
│   └── class-plugin.php      # Main plugin class
├── tests/                     # PHPUnit tests
│   ├── bootstrap.php        # Test bootstrap
│   └── test-sample.php      # Sample test file
├── vendor/                    # Composer dependencies
├── node_modules/              # npm dependencies
├── composer.json              # PHP dependencies configuration
├── package.json               # Node.js dependencies configuration
├── webpack.mix.js             # Laravel Mix configuration
├── tailwind.config.js         # Tailwind CSS configuration
├── eslint.config.mjs         # ESLint configuration (flat config)
├── postcss.config.js         # PostCSS configuration
├── tsconfig.json             # TypeScript configuration
├── phpstan.neon              # PHPStan configuration
├── phpunit.xml.dist          # PHPUnit configuration
└── index.php                 # Main plugin file
```

## Building Assets

### Asset Pipeline

The plugin uses **Laravel Mix** for asset compilation with the following features:

- **TypeScript** → JavaScript (with React support and React Refresh for hot reloading)
- **PostCSS** → CSS (with Tailwind CSS and Autoprefixer)
- **Tailwind CSS**: Configured with custom `__PLUGIN_SLUG__-` prefix to avoid conflicts
- **BrowserSync**: Live reloading for seamless development experience

#### Tailwind CSS Configuration

The plugin uses Tailwind CSS with specific WordPress-friendly settings:

- **Prefix**: All classes use `__PLUGIN_SLUG__-` prefix (e.g., `__PLUGIN_SLUG__-bg-blue-500`)
- **Preflight disabled**: Prevents conflicts with WordPress core styles
- **Content paths**: Watches `assets/`, `src/`, and main plugin file for class usage

### Available Scripts

#### Build Scripts

- `npm run dev` - Build assets in development mode with hot reloading
- `npm run build` - Build assets for production (minified and optimized)
- `npm run dev:block` - Build Gutenberg blocks in development mode
- `npm run build:block` - Build Gutenberg blocks for production

#### Code Quality Scripts

- `npm run lint:js` - Lint JavaScript/TypeScript files with ESLint
- `npm run lint:js:fix` - Auto-fix JavaScript/TypeScript linting issues
- `npm run format` - Format code with Prettier

#### Development Scripts

- `npm run prepare` - Set up git hooks with Husky (runs automatically after npm install)

### Asset Entry Points

- **JavaScript**: `assets/script.main.ts`
- **CSS**: `assets/style.css`

### Output Files

Compiled assets are output to the `dist/` directory:

- `dist/your-plugin.main.bundle.js`
- `dist/your-plugin.main.bundle.css`

The plugin automatically loads these files using the `dist/mix-manifest.json` for cache-busting.

### Gutenberg Blocks

The template includes support for custom Gutenberg blocks:

1. **Create a new block**: Add a new directory in `src/blocks/` (e.g., `src/blocks/my-block/`)
2. **Block structure**:
   - `block.json` - Block configuration
   - `block.jsx` - Block editor component (React)
   - `render.php` - Block frontend render template
   - `style.css` - Block-specific styles (optional)

3. **Build blocks**: Run `npm run dev:block` or `npm run build:block`
4. **Blocks are auto-registered**: The plugin automatically registers all blocks in `build/blocks/`

Example block structure:

```
src/blocks/my-block/
├── block.json
├── block.jsx
├── render.php
└── style.css
```

## Code Quality

### PHP Code Standards

The plugin follows WordPress Coding Standards and uses several tools for code quality:

#### PHPCS (PHP CodeSniffer)

Check code style:

```bash
composer lint:php
```

Auto-fix code style issues:

```bash
composer lint:php:fix
```

#### PHPStan (Static Analysis)

Run static analysis:

```bash
composer lint:phpstan
```

Run all PHP linting checks:

```bash
composer lint
```

### JavaScript/TypeScript Code Standards

The plugin uses modern linting and formatting tools for frontend code:

#### ESLint (JavaScript/TypeScript Linting)

Check JavaScript/TypeScript code style:

```bash
npm run lint:js
```

Auto-fix JavaScript/TypeScript issues:

```bash
npm run lint:js:fix
```

#### Prettier (Code Formatting)

Format all code files:

```bash
npm run format
```

### Configuration Files

#### PHP

- **PHPCS**: Uses WordPress Coding Standards (WPCS)
- **PHPStan**: Configured in `phpstan.neon` (level 5)
- **PHP Compatibility**: Checks for PHP 8.2+ compatibility

#### JavaScript/TypeScript

- **ESLint**: Configured in `eslint.config.mjs` (modern flat config format)
- **Prettier**: Integrated with ESLint for consistent formatting
- **TypeScript**: Configured in `tsconfig.json` with React JSX support and type management
- **Tailwind CSS**: Configured in `tailwind.config.js` with `your-plugin-` prefix (replace with your plugin slug) and WordPress-friendly settings
- **PostCSS**: Configured in `postcss.config.js` with Tailwind and Autoprefixer plugins

### CI/CD

GitHub Actions automatically runs linting on push and pull requests:

- PHPCS code style checks for PHP
- PHPStan static analysis for PHP
- ESLint checks for JavaScript/TypeScript
- Prettier formatting checks

## Testing

### PHPUnit

The plugin includes PHPUnit for PHP testing:

```bash
vendor/bin/phpunit
```

Test files are located in the `tests/` directory.

### Test Configuration

- Configuration: `phpunit.xml.dist`
- Bootstrap: `tests/bootstrap.php`

## Contributing

### Development Guidelines

1. **Follow WordPress Coding Standards** - Use the provided linting tools
2. **Write Tests** - Add tests for new features
3. **Document Code** - Use PHPDoc comments for all functions and classes
4. **Keep Dependencies Updated** - Regularly update Composer and npm dependencies

### Code Style

- PHP: WordPress Coding Standards (enforced via PHPCS)
- JavaScript/TypeScript: Follow React and TypeScript best practices, ESLint enforced
- CSS: Use Tailwind CSS utility classes with `your-plugin-` prefix (replace with your plugin slug), avoid custom CSS when possible
- TypeScript: Configured with React JSX support, modern ES2017+ target, and type checking optimizations

### Pull Request Process

1. Create a feature branch from `main` or `master`
2. Make your changes
3. Ensure all tests pass
4. Run linting tools and fix any issues
5. Submit a pull request with a clear description

## Troubleshooting

### Common Issues

#### TypeScript Type Definition Errors

If you encounter missing type definition errors (e.g., `Cannot find type definition file for 'minimatch'`):

```bash
# Install missing type definitions
npm install @types/[package-name] --save-dev

# Or if TypeScript is being overly strict, you can use skipLibCheck
# This is already enabled in tsconfig.json
```

#### Build Issues

If Laravel Mix compilation fails:

```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Clear Mix cache
rm -rf dist/
npm run build
```

#### BrowserSync Issues

If live reloading doesn't work:

1. Ensure `WP_HOME_URL` is set in your `.env` file
2. Check that your local development URL is accessible
3. Verify that the WordPress site is running

#### Git Hooks Not Working

If pre-commit hooks aren't running:

```bash
# Reinstall Husky hooks
npm run prepare
```

#### Gutenberg Blocks Not Appearing

If your custom blocks aren't showing up in the editor:

1. Ensure blocks are built: `npm run build:block`
2. Check that `build/blocks/` directory exists and contains your block
3. Verify `block.json` is valid JSON
4. Clear WordPress cache and browser cache
5. Check browser console for JavaScript errors

#### Placeholder Replacement Issues

If you're seeing placeholder text in your plugin:

1. Use a find-and-replace tool to search all files
2. Make sure to replace in all file types (PHP, JS, TS, JSON, etc.)
3. Check `package.json`, `composer.json`, and all config files
4. Verify namespace consistency in PHP files

## Additional Resources

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Laravel Mix Documentation](https://laravel-mix.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [TypeScript Documentation](https://www.typescriptlang.org/docs/)
- [React Documentation](https://react.dev/)
- [ESLint Flat Config](https://eslint.org/docs/latest/use/configure/configuration-files-new)
