<script setup>
defineProps({user: Object});
</script>


<template>
    <details class="cursor-pointer space-y-5 relative ">
        <summary>{{ user.name }}</summary>
        <div class="space-y-6  shadow-lg absolute p-3 flex flex-col items-start *:ms-3 right-0 w-[150px] text-center rounded-md border border-slate-700 bg-slate-800">
          <slot></slot>
        </div>
    </details>
</template>