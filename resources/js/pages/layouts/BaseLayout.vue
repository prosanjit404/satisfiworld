<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import { useLocalToast } from '@/composables/useLocalToast';

const page = usePage();
const { toast: localToast, showToast, hideToast, pauseToast, resumeToast } = useLocalToast();

const loaderEnabled = computed(() => Number(page.props.generalSettings?.loader ?? 0) === 0);
const flashToast = computed(() => page.props.flash?.toast ?? null);
const toastTypes = ['success', 'error', 'warning', 'info'];
const toastType = computed(() => toastTypes.includes(localToast.value.type) ? localToast.value.type : 'info');
const toastIcon = computed(() => toastTypes.includes(localToast.value.icon) ? localToast.value.icon : toastType.value);
const toastTitle = computed(() => ({
    success: 'Success',
    error: 'Something went wrong',
    warning: 'Warning',
    info: 'Information'
})[toastType.value]);
const toastDuration = computed(() => `${localToast.value.duration ?? 3000}ms`);

const isLoading = ref(false);
const pointerInside = ref(false);
const pointerHeld = ref(false);
const isFocused = ref(false);

let loaderTimer = null;
let stopFlashWatch = null;
let stopSettingWatch = null;
const removeEvents = [];

function syncToastPause() {
    if (!localToast.value.show) return;
    if (pointerInside.value || pointerHeld.value || isFocused.value) {
        pauseToast();
    } else {
        resumeToast();
    }
}

function onPointerEnter() {
    pointerInside.value = true;
    syncToastPause();
}

function onPointerLeave() {
    pointerInside.value = false;
    pointerHeld.value = false;
    syncToastPause();
}

function onPointerDown() {
    pointerHeld.value = true;
    syncToastPause();
}

function onPointerUp() {
    pointerHeld.value = false;
    syncToastPause();
}

function onPointerCancel() {
    pointerHeld.value = false;
    pointerInside.value = false;
    syncToastPause();
}

function onFocusIn() {
    isFocused.value = true;
    syncToastPause();
}

function onFocusOut(event) {
    if (event.currentTarget.contains(event.relatedTarget)) return;
    isFocused.value = false;
    syncToastPause();
}

function stopLoading() {
    if (loaderTimer !== null) clearTimeout(loaderTimer);
    loaderTimer = null;
    isLoading.value = false;
}

function startLoading() {
    stopLoading();
    if (!loaderEnabled.value) return;
    loaderTimer = setTimeout(() => {
        loaderTimer = null;
        if (loaderEnabled.value) isLoading.value = true;
    }, 300);
}

watch(() => localToast.value.id, () => {
    pointerInside.value = false;
    pointerHeld.value = false;
    isFocused.value = false;
});

onMounted(() => {
    stopFlashWatch = watch(flashToast, value => {
        if (value?.message) {
            showToast(
                value.message,
                value.type ?? 'success',
                value.icon ?? value.type ?? 'success',
                3000
            );
        }
    }, { immediate: true });

    stopSettingWatch = watch(loaderEnabled, enabled => {
        if (!enabled) stopLoading();
    });

    removeEvents.push(
        router.on('start', startLoading),
        router.on('finish', stopLoading),
        router.on('error', stopLoading),
        router.on('invalid', stopLoading)
    );
});

onBeforeUnmount(() => {
    stopLoading();
    stopFlashWatch?.();
    stopSettingWatch?.();
    removeEvents.forEach(remove => remove?.());
});
</script>

