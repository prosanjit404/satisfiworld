<script setup>
import { nextTick, ref, watch } from 'vue';
import Icon from './Icon.vue';
const props = defineProps({ kind: { type: String, default: '' }, item: { type: Object, default: () => ({}) }, user: { type: Object, default: () => ({}) }, actions: { type: Array, default: () => [] } });
const emit = defineEmits(['close']);
const frame = ref(null);
watch(() => props.kind, async kind => { if (kind) { await nextTick(); frame.value?.focus(); } });
</script>
<template>
    <div v-if="kind" class="modal-backdrop" role="presentation" @mousedown.self="emit('close')">
        <div ref="frame" class="modal-card" role="dialog" aria-modal="true" :aria-label="kind === 'video' ? 'Video preview' : kind === 'create' ? 'Create content' : 'Details'" tabindex="-1" @keydown.esc="emit('close')">
            <div class="modal-heading"><h2>{{ kind === 'video' ? item.title || 'Video' : kind === 'create' ? 'What would you like to create?' : kind === 'profile' ? 'My account' : item.title || 'Job details' }}</h2><button class="modal-close" type="button" aria-label="Close dialog" @click="emit('close')"><Icon name="x" /></button></div>
            <div class="modal-body">
                <template v-if="kind === 'video'">
                    <video v-if="item.video_url" :src="item.video_url" :poster="item.image" controls playsinline></video>
                    <template v-else><img v-if="item.image" :src="item.image" :alt="item.title" /><p>This is a thumbnail preview. A video URL is not connected yet.</p></template>
                </template>
                <template v-else-if="kind === 'create'"><div class="modal-action-list"><template v-for="action in actions" :key="action.label"><a v-if="action.url" class="modal-action" :href="action.url"><Icon :name="action.icon || 'plus'" />{{ action.label }}</a><button v-else type="button" class="modal-action" disabled :title="`${action.label} is not connected yet`"><Icon :name="action.icon || 'plus'" />{{ action.label }}</button></template></div><p>Actions become available after their creation routes are connected.</p></template>
                <template v-else-if="kind === 'profile'"><p><strong>Name:</strong> {{ user.name || 'Account' }}</p><p v-if="user.email"><strong>Email:</strong> {{ user.email }}</p><p>Profile and settings links can be connected to your account routes.</p></template>
                <template v-else><img v-if="item.image" :src="item.image" :alt="item.title" /><p>{{ item.description || 'This listing is being prepared.' }}</p><a v-if="item.url" class="gradient-button" :href="item.url">View Job <Icon name="arrow-right" /></a></template>
            </div>
        </div>
    </div>
</template>
