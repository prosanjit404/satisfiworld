
<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    status: { type: Number, default: 500 },
    siteName: { type: String, default: 'SatisfiyWorld' },
});

const errors = {
    403: {
        label: 'Access denied',
        title: "Sorry, you can't view this page.",
        message: "You don't have permission to see this page. You can return to the homepage or go back to where you were.",
        illustration: 'Access not allowed',
        symbol: '!',
    },
    405: {
            label: 'Page unavailable',
            title: "You can't open this page directly.",
            message: "This page can't be opened using this link. Please return to the homepage and try again.",
            illustration: 'Page unavailable',
            symbol: '!',
        },
    404: {
        label: 'Page not found',
        title: "Oops! This page seems to be missing.",
        message: "We couldn't find the page you're looking for. It may have been moved, deleted, or the address might be incorrect.",
        illustration: 'Nothing here!',
        symbol: '?',
    },
    429: {
        label: 'Too many requests',
        title: 'Just a moment, please.',
        message: "You've made too many requests in a short time. Give it a little moment, then try again.",
        illustration: 'Please slow down',
        symbol: '!',
    },
    500: {
        label: 'Server error',
        title: "Something didn't go as planned.",
        message: "We're having trouble completing your request right now. Please try again in a little while.",
        illustration: 'Something went wrong',
        symbol: '!',
    },
    503: {
        label: 'Temporarily unavailable',
        title: "We'll be back shortly.",
        message: "Our website is temporarily unavailable. Please check back soon. Thanks for your patience.",
        illustration: 'Back soon!',
        symbol: '!',
    },
};

const statusCode = computed(() => Number(props.status));
const error = computed(() => errors[statusCode.value] ?? errors[500]);
const canRetry = computed(() => [429, 500, 503].includes(statusCode.value));

function goBack() {
    if (typeof window !== 'undefined' && window.history.length > 1) {
        window.history.back();
    } else {
        router.visit('/');
    }
}

function retry() {
    router.reload();
}
</script>

