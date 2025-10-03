const autoprefixer = require('autoprefixer');
const tailwindcss = require('tailwindcss');
const postcssImport = require('postcss-import');
const postcssNested = require('postcss-nested');
const postcssCustomProperties = require('postcss-custom-properties');
const postcssCustomMedia = require('postcss-custom-media');
const postcssMixins = require('postcss-mixins');
const cssnano = require('cssnano');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
  plugins: [
    postcssImport({
      path: ['src/css', 'src/components']
    }),
    postcssMixins({
      mixinsFiles: 'src/css/mixins/*.css'
    }),
    postcssCustomMedia(),
    postcssCustomProperties({
      preserve: false
    }),
    postcssNested(),
    tailwindcss('./tailwind.config.js'),
    autoprefixer(),
    ...(isProduction ? [
      cssnano({
        preset: ['default', {
          discardComments: { removeAll: true },
          normalizeWhitespace: true,
          minifySelectors: true
        }]
      })
    ] : [])
  ]
};