<script setup>
import { router, useForm } from '@inertiajs/vue3';
import Textinputs from '@/components/Textinputs.vue';
import PaginationLink from '@/components/PaginationLink.vue';
import SessionMessage from '@/components/SessionMessage.vue';
const props = defineProps({
    user:Object,
    userListings:Object,
    status:String
});

const params = route().params;
const form = useForm({
    search: params.search
})

const search = ()=>{
    router.get(route('user.show', {
        user: props.user.id,
        search: form.search,
        disapproved: params.disapproved
    }))
}

const showDiss = (e) =>{
    if (e.target.checked) {
        router.get(route('user.show', {
             user: props.user.id,
            search: params.search,
            disapproved: true
        }))
    } else {
         router.get(route('user.show', {
             user: props.user.id,
            search: params.search,
            disapproved: null
        }))
    }
}


const handleApprove = (listing)=>{

    const msg = listing.approved? 'Do you want to disapprove this listing?' : 'Do you want to approve this listing?';

    if (confirm(msg)) {
         router.put(route('admin.approve', listing.id));
    } 
   
}
</script>
<template>
    <Head :title="`${user.name} - listings`"/>
    
    <h1 class="text-3xl font-bold tracking-wide mb-2">{{ user.name }}'s listings</h1>
    <SessionMessage :status="status"/>
    <div class="flex justify-between items-center">

        <!-- search -->
        <div>
             <div class=" flex gap-2 items-center justify-end mx-2">
                    <Link v-if="params.search"  :href="route('user.show', {...params, user: user.id, search: null, page: null})" class="py-2 px-2 text-xs dark:text-slate-900 dark:bg-slate-300 bg-slate-400 flex items-center rounded-lg"><i class="fa-solid fa-xmark me-2"></i>{{ params.search }}</Link>
                    
                </div>
        </div>
        <!-- toggle -->

        <div class="flex justify-center items-center gap-3">
            <input type="checkbox" :checked="params.disapproved" @input="showDiss">
            <label for="">Show disapproved only</label>
        </div>
        <div>
             <form @submit.prevent="search" action="" class="flex">
                    <Textinputs v-model="form.search" type="search" placeholder="search...." class="flex justify-center items-center gap-2 w-full"/>
                </form>
        </div>
    </div>
    <table class="bg-white dark:bg-slate-800 overflow-hidden ring-1 w-full rounded-lg ring-slate-300">
        <thead>
            <tr  class="bg-slate-600 text-slate-300 uppercase text-left text-xs">
                <th class="4/6 p-3 ">Title </th>
                <th class="2/6 p-3">Approved</th>
                <th class="1/6 p-3">View</th>
              
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="listing in userListings.data" :key="listing.id">
                <td class="px-3 py-5">{{ listing.title }}</td>
                <td class=" px-3 py-5">
                    <button @click="handleApprove(listing)">
                        <i :class="listing.approved? 'fa-circle text-green-500':'fa-circle text-yellow-500'" class="fa-solid"></i>
                    </button>
                </td>
                <td class="">
                    <Link :href="route('listings.show', listing.id)" class="fa-solid fa-link text-indigo-500"> </Link>
                </td>
            </tr>
        </tbody>
        
     </table>

     <div class="mt-6">
        <PaginationLink :paginator="userListings"/>
     </div>

    
</template>