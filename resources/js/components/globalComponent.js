import { defineAsyncComponent } from "vue"
import { Head, Link } from "@inertiajs/vue3"
import { Draggable } from "@he-tree/vue"
import Master from "@/layouts/frontend/Master.vue"
import AppLayout from "@/layouts/AppLayout.vue"

const components = {
 // Static,
 // These components are used frequently across many pages,
 // so we import them statically to avoid any initial render delay.
  Master,
  AppLayout,
  Draggable,
  Head,
  Link,
  // Async
  // These components are loaded asynchronously to reduce the initial bundle size.
  // They will be loaded only when needed, improving performance on first load.

  TextInput: () => import("@/components/Forms/TextInput.vue"),
  AcitJazzUpload: () => import("@/components/Forms/AcitJazzUpload.vue"),
  TinyEditor: () => import("@/components/Forms/TinyEditor.vue"),
  InputSlug: () => import("@/components/Forms/InputSlug.vue"),
  InputSelect: () => import("@/components/Forms/InputSelect.vue"),
  InputLabel: () => import("@/components/Forms/InputLabel.vue"),
  InputError: () => import("@/components/Forms/InputError.vue"),
  TextAreaInput: () => import("@/components/Forms/TextAreaInput.vue"),
  InputColor: () => import("@/components/Forms/InputColor.vue"),
  InputNavigation: () => import("@/components/Forms/InputNavigation.vue"),
  Th: () => import("@/components/Table/Th.vue"),
  Td: () => import("@/components/Table/Td.vue"),
  SecondaryLink: () => import("@/components/Buttons/SecondaryLink.vue"),
  SecondaryButton: () => import("@/components/Buttons/SecondaryButton.vue"),
  PrimaryButton: () => import("@/components/Buttons/PrimaryButton.vue"),
  APrimaryButton: () => import("@/components/Buttons/APrimaryButton.vue"),
  AOutlineButton: () => import("@/components/Buttons/AOutlineButton.vue"),
  Badge: () => import("@/components/Buttons/Badge.vue"),
  Pagination: () => import("@/components/Buttons/Pagination.vue"),
  SpinnerLoader: () => import("@/components/Loaders/SpinnerLoader.vue"),
}

export default {
  install(app) {
    for (const [name, loader] of Object.entries(components)) {
      const component = typeof loader === "function" ? defineAsyncComponent(loader) : loader
      app.component(name, component)
    }
  }
}