<template>
    <Head :title="`${statusCode} - ${error.label}`" />

    <main class="error-page" :class="`error-${statusCode}`">
        <div class="error-container">
            <section class="error-content">
                <div class="content-inner">
                    <div class="error-tag">
                        <span class="tag-line"></span>
                        {{ error.label }}
                    </div>

                    <div class="error-number">{{ statusCode }}</div>

                    <h1>{{ error.title }}</h1>

                    <p class="error-description">{{ error.message }}</p>

                    <div class="error-actions">
                        <Link href="/" class="home-button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V10Z"/>
                            </svg>
                            Go to homepage
                            <svg class="button-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14m-6-6 6 6-6 6"/>
                            </svg>
                        </Link>

                        <button
                            type="button"
                            class="back-button"
                            @click="canRetry ? retry() : goBack()"
                        >
                            <svg v-if="canRetry" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 11a8 8 0 1 0-2.3 6M20 4v7h-7"/>
                            </svg>
                            <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                            {{ canRetry ? 'Try again' : 'Go back' }}
                        </button>
                    </div>
                </div>
            </section>

            <section class="error-art" aria-label="Page illustration">
                <div class="art-inner">
                    <div class="art-circle circle-one"></div>
                    <div class="art-circle circle-two"></div>

                    <div class="illustration">
                        <svg viewBox="0 0 430 440" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" :aria-label="error.illustration">
                            <ellipse cx="222" cy="390" rx="132" ry="13" fill="#CFD9EA" opacity=".62"/>

                            <g class="paper-back">
                                <rect x="112" y="62" width="223" height="294" rx="10" fill="#DDE7F6" stroke="#B9CCE8" stroke-width="2" transform="rotate(8 112 62)"/>
                            </g>

                            <g class="paper-main">
                                <path d="M110 50H277L322 95V352C322 360 316 366 308 366H110C102 366 96 360 96 352V64C96 56 102 50 110 50Z" fill="#FFFFFF" stroke="#A9BFDF" stroke-width="2.3"/>
                                <path d="M277 50V84C277 91 283 95 290 95H322L277 50Z" fill="#E7EFFB" stroke="#A9BFDF" stroke-width="2.3" stroke-linejoin="round"/>

                                <rect x="126" y="84" width="95" height="9" rx="4.5" fill="#E3EAF5"/>
                                <rect x="126" y="103" width="66" height="7" rx="3.5" fill="#EDF1F8"/>

                                <circle cx="210" cy="209" r="65" fill="#F0F5FC"/>
                                <circle cx="210" cy="209" r="46" fill="#FFFFFF" stroke="#D6E2F3" stroke-width="2"/>

                                <text x="210" y="233" text-anchor="middle" font-size="65" font-family="Inter, sans-serif" font-weight="600" fill="#1549DC">{{ error.symbol }}</text>

                                <rect x="145" y="294" width="129" height="9" rx="4.5" fill="#E2EAF5"/>
                                <rect x="169" y="313" width="81" height="7" rx="3.5" fill="#EFF3F9"/>
                            </g>

                            <g class="search-lens">
                                <circle cx="109" cy="294" r="46" fill="#E6EEFC" stroke="#1549DC" stroke-width="8"/>
                                <circle cx="109" cy="294" r="32" fill="#FFFFFF" fill-opacity=".55"/>
                                <path d="M77 326L46 357" stroke="#061A3D" stroke-width="15" stroke-linecap="round"/>
                                <path d="M46 357L35 368" stroke="#1549DC" stroke-width="15" stroke-linecap="round"/>
                            </g>

                            <g class="small-decoration">
                                <path d="M341 154H370M355.5 139.5V168.5" stroke="#5540F5" stroke-width="4" stroke-linecap="round"/>
                                <circle cx="69" cy="129" r="7" fill="#1549DC" opacity=".6"/>
                                <circle cx="364" cy="264" r="5" fill="#A6B9D9"/>
                                <path d="M324 322L338 336M338 322L324 336" stroke="#A2B8DB" stroke-width="3" stroke-linecap="round"/>
                            </g>
                        </svg>
                    </div>

                    <div class="illustration-label">
                        <span class="illustration-label-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5M12 8h.01"/>
                            </svg>
                        </span>
                        <div>
                            <strong>{{ error.illustration }}</strong>
                            <small>{{ error.label }}</small>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<style scoped>
