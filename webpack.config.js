const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

// Plugin assets building config.
Encore
    .setOutputPath('plugins/system/bpprettify/assets/build')
    .setPublicPath('plugins/system/bpprettify/assets/build/')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning(Encore.isProduction())
    .disableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .configureBabel((config) => {
    }, {
        useBuiltIns: 'usage',
        corejs: 3,
    })
    .autoProvidejQuery()
    .enablePostCssLoader()
    .addExternals({
        jquery: 'jQuery',
        joomla: 'Joomla',
    })
    .addEntry('plugin', [
        // './.dev/scss/plugin.scss',
        './.dev/js/plugin.js'
    ])
    .copyFiles({
        from: './.dev/images',
        to: '[name].[contenthash].[ext]'
    })
    .configureFilenames({
        css: '[name]-[contenthash].css',
        js: '[name]-[contenthash].js'
    });

const PluginConfig = Encore.getWebpackConfig();
PluginConfig.name = 'Plugin';

// Themes assets building config.
Encore
    .setOutputPath('plugins/system/bpprettify/assets/themes')
    .setPublicPath('plugins/system/bpprettify/assets/themes/')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning(Encore.isProduction())
    .disableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .configureBabel((config) => {
    }, {
        useBuiltIns: 'usage',
        corejs: 3,
    })
    .enablePostCssLoader()

    .addStyleEntry('atelier-cave-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-cave-dark.scss',
    ])
    .addStyleEntry('atelier-cave-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-cave-light.scss',
    ])
    .addStyleEntry('atelier-dune-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-dune-dark.scss',
    ])
    .addStyleEntry('atelier-dune-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-dune-light.scss',
    ])
    .addStyleEntry('atelier-estuary-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-estuary-dark.scss',
    ])
    .addStyleEntry('atelier-estuary-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-estuary-light.scss',
    ])
    .addStyleEntry('atelier-forest-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-forest-dark.scss',
    ])
    .addStyleEntry('atelier-forest-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-forest-light.scss',
    ])
    .addStyleEntry('atelier-heath-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-heath-dark.scss',
    ])
    .addStyleEntry('atelier-heath-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-heath-light.scss',
    ])
    .addStyleEntry('atelier-lakeside-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-lakeside-dark.scss',
    ])
    .addStyleEntry('atelier-lakeside-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-lakeside-light.scss',
    ])
    .addStyleEntry('atelier-plateau-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-plateau-dark.scss',
    ])
    .addStyleEntry('atelier-plateau-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-plateau-light.scss',
    ])
    .addStyleEntry('atelier-savanna-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-savanna-dark.scss',
    ])
    .addStyleEntry('atelier-savanna-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-savanna-light.scss',
    ])
    .addStyleEntry('atelier-seaside-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-seaside-dark.scss',
    ])
    .addStyleEntry('atelier-seaside-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-seaside-light.scss',
    ])
    .addStyleEntry('atelier-sulphurpool-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-sulphurpool-dark.scss',
    ])
    .addStyleEntry('atelier-sulphurpool-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/atelier-sulphurpool-light.scss',
    ])
    .addStyleEntry('github', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/github.scss',
    ])
    .addStyleEntry('github-v2', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/github-v2.scss',
    ])
    .addStyleEntry('hemisu-dark', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/hemisu-dark.scss',
    ])
    .addStyleEntry('hemisu-light', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/hemisu-light.scss',
    ])
    .addStyleEntry('tomorrow', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tomorrow.scss',
    ])
    .addStyleEntry('tomorrow-night', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tomorrow-night.scss',
    ])
    .addStyleEntry('tomorrow-night-blue', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tomorrow-night-blue.scss',
    ])
    .addStyleEntry('tomorrow-night-bright', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tomorrow-night-bright.scss',
    ])
    .addStyleEntry('tomorrow-night-eighties', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tomorrow-night-eighties.scss',
    ])
    .addStyleEntry('tranquil-heart', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/tranquil-heart.scss',
    ])
    .addStyleEntry('vibrant-ink', [
        './node_modules/color-themes-for-google-code-prettify/src/themes/vibrant-ink.scss',
    ])

    .configureFilenames({
        css: '[name]-[contenthash].css',
    });

const ThemesConfig = Encore.getWebpackConfig();
ThemesConfig.name = 'Themes';

// Export configurations
module.exports = [PluginConfig, ThemesConfig];
