<script setup>
defineProps({
    btnType:{
        type: String,
        default: 'button'
    }
})
</script>

<template>
    <button :type="btnType" class="w-1/2 p-2 text-md bg-blue-500 dark:bg-blue-800 my-5 rounded-md hover:opacity-45 transition-all disabled:bg-slate-300 disabled:cursor-wait">
        <slot></slot>
    </button>
</template>