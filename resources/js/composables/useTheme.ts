// composables/useTheme.ts
import { ref, watch, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import type { Ref } from 'vue'

interface PageProps {
  theme_name?: string
}

// Load semua file CSS tema (main-menu.css, header.css, footer.css, dll)
const themeStyles = import.meta.glob('@themes/**/**.css')

function resolveCssPath(theme: string, file: string): string {
  return `/resources/css/themes/${theme}/${file}.css` // Cocokkan key-nya dengan hasil glob
}

export function useTheme(files: string[] = ['main-menu']): void {
  const page = usePage<{ props: PageProps }>()
  const theme: Ref<string> = ref(page.props.theme_name || 'default')
  const loadCssFiles = async () => {
    for (const file of files) {
      const themePath = resolveCssPath(theme.value, file)
      const fallbackPath = resolveCssPath('default', file)

      if (themeStyles[themePath]) {
        await themeStyles[themePath]()
      } else if (themeStyles[fallbackPath]) {
        console.warn(`Theme "${theme.value}" missing "${file}.css", falling back to default.`)
        await themeStyles[fallbackPath]()
      } else {
        console.warn(`"${file}.css" not found in theme "${theme.value}" or "default"`)
      }
    }
  }

  onMounted(loadCssFiles)

  watch(() => page.props.theme_name, async (newTheme) => {
    theme.value = newTheme || 'default'
    await loadCssFiles()
  })
}
