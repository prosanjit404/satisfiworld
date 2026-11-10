
<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';

defineProps({
    siteName: {
        type: String,
        default: '',
    },
});

const checking = ref(false);

function checkAgain() {
    if (checking.value) return;

    checking.value = true;

    router.reload({
        onFinish: () => {
            checking.value = false;
        },
    });
}
</script>

<template>
    <Head title="We'll Be Back Soon" />

    <main class="maintenance-page">
        <div class="maintenance-container">
            <div class="illustration">
                <svg viewBox="0 0 280 220" fill="none" aria-hidden="true">
                    <rect x="45" y="27" width="190" height="144" rx="12" fill="#FFFFFF" stroke="#C9D8F1" stroke-width="2"/>
                    <path d="M45 58H235" stroke="#C9D8F1" stroke-width="2"/>
                    <circle cx="62" cy="43" r="4" fill="#F50BA6"/>
                    <circle cx="76" cy="43" r="4" fill="#7A14F6"/>
                    <circle cx="90" cy="43" r="4" fill="#1549DC"/>
                    <rect x="62" y="77" width="58" height="8" rx="4" fill="#E4EBF8"/>
                    <rect x="62" y="93" width="42" height="6" rx="3" fill="#EDF2FB"/>
                    <rect x="62" y="116" width="53" height="34" rx="5" fill="#EEF3FC"/>
                    <rect x="126" y="116" width="43" height="34" rx="5" fill="#EEF3FC"/>
                    <rect x="180" y="116" width="38" height="34" rx="5" fill="#EEF3FC"/>
                    <circle cx="173" cy="104" r="46" fill="#E9EFFD" stroke="#FFFFFF" stroke-width="7"/>
                    <circle cx="173" cy="104" r="31" fill="#1549DC"/>
                    <path d="M173 82V104L188 113" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="173" cy="104" r="4" fill="#FFFFFF"/>
                    <path d="M100 173H180" stroke="#ADC1E4" stroke-width="5" stroke-linecap="round"/>
                    <path d="M140 173V189" stroke="#ADC1E4" stroke-width="5" stroke-linecap="round"/>
                    <path d="M112 189H168" stroke="#ADC1E4" stroke-width="5" stroke-linecap="round"/>
                    <path d="M221 88L231 78M236 105H249M222 124L232 134" stroke="#5540F5" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="47" cy="115" r="5" fill="#B0C7EF"/>
                    <circle cx="242" cy="159" r="4" fill="#D7E2F5"/>
                </svg>
            </div>

            <h1>We'll be back <span>soon.</span></h1>

            <p class="description">
                We're making some improvements to give you a better experience.
                Our website is temporarily unavailable, but we'll be back as soon as possible.
            </p>
            <div class="message-card">
                <div class="message-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <div>
                    <strong>Thank you for your patience</strong>
                    <span>Please check back in a little while.</span>
                </div>
            </div>

            <button class="retry-button" type="button" :disabled="checking" @click="checkAgain">
                <svg :class="{ spinning: checking }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 11a8 8 0 1 0-2.3 6M20 4v7h-7"/>
                </svg>
                {{ checking ? 'Checking...' : 'Check Again' }}
            </button>

        </div>
    </main>
</template>

