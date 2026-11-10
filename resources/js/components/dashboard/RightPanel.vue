<script setup>
import Icon from './Icon.vue';
defineProps({ siteName: { type: String, default: '' }, live: { type: Object, default: () => ({}) }, people: { type: Array, default: () => [] }, creator: { type: Object, default: () => ({}) }, followed: { type: Array, default: () => [] } });
const emit = defineEmits(['preview', 'follow']);
</script>
<template>
    <aside class="right-column" aria-label="Live updates and creators">
        <section id="live" class="rail-section live-section"><header class="rail-heading"><h2><span class="live-label">LIVE</span> Live Now</h2><a v-if="live.url" :href="live.url" class="see-all">See All <Icon name="arrow-right" /></a></header>
            <template v-if="live.title"><button type="button" class="live-cover" :aria-label="`Preview ${live.title}`" @click="emit('preview', live)"><img :src="live.image" :alt="live.title" loading="lazy" /></button><h3>{{ live.title }}</h3><p v-if="live.viewers">{{ live.viewers }} watching</p></template>
            <p v-else class="empty-state">No live streams.</p>
        </section>
        <section id="people" class="rail-section people-section"><header class="rail-heading"><h2>Suggested People</h2></header>
            <div v-if="people.length" class="people-list"><article v-for="(item,index) in people" :key="item.id || index" class="person searchable-card"><img :src="item.avatar" :alt="item.name" loading="lazy" /><div class="person-copy"><h3>{{ item.name }}</h3><p>{{ item.role }}</p></div><button type="button" class="follow-button" :class="{ 'is-following': followed.includes(item.id) }" :aria-pressed="followed.includes(item.id)" @click="emit('follow', item)">{{ followed.includes(item.id) ? 'Following' : 'Follow' }}</button></article></div>
            <p v-else class="empty-state">No suggested people.</p>
        </section>
        <section class="creator-promo"><div class="creator-title"><img class="creator-logo" src="/assets/logo/logo-white.png" :alt="siteName" width="146" height="34" /></div><p>{{ creator.description || 'Explore opportunities for creators and businesses.' }}</p><a :href="creator.url || '#jobs'" class="white-pill">{{ creator.button || 'Explore' }} <Icon name="arrow-right" /></a><div class="promo-graph" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><svg viewBox="0 0 130 105" preserveAspectRatio="none"><path d="M4 92 L34 70 L53 78 L79 37 L100 46 L125 4" fill="none" stroke="#5cd8ff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M114 8 L125 4 L122 16" fill="none" stroke="#8febff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></div></section>
    </aside>
</template>
