import { nodeResolve } from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import terser from '@rollup/plugin-terser';

const isProduction = process.env.NODE_ENV === 'production';

export default [
  // Bundle principal
  {
    input: 'src/js/main.js',
    output: {
      file: 'assets/js/main.js',
      format: 'iife',
      name: 'CommuneTheme',
      sourcemap: !isProduction
    },
    plugins: [
      nodeResolve({ browser: true }),
      commonjs(),
      ...(isProduction ? [terser()] : [])
    ]
  },
  // Bundle admin séparé
  {
    input: 'src/js/admin.js',
    output: {
      file: 'assets/js/admin.js',
      format: 'iife',
      name: 'CommuneAdmin',
      sourcemap: !isProduction
    },
    plugins: [
      nodeResolve({ browser: true }),
      commonjs(),
      ...(isProduction ? [terser()] : [])
    ]
  },
  // Composants modulaires
  {
    input: 'src/js/components/index.js',
    output: {
      file: 'assets/js/components.js',
      format: 'iife',
      name: 'CommuneComponents',
      sourcemap: !isProduction
    },
    plugins: [
      nodeResolve({ browser: true }),
      commonjs(),
      ...(isProduction ? [terser()] : [])
    ]
  }
];