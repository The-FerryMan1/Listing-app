<script setup>
defineProps({listings: Object, status:String});
import { router } from '@inertiajs/vue3';
import PaginationLink from '@/components/PaginationLink.vue'
import SessionMessage from '@/components/SessionMessage.vue'
const deleteListing = (id)=>{
   
    if(confirm('Are you use you want to delete this listing?')){
        router.delete(route('listings.destroy', id));
        
    }
}
</script>

<template>
   
    <Head title="Dashboard"/>
    <SessionMessage :status="status"/>
    <div v-if="listings">
        <div v-if="Object.keys(listings.data).length">
            <!-- heading -->
             <div>
                <div class="flex item-center justify-between mb-4">
                <h1  class="text-3xl font-semibold tracking-wide ">Your latest listings</h1>
                <div class="flex text-xs justify-between gap-5 items-center ">
                    <p>
                        <i class="fa-solid fa-circle-check text-green-500 p-2"></i>
                        Approved
                    </p>
                    <p>
                        <i class="fa-solid fa-circle text-yellow-500 p-2"></i>
                        Pending
                    </p>
                </div>
             </div>

             <!-- Table -->
            
              <table class="table-fix overflow-hidden border-collapse rounded-md ring-1 text-sm dark:ring-slate-500 bg-white shadow-lg">
                    <thead class="uppercase text-xs text-slate-600 dark:bg-slate-900 dark:text-slate-400 p-2 bg-slate-300">
                        <tr>
                            <th class="w-3/4 p-3 text-left">Listing title</th>
                            <th class="w-1/4 py-3 pr-3 text-right">view</th>
                            <th class="w-1/5 py-3 pr-3 text-right">edit</th>
                            <th class="w-1/5 py-3 pr-3 text-right">delete</th>
                       
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="listing in listings.data" :key="listing.id" class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-600 dark:border-slate-600">

                            <td class="w-3/4 p-3 text-left">
                                <div class="flex items-center gap-3">
                                   
                                    <img class="w-12 h-12 object-cover rounded-md"  :src="listing.image ? `/storage/${listing.image}`:'/storage/images/listings/alice gou devil woman cry baby2.png'" :alt="listing.image">
                                    <h4 class="flex items-center gap-3">
                                        <i :class="`fa-solid fa-${listing.approved? 'circle-check text-green-500' :'circle text-yellow-500'}`"></i>
                                        {{ listing.title }}
                                    </h4>
                                </div>
                            </td>

                            <td class="w-1/4 py-3 pr-3 text-right text-indigo-400 underline">
                                <Link  v-if="listing.approved" :href="route('listings.show', listing.id)">View</Link>
                            </td>
                            <td class="w-1/5 py-3 pr-3 text-right text-indigo-400 underline">
                                <Link  :href="route('listings.edit', listing.id)">Edit</Link>
                            </td>
                            <td class="w-1/5 py-3 pr-3 text-right text-indigo-400 underline">
                                <button class="underline" @click="deleteListing(listing.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
              </table>
             </div>
             <div class="mt-10">
                <PaginationLink :paginator="listings"/>
             </div>
        </div>
        <div v-else>
            No listings have found.
        </div>
    </div>
    <div v-else>
        <h2>We regret to inform you that your account has been suspended due to violation of our terms of service.</h2>
        <a href="">Please contact us.</a>
    </div>
    
</template>