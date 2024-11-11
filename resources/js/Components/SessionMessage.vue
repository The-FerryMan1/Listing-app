<script setup>
defineProps({
    status: String
})
</script>


<template>
   <p v-if="status" class="text-green-500">{{ status }}</p>
</template>