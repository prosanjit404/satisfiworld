<script setup>
import Icon from './Icon.vue';
defineProps({ siteName: { type: String, default: '' }, hero: { type: Object, default: () => ({}) }, steps: { type: Array, default: () => [] } });
const emit = defineEmits(['preview']);
</script>
<template>
    <section class="hero" :aria-label="`Welcome to ${siteName}`">
        <div class="hero-visual">
            <img v-if="hero.image" class="hero-image" :src="hero.image" alt="" aria-hidden="true" loading="eager" />
            <div class="hero-content">
                <h1>{{ hero.headline || 'Share Your' }} <span>{{ hero.highlight || 'World' }}</span></h1>
                <p>{{ hero.description }}</p>
                <button v-if="hero.video" type="button" class="watch-video-btn" @click="emit('preview', hero.video)"><Icon name="play" />Watch Video</button>
                <a v-else class="watch-video-btn" href="#featured"><Icon name="play" />Watch Video</a>
            </div>
            <div class="mobile-hero-copy mobile-only"><h2>{{ hero.mobile_title || 'Discover' }}<br /><span>Shop · Connect</span><br />Earn</h2><p>{{ hero.mobile_description || 'Everything you need in one place' }}</p><a href="#jobs" class="mobile-join-button">Explore Jobs</a></div>
        </div>
        <div class="start-steps">
            <h2>Get Started in 3 Easy Steps</h2>
            <div v-for="(step,index) in steps.slice(0,3)" :key="index" class="step"><span class="step-icon" :class="['step-purple','step-blue','step-green'][index]"><Icon :name="step.icon || 'check'" /></span><span><strong>{{ index+1 }} <Icon name="chevron-right" /> {{ step.title }}</strong><small>{{ step.description }}</small></span></div>
            <a class="gradient-button join-button" href="#jobs">Explore Opportunities</a>
        </div>
    </section>
</template>
