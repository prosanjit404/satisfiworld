<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
const emit = defineEmits(['create', 'profile']);
const selected = ref('Home');
const links = [{ label:'Home', icon:'house', url:'#top' },{label:'Shorts', icon:'lightning',url:'#trending'},{label:'Shop',icon:'cart',url:'#shop'}];
</script>
<template>
    <nav class="mobile-bottom-nav mobile-only" aria-label="Mobile bottom navigation">
        <a v-for="item in links.slice(0,2)" :key="item.label" :href="item.url" class="mobile-bottom-item" :class="{ 'is-active': selected === item.label }" @click="selected = item.label"><Icon :name="item.icon" /><span>{{ item.label }}</span></a>
        <button type="button" class="mobile-bottom-item mobile-create-item" @click="emit('create')"><span class="mobile-create-icon"><Icon name="plus" /></span><span>Create</span></button>
        <a :href="links[2].url" class="mobile-bottom-item" :class="{ 'is-active': selected === 'Shop' }" @click="selected = 'Shop'"><Icon name="cart" /><span>Shop</span></a>
        <button type="button" class="mobile-bottom-item" @click="emit('profile')"><Icon name="user" /><span>Profile</span></button>
    </nav>
</template>