<style scoped>
.maintenance-page {
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 36px 20px;
    background: var(--body, #edf3fb);
    color: var(--text, #12234a);
    font-family: Inter, system-ui, sans-serif;
}

.maintenance-page * {
    box-sizing: border-box;
}

.maintenance-container {
    width: 100%;
    max-width: 570px;
    text-align: center;
    padding: 50px 48px 36px;
    background: #fff;
    border: 1px solid var(--line, #e4ebf8);
    border-radius: var(--radius, 9px);
    box-shadow: 0 15px 45px rgba(6, 26, 61, .05);
    animation: contentEnter .5s ease both;
}

.illustration {
    max-width: 270px;
    margin: 0 auto 23px;
}

.illustration svg {
    display: block;
    width: 100%;
    height: auto;
}

.status-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    color: var(--blue, #1549dc);
    background: #eef3ff;
    border: 1px solid #dfe8ff;
    padding: 9px 13px;
    border-radius: 7px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.status-indicator {
    width: 7px;
    height: 7px;
    background: var(--blue, #1549dc);
    border-radius: 50%;
    animation: indicatorPulse 2s ease-in-out infinite;
}

h1 {
    margin: 23px 0 13px;
    font-size: clamp(30px, 5vw, 43px);
    font-weight: 600;
    line-height: 1.2;
    letter-spacing: -1.5px;
    color: var(--navy, #061a3d);
}

h1 span {
    color: var(--blue, #1549dc);
}

.description {
    max-width: 430px;
    margin: 0 auto;
    color: var(--muted, #63779c);
    font-size: 13px;
    line-height: 1.9;
}

.message-card {
    display: flex;
    align-items: center;
    gap: 13px;
    margin: 28px 0 22px;
    padding: 16px;
    border: 1px solid var(--line, #e4ebf8);
    border-radius: 8px;
    background: #f8faff;
    text-align: left;
}

.message-icon {
    flex-shrink: 0;
    width: 41px;
    height: 41px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #e7efff;
    color: var(--blue, #1549dc);
}

.message-icon svg {
    width: 22px;
    height: 22px;
}

.message-card strong,
.message-card span {
    display: block;
}

.message-card strong {
    font-size: 12px;
    font-weight: 750;
    color: var(--navy, #061a3d);
}

.message-card span {
    margin-top: 5px;
    font-size: 11px;
    color: var(--muted, #63779c);
    line-height: 1.5;
}

.retry-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-width: 165px;
    height: 46px;
    border: 1px solid var(--navy, #061a3d);
    border-radius: 8px;
    padding: 0 23px;
    color: #fff;
    background: var(--navy, #061a3d);
    font: inherit;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, transform .2s;
}

.retry-button:hover:not(:disabled) {
    background: var(--blue, #1549dc);
    border-color: var(--blue, #1549dc);
    transform: translateY(-2px);
}

.retry-button:disabled {
    opacity: .7;
    cursor: not-allowed;
}

.retry-button svg {
    width: 17px;
    height: 17px;
}

.spinning {
    animation: spin .8s linear infinite;
}

.page-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 9px;
    margin-top: 37px;
    padding-top: 20px;
    border-top: 1px solid var(--line, #e4ebf8);
    color: var(--muted, #63779c);
    font-size: 10px;
}

.page-footer > span:nth-child(2) {
    font-weight: 800;
    color: var(--navy, #061a3d);
}

.footer-dot {
    width: 7px;
    height: 7px;
    background: var(--blue, #1549dc);
    border-radius: 50%;
}

.footer-divider {
    height: 13px;
    width: 1px;
    background: #d5dfee;
}

@keyframes contentEnter {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes indicatorPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .4; }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 600px) {
    .maintenance-page {
        padding: 0;
        background: #fff;
        align-items: center;
    }

    .maintenance-container {
        max-width: 100%;
        min-height: 100dvh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 28px 23px;
        border: 0;
        border-radius: 0;
        box-shadow: none;
    }

    .illustration {
        width: 190px;
        margin: 0 auto 20px;
    }

    .status-label {
        font-size: 9px;
        letter-spacing: .6px;
    }

    h1 {
        font-size: 32px;
        margin-top: 19px;
    }

    .description {
        font-size: 12.5px;
        line-height: 1.8;
    }

    .message-card {
        width: 100%;
        max-width: 380px;
        padding: 13px;
        margin: 24px 0 20px;
    }

    .retry-button {
        width: 100%;
        max-width: 380px;
    }

    .page-footer {
        margin-top: 35px;
        width: 100%;
    }
}

@media (prefers-reduced-motion: reduce) {
    .maintenance-container,
    .status-indicator {
        animation: none;
    }
}
</style>