<template>
    <slot />

    <Transition name="loader-fade">
        <div
            v-if="isLoading && loaderEnabled"
            class="ar-loading-view"
            role="status"
            aria-label="Loading"
        >
            <div class="loading-animat">
                <div class="logo-loader">
                    <img src="/assets/logo/logo_white.png" alt="Logo" class="loader-logo" />
                    <svg class="orbit-svg" viewBox="0 0 160 160" aria-hidden="true">
                        <g class="orbit-spin">
                            <g class="orbit-offset">
                                <circle class="orbit-arc" cx="80" cy="80" r="58" />
                                <circle class="orbit-dot" cx="57.3" cy="26.6" r="4" />
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </Transition>

    <div class="notification-host">
        <Transition name="notification">
            <div
                v-if="localToast.show"
                :key="localToast.id"
                class="notification-card"
                :class="[
                    'notification-' + toastType,
                    { 'notification-paused': localToast.paused }
                ]"
                :style="{ '--notice-duration': toastDuration }"
                :role="toastType === 'error' ? 'alert' : 'status'"
                @pointerenter="onPointerEnter"
                @pointerleave="onPointerLeave"
                @pointerdown="onPointerDown"
                @pointerup="onPointerUp"
                @pointercancel="onPointerCancel"
                @focusin="onFocusIn"
                @focusout="onFocusOut"
            >
                <div class="notification-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <template v-if="toastIcon === 'success'">
                            <circle cx="12" cy="12" r="9.5" />
                            <path class="success-check" d="m8 12 2.6 2.6L16.5 9" />
                        </template>
                        <template v-else-if="toastIcon === 'error'">
                            <circle cx="12" cy="12" r="9.5" />
                            <path d="m9 9 6 6M15 9l-6 6" />
                        </template>
                        <template v-else-if="toastIcon === 'warning'">
                            <path d="M10.3 3.4 2 18a2 2 0 0 0 1.7 3h16.6a2 2 0 0 0 1.7-3L13.7 3.4a2 2 0 0 0-3.4 0Z" />
                            <path d="M12 9v4M12 17h.01" />
                        </template>
                        <template v-else>
                            <circle cx="12" cy="12" r="9.5" />
                            <path d="M12 11v5M12 8h.01" />
                        </template>
                    </svg>
                </div>

                <div class="notification-content">
                    <div class="notification-title">{{ toastTitle }}</div>
                    <div class="notification-message">{{ localToast.message }}</div>
                </div>

                <button
                    type="button"
                    class="notification-close"
                    aria-label="Dismiss notification"
                    @click="hideToast"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>

                <div class="notification-progress">
                    <div class="notification-progress-fill"></div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.ar-loading-view {position: fixed;inset: 0;z-index: 9999;background: rgba(0, 0, 0, 0.30);display: flex;align-items: center;justify-content: center;}
