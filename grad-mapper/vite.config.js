import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  base: '/grad-mapper/',   // Important for GitHub Pages if repo name is grad-mapper
});