<script setup>
import { computed } from 'vue';
const props = defineProps({ name: { type: String, default: 'circle' } });
const paths = {
    menu: '<path d="M4 6h16M4 12h16M4 18h16"/>',
    search: '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
    bell: '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>',
    message: '<path d="M4 5h16v12H8l-4 3V5Z"/><path d="M8 9h8M8 13h6"/>',
    plus: '<path d="M12 5v14M5 12h14"/>',
    'plus-circle': '<circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>',
    'chevron-down': '<path d="m6 9 6 6 6-6"/>',
    'chevron-right': '<path d="m9 6 6 6-6 6"/>',
    'arrow-right': '<path d="M4 12h16m-7-7 7 7-7 7"/>',
    'arrow-up': '<path d="M12 20V4m-7 7 7-7 7 7"/>',
    play: '<path d="m8 5 11 7-11 7V5Z"/>',
    'play-circle': '<circle cx="12" cy="12" r="10"/><path d="m10 8 6 4-6 4V8Z"/>',
    'play-box': '<rect x="2" y="4" width="20" height="16" rx="3"/><path d="m10 8 6 4-6 4V8Z"/>',
    user: '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
    'user-plus': '<circle cx="10" cy="8" r="4"/><path d="M2 21a8 8 0 0 1 14 0M19 9v6m-3-3h6"/>',
    users: '<circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2M17 5a3 3 0 0 1 0 6m4 9v-2a6 6 0 0 0-4-5.65"/>',
    house: '<path d="m3 11 9-8 9 8v9h-7v-6h-4v6H3v-9Z"/>',
    lightning: '<path d="m13 2-9 12h7l-1 8 10-13h-7V2Z"/>',
    video: '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="m10 8 6 4-6 4V8Z"/>',
    camera: '<rect x="3" y="6" width="18" height="15" rx="2"/><path d="m8 6 2-3h4l2 3"/><circle cx="12" cy="13.5" r="3"/>',
    clock: '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    image: '<rect x="2" y="3" width="20" height="18" rx="2"/><circle cx="8" cy="8" r="1.5"/><path d="m3 18 6-6 5 5 3-3 4 4"/>',
    bag: '<path d="M4 8h16l-1 13H5L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/>',
    cart: '<circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M2 3h3l3 13h11l2-9H6"/>',
    shop: '<path d="M3 10h18l-2-6H5l-2 6Zm2 0v11h14V10M9 21v-7h6v7"/>',
    briefcase: '<rect x="3" y="7" width="18" height="14" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 13h18"/>',
    tools: '<path d="m4 20 9-9M12 4l8 8-3 3-8-8 3-3ZM3 16l5 5"/>',
    settings: '<circle cx="12" cy="12" r="3"/><path d="m12 2 2 3 3-.5 1 3 3 2-2 3 1 3-3 1-1 4-4-1-3 1-1-3-3-1 1-4-2-2 3-2 0-3 3 .5Z"/>',
    live: '<circle cx="12" cy="12" r="2"/><path d="M8 8a6 6 0 0 0 0 8M16 8a6 6 0 0 1 0 8M5 5a10 10 0 0 0 0 14m14-14a10 10 0 0 1 0 14"/>',
    dots: '<circle cx="5" cy="12" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="19" cy="12" r="1.4"/>',
    star: '<path d="m12 2 3.1 6.4L22 9.4l-5 4.9 1.2 7-6.2-3.3-6.2 3.3 1.2-7-5-4.9 6.9-1Z"/>',
    eye: '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
    check: '<path d="m4 12 5 5L20 6"/>',
    x: '<path d="M5 5 19 19M19 5 5 19"/>',
    logout: '<path d="M10 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5M14 7l5 5-5 5M9 12h10"/>',
    edit: '<path d="M4 20h16M6 15l9-9 3 3-9 9H6v-3ZM15 6l2-2 3 3-2 2"/>',
    upload: '<path d="M12 16V3M6 9l6-6 6 6M4 16v4h16v-4"/>',
    'bag-plus': '<path d="M4 8h16l-1 13H5L4 8ZM9 8V6a3 3 0 0 1 6 0v2M12 11v6m-3-3h6"/>',
    heart: '<path d="M20.5 5.5c-2-2-5-2-7 0L12 7l-1.5-1.5c-2-2-5-2-7 0-2 2-2 5 0 7L12 21l8.5-8.5c2-2 2-5 0-7Z"/>',
    shield: '<path d="M12 2 4 5v6c0 5 3.5 8.5 8 11 4.5-2.5 8-6V5l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
    verified: '<path d="m12 2 3 2 4 1 1 4 2 3-2 3-1 4-4 1-3 2-3-2-4-1-1-4-2-3 2-3 1-4 4-1 3-2Z"/><path d="m8 12 3 3 5-6"/>',
    'chart-up': '<path d="M3 20h18M4 17l5-5 4 3 7-10m-6 0h6v6"/>',
    circle: '<circle cx="12" cy="12" r="9"/>',
    dollar: '<path d="M12 2v20M17 7c-2-3-10-3-10 2 0 4 10 2 10 7s-8 5-10 1"/>',
    tag: '<path d="M20 13 13 20 3 10V3h7l10 10Z"/><circle cx="7" cy="7" r="1"/>',
    send: '<path d="M22 2 11 13M22 2l-7 20-4-9-9-4L22 2Z"/>'
};
const markup = computed(() => paths[props.name] || paths.circle);
</script>

<template>
    <i class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" v-html="markup"></svg></i>
</template>
