<script setup>

const model = defineModel({
    required: true
});

defineProps({
    name:{
        type: String,
        default: ""
    },
    placeholder:{
        type: String,
        default: ""
    },
    icon: String,
    iconStyle: {
        type: String,
        default: 'regular'
    }

})
</script>


<template>
    <div class="w-[70%]">
        <i class="mx-2" :class="`fa-${iconStyle} fa-${icon}`"></i>
        <label :for="name" class="text-md " >{{ name }}</label>
        <textarea  class="w-full h-32 rounded-md p-2 text-black my-2 border-2 resize-none "  name="" :id="name" v-model="model" :placeholder="placeholder"></textarea>
        
    </div>
</template>