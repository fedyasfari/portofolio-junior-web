import js from '@eslint/js';

export default [
  { ignores: ['node_modules/**'] },
  js.configs.recommended,
  {
    files: ['js/**/*.js', 'tests/**/*.js', 'scripts/**/*.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        document: 'readonly',
        window: 'readonly',
        localStorage: 'readonly',
        console: 'readonly',
        URL: 'readonly',
      },
    },
    rules: {
      eqeqeq: 'error',
      'no-var': 'error',
      'prefer-const': 'warn',
      'no-unused-vars': 'error',
    },
  },
];
