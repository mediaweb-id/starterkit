<script setup>
import { ref ,nextTick,onMounted } from 'vue'
let props  = defineProps({
    page: Object,
});

</script>

<template>
    <Master>
        <section v-for="(section, index) in page.sections" :key="index">
        <keep-alive>
            <component
            :is="section.type"
            :data="section.data"
            v-if="section.show"
            ></component>
        </keep-alive>
        </section>
    </Master>
</template>
