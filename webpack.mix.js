const mix = require('laravel-mix');
const defaultSassOptions = {
    processCssUrls: false,
    postCss: [
        require('autoprefixer')({
            browsers: [
                "> 1%",
                "last 40 versions",
                "IE 10"
            ],
            cascade: false
        })
    ]
};

if (!mix.inProduction()) {
    mix.webpackConfig({
            devtool: 'source-map'
        })
        .sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/admin/main.scss', 'public/css/admin').options(defaultSassOptions)
    .sass('resources/assets/frontend/scss/app.scss', 'public/assets/frontend/css').options(defaultSassOptions)
    .sass('resources/assets/public-website/scss/stylesheet.scss', 'public/frontend/css').options(defaultSassOptions)

mix.scripts([
    'resources/themes/codebase/js/core/jquery.min.js',
    'resources/themes/codebase/js/core/bootstrap.bundle.min.js',
    'resources/themes/codebase/js/core/jquery.slimscroll.min.js',
    'resources/themes/codebase/js/core/jquery-scrollLock.min.js',
    'resources/themes/codebase/js/core/jquery.appear.min.js',
    'resources/themes/codebase/js/core/jquery.countTo.min.js',
    'resources/themes/codebase/js/core/js.cookie.min.js',
    'resources/themes/codebase/js/codebase.js'
], 'public/themes/codebase/core.js');

mix.scripts([
    'resources/themes/codebase/js/core/jquery.slimscroll.min.js',
    'resources/themes/codebase/js/plugins/sweetalert2/sweetalert2.all.min.js'
], 'public/assets/frontend/js/core.js');

mix.js('resources/assets/frontend/js/app.js', 'public/assets/frontend/js/');
mix.js('resources/assets/frontend/js/owl-carousel.js', 'public/assets/frontend/js/');
mix.js('resources/js/manager/team_lineup/index.js', 'public/js/manager/team_lineup');
mix.js('resources/js/manager/lonauction/index.js', 'public/js/manager/lonauction');
mix.js('resources/js/manager/realtime.js', 'public/js/manager');
// mix.js('resources/js/manager/chat/index.js', 'public/js/manager/chat');
// mix.js('resources/js/manager/custom_cup/index.js', 'public/js/manager/custom_cup');
mix.js('resources/assets/public-website/js/app.js', 'public/frontend/js/');

mix.copyDirectory('resources/themes/codebase/js/plugins', 'public/themes/codebase/js/plugins');
mix.copyDirectory('resources/themes/codebase/fonts', 'public/themes/codebase/fonts');
mix.copyDirectory('resources/js/plugins', 'public/js/plugins');
mix.copyDirectory('node_modules/@fortawesome/fontawesome-pro/webfonts', 'public/assets/frontend/webfonts');
mix.copyDirectory('node_modules/fitty', 'public/js/plugins/fitty');
mix.copyDirectory('node_modules/malihu-custom-scrollbar-plugin', 'public/js/plugins/scrollbar-plugin');
// mix.copyDirectory('node_modules/@fortawesome/fontawesome-pro/js', 'public/assets/frontend/js/plugins');

mix.browserSync({
    proxy: 'fantasyleague.test',
    notify: false
});
