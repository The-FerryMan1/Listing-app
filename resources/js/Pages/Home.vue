<script setup>
import { useForm, router } from '@inertiajs/vue3';
import Card from '../Components/Card.vue';
import PaginationLink from '../Components/PaginationLink.vue';
import Textinputs from '@/Components/Textinputs.vue';

const params = route().params;
const props = defineProps({
    listings: Object,
    searchTerm: String
})
const form = useForm({
    search: props.searchTerm
})

const search =()=>{
    router.get(route('home'), {search: form.search, user_id: params.user_id,  tag: params.tag});
}

const username = params.user_id ? props.listings.data.find((id) => id.user_id === Number(params.user_id)).user.name :null;
</script>

<template>
    <Head title="Home"/>
    
    <div class="flex justify-between items-center mb-4">
        <div class="flex justify-start items-center gap-4">  
            <Link v-if="params.tag" :href="route('home', {...params, tag: null, page: null})" class="p-2 bg-slate-800 flex justify-center items-center gap-2 rounded-lg hover:opacity-50 transition-all">
                {{ params.tag }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
            <Link v-if="params.search" :href="route('home', {...params, page: null, search: null})" class="p-2 bg-slate-800 flex justify-center items-center gap-2 rounded-lg hover:opacity-50 transition-all">
                {{ params.search }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
            <Link v-if="params.user_id" :href="route('home', {...params, page: null, user_id: null})" class="p-2 bg-slate-800 flex justify-center items-center gap-2 rounded-lg hover:opacity-50 transition-all">
                {{ username }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
        </div>
        <div class="w-1/4">
            <form @submit.prevent="search" >
                <Textinputs type="search" icon="" iconStyle="" placeholder="search..." v-model="form.search"/>
            </form>
        </div>
    </div>
    <div v-if="Object.keys(listings.data).length" >
        <div class="grid md:grid-cols-3 grid-cols-1 gap-5">
            <div v-for="list in listings.data" :key="list" class="" >
                <Card :list="list"/>
            </div>
        </div>
         <div class="mt-10">
            <PaginationLink :paginator="listings"/>
            </div>
     </div>
     <div v-else>
        No listings have found
     </div>
    
</template>