.error-page {
    --error-accent: var(--blue, #1549dc);
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 35px;
    background: var(--body, #edf3fb);
    color: var(--text, #12234a);
    font-family: Inter, system-ui, -apple-system, 'Segoe UI', sans-serif;
}

.error-page *,
.error-page *::before,
.error-page *::after {
    box-sizing: border-box;
}

.error-403 { --error-accent: var(--purple, #7a14f6); }
.error-404 { --error-accent: var(--blue, #1549dc); }
.error-429 { --error-accent: var(--pink, #f50ba6); }
.error-500 { --error-accent: var(--indigo, #5540f5); }
.error-503 { --error-accent: var(--blue, #1549dc); }

.error-container {
    display: grid;
    grid-template-columns: 1.08fr 0.92fr;
    width: 100%;
    max-width: 1150px;
    min-height: 625px;
    overflow: hidden;
    background: #fff;
    border: 1px solid var(--line, #e4ebf8);
    border-radius: 5px;
    box-shadow: 0 22px 65px rgba(6, 26, 61, .055);
}

.error-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: clamp(35px, 5vw, 73px);
    min-width: 0;
}

.content-inner {
    margin: auto 0;
    animation: contentEnter .65s cubic-bezier(.2,.8,.2,1) both;
}

.error-tag {
    display: inline-flex;
    align-items: center;
    gap: 11px;
    color: var(--error-accent);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
    text-transform: uppercase;
}

.error-number {
    margin: 17px 0 25px;
    color: var(--navy, #061a3d);
    font-size: clamp(112px, 13vw, 175px);
    font-weight: 850;
    letter-spacing: -11px;
    line-height: 1;
}

.error-content h1 {
    max-width: 490px;
    margin: 0 0 18px;
    color: var(--navy, #061a3d);
    font-size: clamp(29px, 3.2vw, 43px);
    font-weight: 600;
    letter-spacing: -1.6px;
    line-height: 1.25;
}

.error-description {
    max-width: 420px;
    margin: 0;
    color: var(--muted, #63779c);
    font-size: 14px;
    line-height: 1.9;
}

.error-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-top: 31px;
}

.home-button,
.back-button {
    min-height: 49px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 5px;
    padding: 0 18px;
    font: inherit;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s ease, border-color .2s ease, transform .2s ease, box-shadow .2s ease;
}

.home-button {
    color: #fff;
    background: var(--navy, #061a3d);
    border: 1px solid var(--navy, #061a3d);
}

.home-button:hover {
    background: var(--blue, #1549dc);
    border-color: var(--blue, #1549dc);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 9px 22px rgba(21,73,220,.14);
}

.back-button {
    color: var(--text, #12234a);
    background: #fff;
    border: 1px solid var(--line, #e4ebf8);
}

.back-button:hover {
    color: var(--blue, #1549dc);
    border-color: #b8c9e8;
    background: #f8faff;
    transform: translateY(-2px);
}

.home-button svg,
.back-button svg {
    width: 17px;
    height: 17px;
    flex-shrink: 0;
}

.home-button .button-arrow {
    margin-left: 5px;
    transition: transform .2s ease;
}

.home-button:hover .button-arrow {
    transform: translateX(4px);
}

.content-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 45px;
    padding-top: 20px;
    border-top: 1px solid var(--line, #e4ebf8);
    color: #8293b0;
    font-size: 11px;
}

.content-footer > span:nth-child(2) {
    color: var(--navy, #061a3d);
    font-weight: 800;
}

.footer-dot {
    width: 7px;
    height: 7px;
    background: var(--blue, #1549dc);
    border-radius: 50%;
}

.footer-separator {
    height: 14px;
    width: 1px;
    background: #d8e0ec;
}

.error-art {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #f0f5fc;
    border-left: 1px solid var(--line, #e4ebf8);
}

.art-inner {
    position: relative;
    width: 100%;
    max-width: 480px;
    padding: 40px 25px;
}

.art-circle {
    position: absolute;
    border: 1px solid #dbe6f5;
    border-radius: 50%;
    pointer-events: none;
}

.circle-one {
    width: 380px;
    height: 380px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -55%);
}

.circle-two {
    width: 480px;
    height: 480px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -54%);
    opacity: .65;
}

.illustration {
    position: relative;
    z-index: 2;
    width: 100%;
    animation: artEnter .7s .1s ease both;
}

.illustration svg {
    display: block;
    width: 100%;
    height: auto;
    max-height: 410px;
}

.paper-main {
    filter: drop-shadow(0 9px 10px rgba(6,26,61,.065));
}

.search-lens {
    transform-origin: 110px 294px;
    animation: lensEnter .65s .35s ease both;
}

.illustration-label {
    position: relative;
    z-index: 3;
    width: fit-content;
    max-width: 100%;
    display: flex;
    align-items: center;
    gap: 11px;
    margin: -7px auto 0;
    padding: 11px 17px;
    background: #fff;
    border: 1px solid #dce6f4;
    border-radius: var(--radius, 9px);
}

.illustration-label-icon {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    background: #e9f0fc;
    color: var(--error-accent);
}

.illustration-label-icon svg {
    width: 19px;
    height: 19px;
}

.illustration-label strong,
.illustration-label small {
    display: block;
}

.illustration-label strong {
    color: var(--navy, #061a3d);
    font-size: 12px;
    font-weight: 800;
}

.illustration-label small {
    margin-top: 3px;
    color: var(--muted, #63779c);
    font-size: 10px;
}

@keyframes contentEnter {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes artEnter {
    from {
        opacity: 0;
        transform: translateY(15px) scale(.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes lensEnter {
    from { opacity: 0; transform: translate(-12px,12px); }
    to { opacity: 1; transform: translate(0,0); }
}

@media (max-width: 900px) {
    .error-page { padding: 20px; }
    .error-container { min-height: 550px; }
    .error-content { padding: 35px; }
    .error-number { font-size: clamp(100px, 14vw, 145px); }
    .error-content h1 { font-size: 32px; }
    .art-inner { padding: 20px 12px; }
}



@media (max-width: 400px) {
    .error-content { padding: 38px 22px 30px; }
    .error-number { font-size: 105px; }
    .error-content h1 { font-size: 28px; }
    .home-button, .back-button { min-height: 46px; padding: 0 13px; font-size: 11px; }
    .art-inner { padding-bottom: 25px; }
}


@media (max-width: 700px) {
    .error-page {
        min-height: 100vh;
        min-height: 100dvh;
        padding: 0;
        background: #ffffff;
        align-items: stretch;
    }

    .error-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 0;
        width: 100%;
        max-width: 100%;
        min-height: 100vh;
        min-height: 100dvh;
        padding: 30px 20px;
        border: none;
        border-radius: 0;
        background: #ffffff;
        box-shadow: none;
        overflow: hidden;
    }

    .error-art {
        order: -1;
        flex: 0 0 auto;
        width: 100%;
        min-height: 0;
        padding: 0;
        margin: 0 auto 14px;
        border: 0;
        background: transparent;
        overflow: visible;
    }

    .art-inner {
        width: 100%;
        max-width: 220px;
        padding: 0;
        margin: 0 auto;
    }

    .illustration {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .illustration svg {
        display: block;
        width: 195px;
        height: auto;
        max-height: 200px;
    }

    .art-circle,
    .illustration-label {
        display: none;
    }

    .error-content {
        display: block;
        width: 100%;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    .content-inner {
        margin: 0 auto;
        max-width: 380px;
    }

    .error-tag {
        justify-content: center;
        gap: 8px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.2px;
    }
    .error-number {
        margin: 10px 0 15px;
        font-size: clamp(85px, 23vw, 105px);
        font-weight: 850;
        line-height: 1;
        letter-spacing: -6px;
        color: var(--navy, #061a3d);
    }

    .error-content h1 {
        max-width: 340px;
        margin: 0 auto 12px;
        font-size: clamp(23px, 6.5vw, 29px);
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -0.8px;
        color: var(--navy, #061a3d);
    }

    .error-description {
        max-width: 330px;
        margin: 0 auto;
        color: var(--muted, #63779c);
        font-size: 12.5px;
        line-height: 1.75;
        text-align: center;
    }

    .error-actions {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        align-items: stretch;
        gap: 10px;
        width: 100%;
        max-width: 345px;
        margin: 25px auto 0;
    }

    .home-button,
    .back-button {
        width: 100%;
        min-width: 0;
        min-height: 45px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        gap: 7px;
        white-space: nowrap;
        box-shadow: none;
    }

    .home-button {
        background: var(--navy, #061a3d);
        border-color: var(--navy, #061a3d);
        color: #ffffff;
    }

    .back-button {
        background: #f6f9fe;
        border-color: #dce6f5;
        color: var(--navy, #061a3d);
    }

    .home-button svg,
    .back-button svg {
        width: 15px;
        height: 15px;
    }

    .home-button .button-arrow {
        display: none;
    }

    .home-button:hover,
    .back-button:hover {
        transform: none;
        box-shadow: none;
    }

    .content-footer {
        display: none;
    }
}

@media (max-width: 360px) {
    .error-container {
        padding: 22px 17px;
    }

    .error-art {
        margin-bottom: 8px;
    }

    .art-inner {
        max-width: 180px;
    }

    .illustration svg {
        width: 165px;
        max-height: 170px;
    }

    .error-number {
        font-size: 80px;
        margin-bottom: 12px;
    }

    .error-content h1 {
        font-size: 23px;
    }

    .error-description {
        font-size: 12px;
    }

    .error-actions {
        grid-template-columns: 1fr;
        max-width: 260px;
        margin-top: 22px;
    }
}

@media (max-height: 650px) and (max-width: 700px) {
    .error-container {
        justify-content: flex-start;
    }

    .error-art {
        margin-bottom: 5px;
    }

    .illustration svg {
        width: 145px;
        max-height: 150px;
    }

    .error-number {
        font-size: 75px;
    }
}

</style>
