<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthLayout from '../layouts/AuthLayout.vue';
import Header from '../../components/dashboard/Header.vue';
import Sidebar from '../../components/dashboard/Sidebar.vue';
import BottomNav from '../../components/dashboard/BottomNav.vue';
import Hero from '../../components/dashboard/Hero.vue';
import QuickLinks from '../../components/dashboard/QuickLinks.vue';
import Trending from '../../components/dashboard/Trending.vue';
import Shop from '../../components/dashboard/Shop.vue';
import FeaturedVideo from '../../components/dashboard/FeaturedVideo.vue';
import PopularJobs from '../../components/dashboard/PopularJobs.vue';
import RightPanel from '../../components/dashboard/RightPanel.vue';
import Modal from '../../components/dashboard/Modal.vue';
import { useLocalToast } from '@/composables/useLocalToast';
import '@/css/dashboard.css';

const props = defineProps({
    dashboard: { type: Object, default: () => ({}) },
    account: { type: Object, default: () => ({}) },
    siteName: { type: String, default: '' }
});
const { showToast } = useLocalToast();
const sidebarOpen = ref(false);
const dialog = ref('');
const selectedItem = ref({});
const cart = ref([]);
const followed = ref([]);
const header = ref(null);
const data = computed(() => props.dashboard || {});
const account = computed(() => props.account || {});
const searchItems = computed(() => [
    ...(data.value.trending || []).map(item => ({ ...item, category: 'Trending', section: 'trending' })),
    ...(data.value.products || []).map(item => ({ ...item, category: 'Shop', section: 'shop' })),
    ...(data.value.featured?.title ? [{ ...data.value.featured, category: 'Featured Video', section: 'featured' }] : []),
    ...(data.value.videos || []).map(item => ({ ...item, category: 'Video', section: 'featured' })),
    ...(data.value.jobs || []).map(item => ({ ...item, category: 'Jobs', section: 'jobs' })),
    ...(data.value.people || []).map(item => ({ title: item.name, category: 'People', section: 'people' }))
]);
function closeDialog() { dialog.value = ''; selectedItem.value = {}; }
function preview(item) { selectedItem.value = item || {}; dialog.value = 'video'; }
function details(item) { selectedItem.value = item || {}; dialog.value = 'job'; }
function toggleCart(item) {
    if (!item?.id) return;
    cart.value = cart.value.includes(item.id) ? cart.value.filter(id => id !== item.id) : [...cart.value, item.id];
    showToast(cart.value.includes(item.id) ? 'Added to your local cart preview.' : 'Removed from your local cart preview.', 'info');
}
function toggleFollow(item) {
    if (!item?.id) return;
    followed.value = followed.value.includes(item.id) ? followed.value.filter(id => id !== item.id) : [...followed.value, item.id];
    showToast('Following preferences saved in this browser only.', 'info');
}
function onKeydown(event) { if (event.key === 'Escape') { sidebarOpen.value = false; closeDialog(); } }
function searchTag(tag) { header.value?.focusSearch(tag); }
onMounted(() => {
    try {
        const cartValue = JSON.parse(localStorage.getItem('dashboard-cart-preview') || '[]');
        const followValue = JSON.parse(localStorage.getItem('dashboard-follow-preview') || '[]');
        cart.value = Array.isArray(cartValue) ? cartValue : [];
        followed.value = Array.isArray(followValue) ? followValue : [];
    } catch { cart.value = []; followed.value = []; }
    window.addEventListener('keydown', onKeydown);
});
onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown));
// These browser preferences are UI previews. Replace with authenticated endpoints for persistence.
watch(cart, value => { if (typeof window !== 'undefined') localStorage.setItem('dashboard-cart-preview', JSON.stringify(value)); }, { deep: true });
watch(followed, value => { if (typeof window !== 'undefined') localStorage.setItem('dashboard-follow-preview', JSON.stringify(value)); }, { deep: true });
</script>

<template>
    <AuthLayout title="Dashboard" :showBack="false" :showHeader="false">
        <Head title="Dashboard" />
        <div class="dashboard" :class="{ 'navigation-open': sidebarOpen }">
            <Header ref="header" :site-name="siteName" :user="account" :notifications="data.notifications || []" :messages="data.messages || []" :search-items="searchItems" :cart-count="cart.length" logout-url="/user/logout" @toggle-sidebar="sidebarOpen = !sidebarOpen" @create="dialog = 'create'" @profile="dialog = 'profile'" />
            <Sidebar :site-name="siteName" :links="data.navigation || []" :hashtags="data.hashtags || []" :open="sidebarOpen" @close="sidebarOpen = false" @search="searchTag" />
            <main class="app-main">
                <div class="page-layout">
                    <div class="center-column">
                        <Hero :site-name="siteName" :hero="data.hero || {}" :steps="data.steps || []" @preview="preview" />
                        <QuickLinks :site-name="siteName" :links="data.quick_links || []" @more="sidebarOpen = true" />
                        <div class="dashboard-grid">
                            <Trending :items="data.trending || []" @preview="preview" />
                            <Shop :items="data.products || []" :added="cart" @cart="toggleCart" />
                            <FeaturedVideo :featured="data.featured || {}" :videos="data.videos || []" @preview="preview" />
                            <PopularJobs :items="data.jobs || []" @details="details" />
                        </div>
                    </div>
                    <RightPanel :site-name="siteName" :live="data.live || {}" :people="data.people || []" :creator="data.creator || {}" :followed="followed" @preview="preview" @follow="toggleFollow" />
                </div>
                <footer class="page-footer">© {{ new Date().getFullYear() }} {{ siteName }}. All rights reserved.</footer>
            </main>
            <BottomNav @create="dialog = 'create'" @profile="dialog = 'profile'" />
            <Modal :kind="dialog" :item="selectedItem" :user="account" :actions="data.create_actions || []" @close="closeDialog" />
        </div>
    </AuthLayout>
</template>
