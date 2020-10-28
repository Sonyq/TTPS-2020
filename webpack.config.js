const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const Dotenv = require('dotenv-webpack');

if(Encore.isProduction()){
    Encore.setPublicPath('/build')
}else{
    Encore.setPublicPath('/build')
}

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    .setManifestKeyPrefix('build')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')

    .addPlugin(new CopyWebpackPlugin([
        // copies to {output}/images
        { from: './assets/img', to: 'images' }
    ]))

    .addPlugin(new Dotenv())

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .addRule(
        {
            test: /\.s(c|a)ss$/,
            use: [
              'vue-style-loader',
              {
                loader: 'css-loader',
                options: {
                  modules: { localIdentName: '[path][name]__[local]--[hash:base64:5]' }
                }
              },
              {
                loader: 'sass-loader',
                // Requires sass-loader@^7.0.0
                options: {
                  implementation: require('sass'),
                  indentedSyntax: true // optional
                },
                // Requires sass-loader@^8.0.0
                options: {
                  implementation: require('sass'),
                  sassOptions: {
                    indentedSyntax: true // optional
                  },
                },
              },
            ],
          },
    )

    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()

    .enableSingleRuntimeChunk()

    // allow sass/scss files to be processed
    // .enableSassLoader()

    .enableVueLoader()

    ;

// export the final configuration
var config = Encore.getWebpackConfig();
//config.node = { fs: 'empty' };
module.exports = config;