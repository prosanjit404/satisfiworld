
import { ref, computed } from 'vue';

const toast = ref({
    id: 0,
    show: false,
    message: '',
    type: 'success',
    icon: 'success',
    duration: 3000,
    remaining: 3000,
    paused: false,
});

let toastTimer = null;
let startedAt = 0;
let toastId = 0;

function clearToastTimer() {
    if (toastTimer !== null) {
        clearTimeout(toastTimer);
        toastTimer = null;
    }
}

function startToastTimer() {
    clearToastTimer();

    if (!toast.value.show || toast.value.paused) return;

    if (toast.value.remaining <= 0) {
        toast.value.show = false;
        return;
    }

    const currentId = toast.value.id;
    startedAt = performance.now();

    toastTimer = setTimeout(() => {
        if (toast.value.id !== currentId || toast.value.paused) return;

        toast.value.show = false;
        toast.value.remaining = 0;
        toastTimer = null;
    }, toast.value.remaining);
}

export function useLocalToast() {
    const paused = computed(() => toast.value.paused);

    const showToast = (
        message,
        type = 'success',
        icon = null,
        duration = 3000
    ) => {
        clearToastTimer();

        const ms = Number(duration);
        const safeDuration = Number.isFinite(ms) && ms > 0 ? ms : 3000;

        toast.value = {
            id: ++toastId,
            show: true,
            message,
            type,
            icon: icon ?? type,
            duration: safeDuration,
            remaining: safeDuration,
            paused: false,
        };

        startToastTimer();
    };

    const pauseToast = () => {
        if (!toast.value.show || toast.value.paused) return;

        clearToastTimer();

        const elapsed = performance.now() - startedAt;

        toast.value.remaining = Math.max(
            0,
            toast.value.remaining - elapsed
        );

        toast.value.paused = true;
    };

    const resumeToast = () => {
        if (!toast.value.show || !toast.value.paused) return;

        toast.value.paused = false;
        startToastTimer();
    };

    const hideToast = () => {
        clearToastTimer();

        toast.value.show = false;
        toast.value.paused = false;
        toast.value.remaining = 0;
    };

    return {
        toast,
        paused,
        showToast,
        pauseToast,
        resumeToast,
        hideToast,
    };
}
