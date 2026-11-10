<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
const props = defineProps({ siteName: { type: String, default: '' }, links: { type: Array, default: () => [] }, hashtags: { type: Array, default: () => [] }, open: { type: Boolean, default: false } });
const emit = defineEmits(['close', 'search']);
const selected = ref('Home');
function visit(link) { selected.value = link.title; emit('close'); }
</script>
<template>
    <div class="sidebar-backdrop" :class="{ 'is-visible': open }" aria-hidden="true" @click="emit('close')"></div>
    <aside class="sidebar" :class="{ 'is-open': open }" aria-label="Sidebar">
        <nav class="main-navigation" aria-label="Main navigation">
            <a v-for="link in links" :key="link.title" :href="link.url || '#top'" class="sidebar-link" :class="{ active: selected === link.title }" @click="visit(link)"><Icon :name="link.icon || 'circle'" /><span>{{ link.title }}</span></a>
        </nav>
        <div class="sidebar-promo"><div class="sidebar-promo-heading"><span aria-hidden="true">✦</span><strong>Explore {{ siteName }}</strong></div><p>Discover content, browse opportunities and find something new.</p><a class="white-pill" href="#jobs" @click="emit('close')">Explore Jobs</a></div>
        <section class="hashtags" id="more"><h2>Trending Hashtags</h2><div class="hashtag-list"><button v-for="tag in hashtags" :key="tag" type="button" @click="emit('search', tag.replace('#','').trim()); emit('close')">{{ tag }}</button></div></section>
    </aside>
</template>
