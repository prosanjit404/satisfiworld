<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
defineProps({ items: { type: Array, default: () => [] } });
const emit = defineEmits(['preview']);
const expanded = ref(false);
</script>
<template>
    <section id="trending" class="widget trending-widget" :class="{ 'is-expanded': expanded }" aria-labelledby="trendingTitle">
        <header class="widget-header"><h2 id="trendingTitle"><Icon name="star" class="pink-text" /> Trending Now</h2><button v-if="items.length > 5" class="see-all" type="button" :aria-expanded="expanded" @click="expanded = !expanded">{{ expanded ? 'Show Less' : 'See All' }} <Icon :name="expanded ? 'arrow-up' : 'arrow-right'" /></button></header>
        <div v-if="items.length" class="trending-list content-list">
            <article v-for="(item,index) in items" :key="item.id || index" class="trending-card searchable-card" :class="{ 'extra-card': index >= 5 }">
                <button class="image-button" type="button" :aria-label="`Preview ${item.title}`" @click="emit('preview', item)"><img :src="item.image" :alt="item.title" loading="lazy" /></button>
                <h3>{{ item.title }}</h3><a href="#trending">{{ item.tag || '#trending' }}</a><p><Icon name="eye" /> {{ item.views || '—' }} views</p>
            </article>
        </div>
        <p v-else class="empty-state">No trending content available.</p>
    </section>
</template>
