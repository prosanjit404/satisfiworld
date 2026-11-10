<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
defineProps({ items: { type: Array, default: () => [] }, added: { type: Array, default: () => [] } });
const emit = defineEmits(['cart']);
const expanded = ref(false);
</script>
<template>
    <section id="shop" class="widget shop-widget" :class="{ 'is-expanded': expanded }" aria-labelledby="shopTitle">
        <header class="widget-header"><h2 id="shopTitle"><Icon name="bag" class="purple-text" /> Shop &amp; Discover</h2><button v-if="items.length > 4" class="see-all" type="button" :aria-expanded="expanded" @click="expanded = !expanded">{{ expanded ? 'Show Less' : 'See All' }} <Icon :name="expanded ? 'arrow-up' : 'arrow-right'" /></button></header>
        <div v-if="items.length" class="products-list content-list">
            <article v-for="(item,index) in items" :key="item.id || index" class="product-card searchable-card" :class="{ 'extra-card': index >= 4 }">
                <img :src="item.image" :alt="item.title" loading="lazy" />
                <h3>{{ item.title }}</h3><p class="price">{{ item.price }}</p><p class="rating"><Icon name="star" /> {{ item.rating || '—' }} <span v-if="item.reviews">({{ item.reviews }})</span></p>
                <a v-if="item.url" class="cart-button" :href="item.url">View Product</a>
                <button v-else type="button" class="cart-button" :class="{ added: added.includes(item.id) }" :aria-pressed="added.includes(item.id)" @click="emit('cart', item)">{{ added.includes(item.id) ? 'Added ✓' : 'Add to Cart' }}</button>
            </article>
        </div>
        <p v-else class="empty-state">No products available.</p>
    </section>
</template>
