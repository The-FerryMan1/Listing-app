<script setup>
defineProps({
    errors: Object
})
</script>

<template>
      <small v-if="Object.keys(errors).length !== 0" class="text-red-500">
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
        </small>
</template>