<script>
import CloseSvg from '../../Svg/CloseSvg.vue';

export default {
    name: 'DangerButton',
    components: { CloseSvg },
    props: {
        text: String,
        disabledButton: Boolean,
    },
};
</script>

<template>
    <button
        type="button"
        class="inline-flex min-w-32 cursor-pointer items-center justify-center rounded-sm border-b-2 border-red-500 bg-black px-4 py-2 font-bold text-white shadow-md hover:border-red-600 hover:bg-red-500 hover:text-black disabled:opacity-60"
        :disabled="disabledButton"
    >
        <span class="mr-2">{{ text }}</span>
        <CloseSvg classes="size-6" />
    </button>
</template>
