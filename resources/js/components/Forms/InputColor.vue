<script setup>
import { ref } from 'vue';

const props = defineProps({
  modelValue: String
});
const emit = defineEmits(['update:modelValue']);

const colors = [
    'white',
    'gray-100', 'gray-200', 'gray-300', 'gray-400', 'gray-500', 'gray-600', 'gray-700', 'gray-800', 'gray-900',
    'black',
    'red-500', 'red-600', 'red-700',
    'orange-400', 'orange-500', 'orange-600',
    'amber-300', 'amber-400', 'amber-500',
    'yellow-300', 'yellow-400', 'yellow-500',
    'lime-400', 'lime-500',
    'green-400', 'green-500', 'green-600',
    'emerald-400', 'emerald-500', 'emerald-600',
    'teal-400', 'teal-500',
    'cyan-400', 'cyan-500',
    'blue-400', 'blue-500', 'blue-600',
    'indigo-400', 'indigo-500', 'indigo-600',
    'violet-400', 'violet-500', 'violet-600',
    'purple-400', 'purple-500', 'purple-600',
    'fuchsia-400', 'fuchsia-500',
    'pink-400', 'pink-500',
    'rose-400', 'rose-500',
    'slate-500', 'zinc-500', 'neutral-500', 'stone-500',
];

const isOpen = ref(false);
const selectColor = (color) => {
  emit('update:modelValue', color);
  isOpen.value = false;
};
</script>

<template>
  <div class="relative w-60">
    <!-- Button -->
    <button
      @click="isOpen = !isOpen"
      class="w-full py-2 px-3 border border-gray-300 rounded-md flex items-center justify-between"
    >
      <div class="flex items-center gap-2">
        <span
          class="w-5 h-5 rounded-full border"
          :class="'bg-' + modelValue"
        ></span>
        <span class="capitalize">{{ modelValue }}</span>
      </div>
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <!-- Dropdown -->
    <div
      v-if="isOpen"
      class="absolute z-10 mt-1 bg-white border border-gray-300 rounded-md shadow w-full max-h-64 overflow-y-auto"
    >
      <div
        v-for="color in colors"
        :key="color"
        class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 cursor-pointer"
        @click="selectColor(color)"
      >
        <span class="w-5 h-5 rounded-full border" :class="'bg-' + color"></span>
        <span class="capitalize">{{ color }}</span>
      </div>
    </div>
  </div>
</template>
