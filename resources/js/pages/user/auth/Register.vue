
<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../layouts/GuestLayout.vue';
import '@/css/auth.css';

const showPassword = ref(false);
const showConfirmation = ref(false);
const props = defineProps({
    socialLinks: { type: Object, default: () => ({}) }
});

const form = useForm({ name: '', email: '', password: '', password_confirmation: '' });

function submit() {
    form.post(route('user.register.submit'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
}
</script>

<template>
    <GuestLayout>
        <Head title="Create account" />
        <main class="authentication">
            <div class="layout registration">
                <div class="mobile-banner">
                    <Link :href="route('home')" class="banner-brand">
                        <img src="/assets/logo/logo-white.png" alt="RoyelHost" />
                    </Link>
                    <p class="banner-heading">Your next step starts here.</p>
                    <p class="banner-description">Explore tasks, submit your work and track progress in one place.</p>
                    <div class="banner-steps">
                        <span class="step">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="10.8" cy="10.8" r="6.8"/>
                                <path d="m16 16 5 5"/>
                            </svg>
                            Explore
                        </span>
                        <span class="step">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 3 10 14M21 3l-7 18-4-7-7-4L21 3Z"/>
                            </svg>
                            Submit
                        </span>
                        <span class="step">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="4" width="16" height="17" rx="2"/>
                                <path d="m8 12 3 3 5-6"/>
                            </svg>
                            Track
                        </span>
                    </div>
                </div>

                <section class="form-panel">
                    <Link :href="route('home')" class="brand">
                        <img src="/assets/logo/logo-dark.webp" alt="RoyelHost" />
                    </Link>
                    <h1 class="heading">Create account</h1>
                    <p class="subtitle">
                        Already have an account?
                        <Link :href="route('user.login')">Sign in</Link>
                    </p>

                    <form @submit.prevent="submit" novalidate>
                        <div class="field">
                            <label for="name">Full name</label>
                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 21v-2a8 8 0 0 1 16 0v2"/>
                                    </svg>
                                </span>
                                <input id="name" v-model="form.name" type="text" class="input with-icon" :class="{ invalid: form.errors.name }" placeholder="Enter your full name" autocomplete="name" :aria-invalid="!!form.errors.name" required autofocus />
                            </div>
                            <p v-if="form.errors.name" class="error" role="alert">{{ form.errors.name }}</p>
                        </div>

                        <div class="field">
                            <label for="email">E-mail</label>
                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m3 7 9 6 9-6"/>
                                    </svg>
                                </span>
                                <input id="email" v-model="form.email" type="email" class="input with-icon" :class="{ invalid: form.errors.email }" placeholder="example@gmail.com" autocomplete="email" :aria-invalid="!!form.errors.email" required />
                            </div>
                            <p v-if="form.errors.email" class="error" role="alert">{{ form.errors.email }}</p>
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="5" y="10" width="14" height="11" rx="2"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                </span>
                                <input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'" class="input with-icon with-toggle" :class="{ invalid: form.errors.password }" placeholder="Create a password" autocomplete="new-password" :aria-invalid="!!form.errors.password" required />
                                <button type="button" class="eye-button" :aria-label="showPassword ? 'Hide password' : 'Show password'" :aria-pressed="showPassword" @click="showPassword = !showPassword">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <template v-if="!showPassword">
                                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </template>
                                        <template v-else>
                                            <path d="m3 3 18 18M10 6.2A11 11 0 0 1 12 6c6.5 0 10 6 10 6a15 15 0 0 1-3.2 3.6M6.2 8C3.5 9.8 2 12 2 12s3.5 6 10 6c1.5 0 3-.3 4.2-1"/>
                                        </template>
                                    </svg>
                                </button>
                            </div>
                            <p v-if="form.errors.password" class="error" role="alert">{{ form.errors.password }}</p>
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Confirm password</label>
                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2 4 5v6c0 5 3.5 8.3 8 11 4.5-2.7 8-6V5l-8-3Z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </span>
                                <input id="password_confirmation" v-model="form.password_confirmation" :type="showConfirmation ? 'text' : 'password'" class="input with-icon with-toggle" :class="{ invalid: form.errors.password_confirmation }" placeholder="Confirm your password" autocomplete="new-password" :aria-invalid="!!form.errors.password_confirmation" required />
                                <button type="button" class="eye-button" :aria-label="showConfirmation ? 'Hide password' : 'Show password'" :aria-pressed="showConfirmation" @click="showConfirmation = !showConfirmation">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <template v-if="!showConfirmation">
                                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </template>
                                        <template v-else>
                                            <path d="m3 3 18 18M10 6.2A11 11 0 0 1 12 6c6.5 0 10 6 10 6a15 15 0 0 1-3.2 3.6M6.2 8C3.5 9.8 2 12 2 12s3.5 6 10 6c1.5 0 3-.3 4.2-1"/>
                                        </template>
                                    </svg>
                                </button>
                            </div>
                            <p v-if="form.errors.password_confirmation" class="error" role="alert">{{ form.errors.password_confirmation }}</p>
                        </div>

                        <button type="submit" class="submit-button" :disabled="form.processing">
                            <span v-if="form.processing" class="spinner"></span>
                            {{ form.processing ? 'Creating account...' : 'Create account' }}
                        </button>
                    </form>
                </section>

                <aside class="showcase">
                    <div class="showcase-top">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 8v4l3 2"/>
                        </svg>
                        Get started
                    </div>
                    <div class="feature">
                        <div class="feature-top">
                            <img src="/assets/logo/logo.png" alt="" />
                            <span>New account</span>
                        </div>
                        <h2>A simpler way to get started.</h2>
                        <p>Create an account to manage your profile, activity and important updates in one place.</p>
                        <div class="feature-footer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                            Set up your profile in a few steps
                        </div>
                    </div>
                    <div class="showcase-bottom">
                        <h2>A good beginning is simple.</h2>
                    </div>
                </aside>
            </div>
        </main>
    </GuestLayout>
</template>
