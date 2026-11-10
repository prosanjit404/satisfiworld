<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
defineProps({ featured: { type: Object, default: () => ({}) }, videos: { type: Array, default: () => [] } });
const emit = defineEmits(['preview']);
const expanded = ref(false);
</script>
<template>
    <section id="featured" class="widget featured-widget" :class="{ 'is-expanded': expanded }" aria-labelledby="featuredTitle">
        <header class="widget-header"><h2 id="featuredTitle"><Icon name="play-circle" class="purple-text" /> Featured Video</h2><button v-if="videos.length > 3" class="see-all" type="button" :aria-expanded="expanded" @click="expanded = !expanded">{{ expanded ? 'Show Less' : 'See All' }} <Icon :name="expanded ? 'arrow-up' : 'arrow-right'" /></button></header>
        <div v-if="featured.title" class="featured-layout">
            <button type="button" class="featured-cover" :aria-label="`Preview ${featured.title}`" @click="emit('preview', featured)">
                <img :src="featured.image" :alt="featured.title" loading="lazy" />
                <span class="play-bubble"><Icon name="play" /></span><span class="featured-caption"><strong>{{ featured.title }}</strong><small>{{ featured.category }} · {{ featured.views }} views <template v-if="featured.when">· {{ featured.when }}</template></small></span><span v-if="featured.duration" class="video-duration">{{ featured.duration }}</span>
            </button>
            <div class="featured-side"><button v-for="(item,index) in videos" :key="item.id || index" type="button" class="small-video searchable-card" :class="{ 'extra-card': index >= 3 }" @click="emit('preview', item)"><img :src="item.image" :alt="item.title" loading="lazy" /><span><strong>{{ item.title }}</strong><small>{{ item.category }} · {{ item.views }} views</small></span></button></div>
        </div>
        <p v-else class="empty-state">No featured video available.</p>
    </section>
</template>
