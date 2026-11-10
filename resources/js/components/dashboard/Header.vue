<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Icon from './Icon.vue';

const props = defineProps({
    siteName: { type: String, default: '' },
    user: { type: Object, default: () => ({}) },
    notifications: { type: Array, default: () => [] },
    messages: { type: Array, default: () => [] },
    searchItems: { type: Array, default: () => [] },
    cartCount: { type: Number, default: 0 },
    logoutUrl: { type: String, default: '' }
});
const emit = defineEmits(['toggle-sidebar', 'create', 'profile']);
const searchTerm = ref('');
const searchOpen = ref(false);
const openMenu = ref('');
const searchInput = ref(null);
const results = computed(() => {
    const term = searchTerm.value.trim().toLocaleLowerCase();
    return term ? props.searchItems.filter(item => `${item.title} ${item.category}`.toLocaleLowerCase().includes(term)).slice(0, 8) : [];
});
const avatar = computed(() => props.user.avatar || '');
const displayName = computed(() => props.user.name || 'My Account');
function goTo(item) {
    searchOpen.value = false;
    if (item.url && !item.url.startsWith('#')) { window.location.href = item.url; return; }
    const target = document.getElementById((item.url || '#' + item.section).replace(/^#/, ''));
    target?.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
function focusSearch(term = '') { searchTerm.value = term; searchOpen.value = !!term; searchInput.value?.focus(); }
defineExpose({ focusSearch });
function toggleMenu(name) { openMenu.value = openMenu.value === name ? '' : name; }
function submitSearch() { if (results.value[0]) goTo(results.value[0]); else searchOpen.value = true; }
</script>

<template>
    <header class="topbar" id="top" @keydown.esc="openMenu = ''; searchOpen = false">
        <div class="brand-area">
            <button class="icon-button sidebar-toggle" type="button" aria-label="Open navigation" @click="emit('toggle-sidebar')"><Icon name="menu" /></button>
            <a class="brand" href="#top" :aria-label="`${siteName} Home`">
                <img src="/assets/logo/logo-white.png" :alt="siteName" width="168" height="39" />
            </a>
        </div>
        <form class="site-search" role="search" autocomplete="off" @submit.prevent="submitSearch" @focusout="searchOpen = false">
            <span class="search-leading"><Icon name="search" /></span>
            <input ref="searchInput" v-model="searchTerm" type="search" :aria-label="`Search ${siteName}`" placeholder="Search anything... (products, videos, jobs, people, etc.)" @focus="searchOpen = true" @input="searchOpen = true" />
            <button type="submit" aria-label="Search"><Icon name="search" /></button>
            <div v-if="searchOpen && searchTerm.trim()" class="search-dropdown" aria-live="polite">
                <button v-for="(item,index) in results" :key="index" class="search-result" type="button" @mousedown.prevent="goTo(item)"><span>{{ item.title }}</span><small>{{ item.category }}</small></button>
                <div v-if="!results.length" class="search-empty">No matching content</div>
            </div>
        </form>
        <nav class="header-actions" aria-label="Account actions">
            <button class="mobile-search-trigger mobile-only" type="button" aria-label="Focus search" @click="searchInput?.focus()"><Icon name="search" /></button>
            <button class="header-action create-action" type="button" @click="emit('create')"><Icon name="plus-circle" /><span>Create</span></button>
            <div class="dropdown">
                <button type="button" class="header-action" :aria-expanded="openMenu === 'notifications'" @click="toggleMenu('notifications')"><span class="action-icon"><Icon name="bell" /><span v-if="notifications.length" class="notification-dot">{{ notifications.length > 9 ? '9+' : notifications.length }}</span></span><span>Notifications</span></button>
                <div v-if="openMenu === 'notifications'" class="dropdown-menu action-dropdown"><h6 class="dropdown-header">Notifications</h6><p v-for="(entry,index) in notifications" :key="index" class="dropdown-item-text">{{ entry.message || entry }}</p><p v-if="!notifications.length" class="dropdown-item-text">No new notifications.</p></div>
            </div>
            <div class="dropdown messages-action">
                <button type="button" class="header-action" :aria-expanded="openMenu === 'messages'" @click="toggleMenu('messages')"><span class="action-icon"><Icon name="message" /><span v-if="messages.length" class="notification-dot">{{ messages.length > 9 ? '9+' : messages.length }}</span></span><span>Messages</span></button>
                <div v-if="openMenu === 'messages'" class="dropdown-menu action-dropdown"><h6 class="dropdown-header">Messages</h6><p v-for="(entry,index) in messages" :key="index" class="dropdown-item-text">{{ entry.message || entry }}</p><p v-if="!messages.length" class="dropdown-item-text">No new messages.</p></div>
            </div>
            <div class="dropdown account-area">
                <button class="profile-trigger" type="button" :aria-expanded="openMenu === 'profile'" @click="toggleMenu('profile')">
                    <img v-if="avatar" :src="avatar" :alt="displayName" width="37" height="37" /><span v-else class="profile-avatar" aria-hidden="true">{{ displayName.charAt(0).toUpperCase() }}</span><span class="profile-description"><strong>{{ displayName }}</strong><small v-if="user.membership"><Icon name="verified" /> {{ user.membership }}</small></span><Icon name="chevron-down" />
                </button>
                <ul v-if="openMenu === 'profile'" class="dropdown-menu">
                    <li><button type="button" class="dropdown-item" @click="openMenu = ''; emit('profile')"><Icon name="user" /> My Profile</button></li>
                    <li><button type="button" class="dropdown-item" @click="openMenu = ''; emit('profile')"><Icon name="cart" /> Saved Cart ({{ cartCount }})</button></li>
                    <li v-if="logoutUrl"><hr class="dropdown-divider" /></li>
                    <li v-if="logoutUrl"><Link class="dropdown-item" :href="logoutUrl"><Icon name="logout" /> Sign Out</Link></li>
                </ul>
            </div>
        </nav>
    </header>
</template>