.loading-animat {width: 190px;height: 190px;display: flex;align-items: center;justify-content: center;}
.logo-loader {width: 160px;height: 160px;position: relative;display: flex;align-items: center;justify-content: center;}
.loader-logo {width: 88px;height: auto;object-fit: contain;position: relative;z-index: 3;}
.orbit-svg {position: absolute;inset: 0;width: 100%;height: 100%;overflow: visible;}
.orbit-spin {transform-origin: 80px 80px;animation: orbitSpin 1.4s linear infinite;}
.orbit-offset {transform-origin: 80px 80px;transform: rotate(-118deg);}
.orbit-arc {fill: none;stroke: #3FA66B;stroke-width: 3.5;stroke-linecap: round;stroke-dasharray: 250 120;}
.orbit-dot {fill: #3FA66B;}
@keyframes orbitSpin {from { transform: rotate(0deg); }to { transform: rotate(360deg); }}
.loader-fade-enter-active,
.loader-fade-leave-active {transition: opacity 0.18s ease;}
.loader-fade-enter-from,
.loader-fade-leave-to {opacity: 0;}
.notification-host {position: fixed;top: 24px;right: 24px;width: 390px;max-width: calc(100vw - 32px);z-index: 10001;pointer-events: none;}
.notification-card {--notice-color: #176B3B;--notice-soft: #E9F7EE;position: relative;display: flex;align-items: flex-start;gap: 13px;width: 100%;padding: 10px;background: #FFFFFF;border: 1px solid #E5EAF0;border-radius: 8px;box-shadow: 0 20px 55px -22px rgba(22, 59, 101, 0.30), 0 4px 12px rgba(22, 59, 101, 0.045);color: #163B65;font-family: 'Hind Siliguri', Inter, system-ui, sans-serif;overflow: hidden;pointer-events: auto;touch-action: pan-y;}
.notification-success {--notice-color: #176B3B;--notice-soft: #E9F7EE;}
.notification-error {--notice-color: #B42318;--notice-soft: #FFF0EE;}
.notification-warning {--notice-color: #95500F;--notice-soft: #FFF4E5;}
.notification-info {--notice-color: #163B65;--notice-soft: #EAF4FA;}
.notification-icon {position: relative;flex-shrink: 0;width: 43px;height: 43px;border-radius: 8px;display: flex;align-items: center;justify-content: center;background: var(--notice-soft);color: var(--notice-color);animation: notificationIconEnter 0.55s cubic-bezier(0.2, 1.5, 0.45, 1) both;}
.notification-icon svg {width: 25px;height: 25px;position: relative;z-index: 2;}
.notification-icon::after {content: '';position: absolute;inset: 0;border: 1px solid var(--notice-color);border-radius: 8px;opacity: 0;animation: notificationPulse 0.7s ease-out 0.12s both;}
@keyframes notificationIconEnter {
    0% {
        opacity: 0;
        transform: scale(0.65) rotate(-10deg);
    }
    65% {
        opacity: 1;
        transform: scale(1.09) rotate(2deg);
    }
    100% {
        opacity: 1;
        transform: scale(1) rotate(0);
    }
}

@keyframes notificationPulse {
    0% {
        opacity: 0.45;
        transform: scale(0.86);
    }
    100% {
        opacity: 0;
        transform: scale(1.32);
    }
}

.success-check {
    stroke-dasharray: 24;
    stroke-dashoffset: 24;
    animation: notificationCheckDraw 0.45s ease 0.22s forwards;
}

@keyframes notificationCheckDraw {to { stroke-dashoffset: 0; }}
.notification-content {flex: 1;min-width: 0;padding-top: 1px;}
.notification-title {color: #163B65;font-size: 14px;font-weight: 750;letter-spacing: -0.2px;line-height: 1.35;margin-bottom: 5px;}
.notification-message {color: #64758A;font-size: 12.5px;font-weight: 450;line-height: 1.65;overflow-wrap: anywhere;}
.notification-close {width: 25px;height: 25px;padding: 4px;flex-shrink: 0;display: flex;align-items: center;justify-content: center;background: transparent;color: #9AA8B5;border: none;border-radius: 6px;cursor: pointer;transition: background 0.18s ease, color 0.18s ease, transform 0.2s ease;}
.notification-close svg {width: 15px;height: 15px;}
.notification-close:hover {color: #163B65;background: #F0F3F7;transform: rotate(90deg);}
.notification-close:focus-visible {outline: 2px solid #163B65;outline-offset: 2px;}
.notification-progress {position: absolute;left: 0;bottom: 0;width: 100%;height: 3px;background: var(--notice-soft);}
.notification-progress-fill {width: 100%;height: 100%;background: var(--notice-color);transform-origin: left center;animation: notificationCountdown var(--notice-duration, 3000ms) linear forwards;animation-play-state: running;}
.notification-paused .notification-progress-fill {animation-play-state: paused;}
@keyframes notificationCountdown {from { transform: scaleX(1); }to { transform: scaleX(0); }}
.notification-enter-active {transition: opacity 0.32s ease, transform 0.48s cubic-bezier(0.18, 1.28, 0.35, 1);}
.notification-leave-active {transition: opacity 0.20s ease, transform 0.24s ease;}
.notification-enter-from {opacity: 0;transform: translate3d(35px, -15px, 0) scale(0.94);}
.notification-enter-to,
.notification-leave-from {opacity: 1;transform: translate3d(0, 0, 0) scale(1);}
.notification-leave-to {opacity: 0;transform: translate3d(20px, -10px, 0) scale(0.97);}
@media (max-width: 500px) {
    .notification-host {position: fixed;top: auto;bottom: max(20px, env(safe-area-inset-bottom));left: 15px;right: 15px;width: auto;max-width: none;z-index: 10001;}
    .notification-card {min-height: 78px;gap: 11px;padding: 14px 13px 18px;}
    .notification-icon {width: 39px;height: 39px;}
    .notification-icon svg {width: 23px;height: 23px;}
    .notification-title {font-size: 13.5px;}
    .notification-message {font-size: 12px;}
    .notification-enter-from {opacity: 0;transform: translate3d(0, 45px, 0) scale(0.94);}
    .notification-enter-to,
    .notification-leave-from {opacity: 1;transform: translate3d(0, 0, 0) scale(1);}
    .notification-leave-to {opacity: 0;transform: translate3d(0, 35px, 0) scale(0.96);}
}

@media (prefers-reduced-motion: reduce) {
    .notification-enter-active,
    .notification-leave-active,
    .loader-fade-enter-active,
    .loader-fade-leave-active {
        transition-duration: 0.01ms;
    }

    .notification-icon,
    .notification-icon::after,
    .success-check {
        animation: none;
    }

    .success-check {
        stroke-dashoffset: 0;
    }
}
</style>
