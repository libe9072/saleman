const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

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

Mix.listen('configReady', config => {
  const scssRule = config.module.rules.find(r => r.test.toString() === /\.scss$/.toString())
  const scssOptions = scssRule.loaders.find(l => l.loader === 'sass-loader').options
  scssOptions.data = '@import "./resources/sass/styles.scss";'

  const sassRule = config.module.rules.find(r => r.test.toString() === /\.sass$/.toString())
  const sassOptions = sassRule.loaders.find(l => l.loader === 'sass-loader').options
  sassOptions.data = '@import "./resources/sass/styles.scss"'
})
mix.browserSync({
  proxy: {
    // artisan serve시의 주소
    target: 'localhost:8000',
    reqHeaders: function() {
      // host를 직접 지정해준다.
      return {
        host: 'localhost:3000'
      };
    }
  }
});
mix
  .options({
    extractVueStyles: true,
  })
  .webpackConfig({
    plugins: [new VuetifyLoaderPlugin()]
  })
  .js('resources/js/app.js', 'public/js').version()
  .sass('resources/sass/app.scss', 'public/css').version();
mix.copyDirectory('resources/img', 'public/img').version();
