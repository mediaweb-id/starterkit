// plugins/registerComponents.ts
import { defineAsyncComponent, App } from 'vue'

export default {
  install(app: App) {
    const components = import.meta.glob('@vendor/acitjazz/*.vue')

        console.log('components[path]',components);
    for (const path in components) {
      // Ambil nama file dan jadikan sebagai nama komponen
      const match = path.match(/\/([^/]+)\.vue$/)
      if (match) {
        const name = match[1]
        console.log('components[path]',components[path]);
        app.component(name, defineAsyncComponent(components[path]))
      }
    }
  }
}
