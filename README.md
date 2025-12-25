# WordPress Plugin Template

A modern, production-ready WordPress plugin template with TypeScript, React, Tailwind CSS, and comprehensive development tools. Built for developers who want a solid foundation with best practices out of the box.

## 🚀 Quick Start

```bash
# 1. Clone the template
git clone <repository-url> your-plugin-name
cd your-plugin-name

# 2. Replace placeholders (see below)
# 3. Install dependencies
composer install && npm install

# 4. Start development
npm run dev
```

## 📋 Table of Contents

- [Architecture](#architecture)
- [Setup & Configuration](#setup--configuration)
- [Development Workflow](#development-workflow)
- [Plugin Architecture](#plugin-architecture)
- [Building Assets](#building-assets)
- [Gutenberg Blocks](#gutenberg-blocks)
- [Code Quality & Standards](#code-quality--standards)
- [Testing](#testing)
- [Extending the Plugin](#extending-the-plugin)
- [Debugging](#debugging)
- [Troubleshooting](#troubleshooting)

## 🏗️ Architecture

### Tech Stack

- **Backend**: PHP 8.2+ with WordPress Coding Standards
- **Frontend**: TypeScript + React 19
- **Styling**: Tailwind CSS with custom prefix
- **Build Tools**: Laravel Mix (Webpack) + WordPress Scripts
- **Code Quality**: ESLint, Prettier, PHPCS, PHPStan
- **Testing**: PHPUnit

### Directory Structure

```
your-plugin-name/
├── assets/                    # Frontend source (TypeScript/React)
│   ├── components/           # React components
│   ├── hooks/                # Custom React hooks
│   ├── types/                # TypeScript definitions
│   ├── script.main.ts        # Main entry point
│   └── style.css             # Tailwind CSS source
├── build/                     # Gutenberg blocks build output
│   └── blocks/               # Compiled block files
├── dist/                      # Compiled frontend assets
│   ├── plugin.main.bundle.js
│   ├── plugin.main.bundle.css
│   └── mix-manifest.json     # Cache-busting manifest
├── src/                       # PHP source files
│   ├── blocks/               # Gutenberg block source
│   │   ├── blocks.php       # Block registration
│   │   └── [block-name]/    # Individual blocks
│   └── class-plugin.php      # Main plugin class
├── tests/                     # PHPUnit tests
├── vendor/                    # Composer dependencies
├── node_modules/              # npm dependencies
└── index.php                  # Plugin bootstrap
```

## ⚙️ Setup & Configuration

### Step 1: Replace Placeholders

The template uses placeholders that must be replaced before use:

| Placeholder       | Description                | Example             |
| ----------------- | -------------------------- | ------------------- |
| `__PLUGIN_SLUG__` | Plugin slug (kebab-case)   | `my-awesome-plugin` |
| `__PLUGIN_NAME__` | Plugin display name        | `My Awesome Plugin` |
| `__NAMESPACE__`   | PHP namespace (PascalCase) | `MyAwesomePlugin`   |
| `__TEXT_DOMAIN__` | Translation text domain    | `my-awesome-plugin` |
| `__AUTHOR__`      | Author name                | `John Doe`          |

**Automated Replacement Script:**

You can automatically update placeholders across the template using the [`agency-wp-cli`](https://github.com/miketropi/agency-wp-cli) tool.

#### Using `agency-wp-cli` via npx

```bash
npx github:miketropi/agency-wp-cli create plugin
```

This interactive CLI will prompt you for:

- **Plugin Slug**: (e.g., `my-awesome-plugin`)
- **Plugin Name**: (e.g., `My Awesome Plugin`)
- **Namespace**: (e.g., `MyAwesomePlugin`)
- **Author**
- **Text Domain** (optional)

It will update all template files, rename PHP namespaces, update block registrations, and configure project metadata.

#### Manual Usage

For advanced usage and options, see [agency-wp-cli documentation](https://github.com/miketropi/agency-wp-cli).

**After running the CLI, review all changed files and commit to version control.**

**Files to Update:**

- `index.php` - Plugin header and constants
- `package.json` - Package name
- `webpack.mix.js` - Bundle names
- `src/class-plugin.php` - Namespace and function names
- `src/blocks/blocks.php` - Function names
- All PHP files in `src/` directory

### Step 2: Install Dependencies

```bash
# PHP dependencies
composer install

# Node.js dependencies
npm install
```

### Step 3: Environment Configuration

Create a `.env` file for BrowserSync (optional):

```env
WP_HOME_URL=http://your-local-site.test
```

## 💻 Development Workflow

### Development Commands

```bash
# Start development with hot reloading
npm run dev              # Watches both assets and blocks
npm run dev:watch        # Watch only Laravel Mix assets
npm run dev:block        # Watch only Gutenberg blocks

# Build for production
npm run build            # Build all assets
npm run build:block      # Build only blocks

# Code quality
npm run lint:js          # Lint JavaScript/TypeScript
npm run lint:js:fix      # Auto-fix JS/TS issues
npm run format           # Format with Prettier
composer lint            # Lint PHP (PHPCS + PHPStan)
composer lint:php        # PHPCS only
composer lint:php:fix    # Auto-fix PHP issues
composer lint:phpstan    # PHPStan static analysis
```

### Development Server

The `npm run dev` command runs both asset watchers concurrently:

- **Laravel Mix**: Watches `assets/` directory, compiles TypeScript/React, processes Tailwind CSS
- **WordPress Scripts**: Watches `src/blocks/` directory, compiles Gutenberg blocks
- **BrowserSync**: Live reloads browser when files change (if `WP_HOME_URL` is set)

### Git Hooks

Pre-commit hooks automatically run:

- ESLint + Prettier on JavaScript/TypeScript files
- PHPCS on PHP files
- Prettier on JSON, CSS, Markdown files

Hooks are set up automatically via Husky when you run `npm install`.

## 🏛️ Plugin Architecture

### Plugin Bootstrap

The plugin follows WordPress best practices with a clean architecture:

```php
// index.php
namespace YourNamespace;

// Constants defined
define( 'YOUR_NAMESPACE_VERSION', '1.0.0' );
define( 'YOUR_NAMESPACE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'YOUR_NAMESPACE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Initialize plugin
$plugin = new \YourNamespace\Plugin();
$plugin->init();
```

### Main Plugin Class

The `Plugin` class handles initialization and hooks:

```php
namespace YourNamespace;

class Plugin {
    public function init() {
        $this->includes();
        $this->init_hooks();
    }

    private function includes() {
        require_once YOUR_NAMESPACE_PLUGIN_DIR . 'src/blocks/blocks.php';
    }

    private function init_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
    }
}
```

### Asset Enqueuing

Assets are automatically enqueued using Laravel Mix's manifest file for cache-busting:

```php
public function enqueue_scripts() {
    $manifest = json_decode(
        file_get_contents( YOUR_NAMESPACE_PLUGIN_DIR . 'dist/mix-manifest.json' ),
        true
    );

    wp_enqueue_script(
        'your-plugin-main',
        YOUR_NAMESPACE_PLUGIN_URL . 'dist' . $manifest['/your-plugin.main.bundle.js'],
        [ 'jquery' ],
        YOUR_NAMESPACE_VERSION,
        true
    );

    // Localize script with data
    wp_localize_script( 'your-plugin-main', 'yourPlugin', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'your-plugin-nonce' ),
    ] );
}
```

### Available Hooks

Extend the plugin using WordPress hooks:

```php
// Modify plugin initialization
do_action( 'your_plugin_init', $plugin_instance );

// Filter asset dependencies
add_filter( 'your_plugin_script_deps', function( $deps ) {
    $deps[] = 'custom-script';
    return $deps;
} );
```

## 📦 Building Assets

### Asset Pipeline

**Laravel Mix** handles frontend asset compilation:

- TypeScript → JavaScript (with React support)
- PostCSS → CSS (Tailwind CSS + Autoprefixer)
- React Refresh for hot module replacement
- Source maps in development
- Minification in production

**Configuration** (`webpack.mix.js`):

```javascript
mix
	.ts('assets/script.main.ts', 'plugin.main.bundle.js')
	.postCss('assets/style.css', 'plugin.main.bundle.css', [
		require('tailwindcss'),
		require('autoprefixer'),
	])
	.react();
```

### Tailwind CSS

Tailwind is configured with a custom prefix to avoid conflicts:

```javascript
// tailwind.config.js
module.exports = {
	prefix: 'your-plugin-',
	content: ['./assets/**/*.{js,jsx,ts,tsx}', './src/**/*.php', './index.php'],
	corePlugins: {
		preflight: false, // Disabled to avoid WordPress conflicts
	},
};
```

**Usage in React:**

```tsx
<div className="your-plugin-bg-blue-500 your-plugin-p-4">Content</div>
```

### TypeScript Configuration

TypeScript is configured for React with modern ES features:

```json
{
	"compilerOptions": {
		"target": "ES2017",
		"module": "ESNext",
		"jsx": "react-jsx",
		"lib": ["ES2017", "DOM", "DOM.Iterable"],
		"moduleResolution": "node",
		"skipLibCheck": true
	}
}
```

### Accessing WordPress Data in TypeScript

The plugin localizes scripts with WordPress data:

```typescript
// TypeScript
declare global {
	interface Window {
		yourPlugin: {
			ajax_url: string;
			nonce: string;
		};
	}
}

// Usage
fetch(window.yourPlugin.ajax_url, {
	method: 'POST',
	headers: {
		'Content-Type': 'application/x-www-form-urlencoded',
	},
	body: new URLSearchParams({
		action: 'your_plugin_action',
		nonce: window.yourPlugin.nonce,
	}),
});
```

## 🎨 Gutenberg Blocks

### Creating a New Block

1. **Create block directory:**

```bash
mkdir -p src/blocks/my-block
```

2. **Create `block.json`:**

```json
{
	"apiVersion": 3,
	"name": "your-plugin/my-block",
	"title": "My Block",
	"category": "widgets",
	"icon": "admin-generic",
	"textdomain": "your-plugin",
	"attributes": {
		"title": {
			"type": "string",
			"default": "Hello World"
		}
	},
	"editorScript": "file:./block.js",
	"style": "file:./style-block.css",
	"render": "file:./render.php"
}
```

3. **Create `block.jsx` (Editor Component):**

```jsx
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import metadata from './block.json';

registerBlockType(metadata.name, {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<RichText
					tagName="h2"
					value={attributes.title}
					onChange={(value) => setAttributes({ title: value })}
					placeholder="Enter title..."
				/>
			</div>
		);
	},
	save: ({ attributes }) => {
		const blockProps = useBlockProps.save();

		return (
			<div {...blockProps}>
				<RichText.Content tagName="h2" value={attributes.title} />
			</div>
		);
	},
});
```

4. **Create `render.php` (Frontend Template):**

```php
<?php
/**
 * Block: My Block
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block default content.
 * @var WP_Block $block      Block instance.
 */

$title = $attributes['title'] ?? 'Hello World';
?>

<div class="wp-block-your-plugin-my-block">
    <h2><?php echo esc_html( $title ); ?></h2>
</div>
```

5. **Build the block:**

```bash
npm run build:block
```

### Block Registration

Blocks are automatically registered from `build/blocks/`:

```php
// src/blocks/blocks.php
function your_plugin_register_blocks() {
    $blocks_dir = YOUR_NAMESPACE_PLUGIN_DIR . 'build/blocks';

    foreach ( glob( $blocks_dir . '/*' ) as $block_dir ) {
        if ( is_dir( $block_dir ) ) {
            register_block_type( $block_dir . '/block.json' );
        }
    }
}
add_action( 'init', 'your_plugin_register_blocks' );
```

### Block Attributes & Supports

Define block capabilities in `block.json`:

```json
{
	"supports": {
		"align": ["wide", "full"],
		"anchor": true,
		"customClassName": false,
		"html": false
	},
	"attributes": {
		"content": {
			"type": "string",
			"source": "html",
			"selector": "p"
		},
		"alignment": {
			"type": "string",
			"default": "none"
		}
	}
}
```

## ✅ Code Quality & Standards

### PHP Standards

**WordPress Coding Standards (WPCS):**

```bash
# Check code style
composer lint:php

# Auto-fix issues
composer lint:php:fix
```

**PHPStan Static Analysis:**

```bash
# Run static analysis (Level 5)
composer lint:phpstan
```

**Configuration:**

- PHPCS: WordPress Coding Standards (WPCS)
- PHPStan: Level 5 with WordPress stubs
- PHP Compatibility: PHP 8.2+

### JavaScript/TypeScript Standards

**ESLint Configuration:**

```javascript
// eslint.config.mjs (flat config)
export default [
	{
		files: ['**/*.{js,jsx,ts,tsx}'],
		languageOptions: {
			parser: typescriptParser,
			parserOptions: {
				ecmaVersion: 'latest',
				sourceType: 'module',
				ecmaFeatures: { jsx: true },
			},
		},
		plugins: {
			react: reactPlugin,
			'@typescript-eslint': typescriptEslint,
		},
		rules: {
			// Custom rules
		},
	},
];
```

**Prettier Integration:**

Prettier is integrated with ESLint for consistent formatting. Format on save is recommended in your editor.

### Pre-commit Hooks

Husky + lint-staged automatically run:

```json
{
	"lint-staged": {
		"*.{js,jsx,ts,tsx}": ["eslint --fix", "prettier --write"],
		"*.php": ["composer lint"]
	}
}
```

## 🧪 Testing

### PHPUnit Setup

```bash
# Run tests
vendor/bin/phpunit

# Run with coverage
vendor/bin/phpunit --coverage-html coverage/
```

**Test Structure:**

```php
// tests/test-sample.php
class Test_Sample extends WP_UnitTestCase {
    public function test_example() {
        $this->assertTrue( true );
    }
}
```

### Writing Tests

```php
class Test_Plugin_Class extends WP_UnitTestCase {
    public function setUp(): void {
        parent::setUp();
        $this->plugin = new \YourNamespace\Plugin();
    }

    public function test_plugin_initializes() {
        $this->plugin->init();
        $this->assertTrue( has_action( 'wp_enqueue_scripts' ) );
    }
}
```

## 🔌 Extending the Plugin

### Adding Custom Functionality

1. **Create a new class:**

```php
// src/class-custom-feature.php
namespace YourNamespace;

class Custom_Feature {
    public function __construct() {
        add_action( 'init', [ $this, 'init' ] );
    }

    public function init() {
        // Your code
    }
}
```

2. **Include in main plugin:**

```php
// src/class-plugin.php
private function includes() {
    require_once YOUR_NAMESPACE_PLUGIN_DIR . 'src/blocks/blocks.php';
    require_once YOUR_NAMESPACE_PLUGIN_DIR . 'src/class-custom-feature.php';
}

private function init_hooks() {
    // ...
    new Custom_Feature();
}
```

### Adding React Components

```tsx
// assets/components/MyComponent.tsx
import React from 'react';

interface MyComponentProps {
	title: string;
}

export const MyComponent: React.FC<MyComponentProps> = ({ title }) => {
	return <div className="your-plugin-container">{title}</div>;
};
```

```typescript
// assets/script.main.ts
import { MyComponent } from './components/MyComponent';
import { createRoot } from 'react-dom/client';

const container = document.getElementById('my-app');
if (container) {
    const root = createRoot(container);
    root.render(<MyComponent title="Hello" />);
}
```

### Custom WordPress Hooks

Add your own hooks for extensibility:

```php
// In your class
do_action( 'your_plugin_before_render', $data );

// In another plugin/theme
add_action( 'your_plugin_before_render', function( $data ) {
    // Modify $data
}, 10, 1 );
```

## 🐛 Debugging

### PHP Debugging

Enable WordPress debug mode:

```php
// wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

### JavaScript Debugging

Source maps are enabled in development:

```javascript
// webpack.mix.js
if (mix.inProduction()) {
	mix.sourceMaps();
}
```

### React DevTools

Install React Developer Tools browser extension for component inspection.

### Browser Console

Access localized data:

```javascript
console.log(window.yourPlugin);
// { ajax_url: "...", nonce: "..." }
```

## 🔧 Troubleshooting

### Build Issues

**Laravel Mix fails to compile:**

```bash
# Clear cache and reinstall
rm -rf node_modules package-lock.json dist/
npm install
npm run build
```

**TypeScript errors:**

```bash
# Check TypeScript config
npx tsc --noEmit

# Install missing types
npm install --save-dev @types/[package-name]
```

### Gutenberg Blocks

**Block not appearing in editor:**

1. Verify block is built: `npm run build:block`
2. Check `build/blocks/[block-name]/block.json` exists
3. Clear browser cache
4. Check browser console for errors
5. Verify block name in `block.json` matches directory

**Block styles not loading:**

- Ensure `style` property is set in `block.json`
- Check that `style-block.css` exists in build directory
- Verify block is registered correctly

### PHP Issues

**PHPStan errors:**

```bash
# Increase memory limit
composer lint:phpstan -- --memory-limit=1G

# Check specific file
vendor/bin/phpstan analyse src/class-plugin.php
```

**PHPCS errors:**

```bash
# Show detailed output
composer lint:php -- -v

# Check specific file
vendor/bin/phpcs src/class-plugin.php
```

### BrowserSync Not Working

1. Verify `.env` file exists with `WP_HOME_URL`
2. Check URL is accessible
3. Ensure WordPress is running
4. Check BrowserSync console for errors

## 📚 Additional Resources

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Gutenberg Block Development](https://developer.wordpress.org/block-editor/)
- [Laravel Mix Documentation](https://laravel-mix.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [React Documentation](https://react.dev/)
- [ESLint Flat Config](https://eslint.org/docs/latest/use/configure/configuration-files-new)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

## 📝 Requirements

- **WordPress**: 6.0+
- **PHP**: 8.2+
- **Node.js**: v20.x+
- **Composer**: Latest

## 📄 License

GPL v2 or later
