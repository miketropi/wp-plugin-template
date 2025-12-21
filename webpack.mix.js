const mix = require('laravel-mix');

mix.setPublicPath('dist');

mix
  .ts('assets/script.main.ts', '__PLUGIN_SLUG__.main.bundle.js')
  .postCss('assets/style.css', '__PLUGIN_SLUG__.main.bundle.css', [
    require('tailwindcss'),
    require('autoprefixer'),
  ])
  .react()
  .browserSync({
    proxy: process.env.WP_HOME_URL || '',
    files: ['dist/*.js', 'dist/*.css', '**/*.php'],
    watchOptions: {
      ignored: [/mix-manifest\.json$/],
    },
  });

mix.options({
  processCssUrls: false,
});
