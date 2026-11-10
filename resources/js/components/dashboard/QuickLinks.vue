<script setup>
import Icon from './Icon.vue';
defineProps({ siteName: { type: String, default: '' }, links: { type: Array, default: () => [] } });
const emit = defineEmits(['more']);
</script>
<template>
    <nav class="quick-links" :aria-label="`Explore ${siteName}`">
        <a v-for="(link,index) in links" :key="index" :href="link.url || '#top'" class="quick-link"><span class="quick-icon" :class="link.color || 'blue'"><Icon :name="link.icon || 'circle'" /></span><strong><span class="desktop-label">{{ link.title }}</span><span class="mobile-label">{{ link.mobile_title || link.title }}</span></strong><small>{{ link.subtitle }}</small></a>
        <button class="quick-link quick-more mobile-only" type="button" aria-label="More categories" @click="emit('more')"><span class="quick-icon slate"><Icon name="dots" /></span><strong>More</strong></button>
    </nav>
</template>
