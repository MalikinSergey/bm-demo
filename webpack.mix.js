const mix = require('laravel-mix')
const path = require('path')

mix.disableNotifications();

mix.options({ processCssUrls: false })

mix.webpackConfig({
  watchOptions: {
    aggregateTimeout: 100,
  }
});

mix.version();

mix.ts('resources/js/app.ts', 'website/js').vue({ version: 3 })

mix.alias({
  '@': path.join(__dirname, 'resources/js')
});

mix.stylus('resources/stylus/app.styl', 'website/css')
