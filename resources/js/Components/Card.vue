<script setup>
import { router } from '@inertiajs/vue3';
const params = route().params;
defineProps({
    list: Object,
})


const userSearch = (id)=>{
    router.get(route('home'), {user_id: id, search:params.search, tag: params.tag})
}

const searchTag = (tag)=>{
    router.get(route('home'), {user_id: params.user_id, search:params.search, tag: tag})
}
</script>

<template>
    <div class=" dark:bg-slate-800 rounded-md shadow-lg overflow-hidden flex flex-col justify-between h-full">
        <!-- image -->
        <section>
            <Link :href="route('listings.show', list.id)" class="w-full h-48 rounded-lg" >
                <img class="object-cover" :src="list.image?(`/storage/${list.image}`):('/storage/images/listings/Alice gou devil woman cry baby2.png')" alt="">
            </Link>
        </section>
        <!-- title & user -->
        <section class="p-4">
            <h3 class="font-semibold text-lg mb-2 text-nowrap truncate">{{ list.title }}</h3>
            <small 
                class="text-slate-400 ">
                Listed on 
                {{ new Date(list.created_at).toLocaleDateString() }} 
                by 
                <button @click="userSearch(list.user.id)" class="underline decoration-blue-300 text-green-500">{{ list.user.name }}</button>
                </small>
        </section>

        <!-- tags -->
        <section>
            <div v-if="list.tags" class="flex justify-start items-center px-4 py-2 space-x-2 overflow-x-auto">
                <button  v-for="(tags, index) in list.tags.split(',')" :key="index" @click="searchTag(tags)" class="text-sm   text-slate-300 text-nowrap bg-green-700 p-1.5 rounded-md hover:opacity-50 transition-all ">
                    {{ tags }}
                </button>
            </div>
        </section>
    </div>
</template>