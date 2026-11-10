<script setup>
import BaseLayout from './BaseLayout.vue';

defineProps({
    title: {
        type: String,
        default: '',
    },
    showBack: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <BaseLayout>
        <div class="auth-layout">
            <slot />
        </div>
    </BaseLayout>
</template>