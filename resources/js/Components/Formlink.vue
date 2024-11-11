<script setup>
defineProps({
    uri: String
})
</script>


<template>
    <Link :href="route(uri)"  class="text-sm tracking-wider underline font-semibold p-2 my-3 text-blue-500">
        <slot></slot>
    </Link>
</template>