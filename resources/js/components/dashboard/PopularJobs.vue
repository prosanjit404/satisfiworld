<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
defineProps({ items: { type: Array, default: () => [] } });
const emit = defineEmits(['details']);
const expanded = ref(false);
</script>
<template>
    <section id="jobs" class="widget jobs-widget" :class="{ 'is-expanded': expanded }" aria-labelledby="jobsTitle">
        <header class="widget-header"><h2 id="jobsTitle"><Icon name="briefcase" class="purple-text" /> Popular Jobs</h2><button v-if="items.length > 5" type="button" class="see-all" :aria-expanded="expanded" @click="expanded = !expanded">{{ expanded ? 'Show Less' : 'See All' }} <Icon :name="expanded ? 'arrow-up' : 'arrow-right'" /></button></header>
        <div v-if="items.length" id="popular-jobs" class="jobs-list"><component :is="item.url ? 'a' : 'button'" v-for="(item,index) in items" :key="item.id || index" class="job-card searchable-card" :href="item.url || undefined" :type="item.url ? undefined : 'button'" :class="{ 'extra-card': index >= 5 }" @click="!item.url && emit('details', item)"><img :src="item.image" :alt="item.title" loading="lazy" /><span>{{ item.title }}</span></component></div>
        <p v-else class="empty-state">No jobs available.</p>
        <div v-if="expanded && items.length" class="jobs-more"><p>Browse opportunities based on your interests and skills.</p><a href="#popular-jobs" class="gradient-button">Browse Jobs</a></div>
    </section>
</template>
