<script setup>
defineProps({
  uri: String,
  componentName: String
})
</script>

<template>
    <Link :href="route(uri)" class=" text-slate-100" :class="{'!text-pink-500 ': $page.component === componentName}">
        <slot></slot>
    </Link>
</template>