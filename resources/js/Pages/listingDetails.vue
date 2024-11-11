<script setup>
import Container from '@/Components/Container.vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean
})



const deleteButton =()=>{
    if(confirm('Are you sure you want delete this listing?')){
        console.log(props.listing.id)
        router.delete(route('listings.destroy', props.listing.id))
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
   <Head title="Listing details"/>


    <div v-if="$page.props.auth.user.role === 'admin'" class="flex justify-between items-center py-3 px-4 bg-slate-700 mb-4 rounded-lg text-white">
        <p class="flex gap-2 items-center">This listing is {{ listing.approved? 'Approved':'Pending or disapproved' }} <i :class="`fa-solid fa-${listing.approved? 'circle text-green-500': 'circle text-yellow-500'}`"></i></p>

        <button @click="handleApprove(listing)" class="ring-1 p-2 rounded-md bg-slate-300 dark:bg-slate-500 text-slate-900 dark:text-white">
            {{ listing.approved? 'Dissapprove':'Approve' }}
        </button>
    </div>

   <Container class="flex gap-4">
        <div class="w-1/4 overflow-hidden rounded-md drop-shadow-2xl " >
            <img :src="listing.image? `/storage/${listing.image}`:'/storage/images/listings/Alice gou devil woman cry baby2.png' " alt="" class="h-full w-full object-cover object-center ">
        </div>

        <div class="w-full">
           <div class="flex justify-between items-center border-b border-slate-500">
                <h3 class="text-base font-normal text-slate-500 flex gap-2 items-center justify-start"> <i class="fa-solid fa-circle-info"></i>Listing info</h3>

                <div v-if="canModify" class="mb-2 flex justify-center items-center gap-3 dark:text-white text-white">
                    
                  <Link class=" bg-blue-800 p-2 flex gap-2 items-center rounded-md hover:opacity-50 transition-all shadow-md"  :href="route('listings.edit', listing.id)">
                    <i class="fa-solid fa-pen"></i>
                    Edit
                 </Link>
                  <button @click="deleteButton" type="button" class="flex gap-2 items-center bg-red-800 rounded-md hover:opacity-50 transition-all p-2 shadow-md">
                        <i class="fa-solid fa-trash"></i>
                        Delete
                  </button>
                </div>
            </div>

            <div class="py-4">
                <!-- title -->
                <div class="mb-4">
                    <h2 class="font-semibold text-2xl">{{ listing.title }}</h2>
                </div>
                <!-- descriptions -->
                <div class="mb-4">
                    <p>{{ listing.desc }}</p>
                </div>

                <!-- Contact -->
                <div class="flex flex-col space-y-2 my-5">
                    <h3 class="text-base font-normal text-slate-500 border-b border-slate-500 mb-3 flex gap-2 items-center justify-start"> <i class="fa-solid fa-address-book"></i>Contact info</h3>

                    <!-- email -->
                    <div v-if="listing.email" class="flex gap-2 justify-start items-center">
                        <i class="fa-solid fa-at"></i>
                        <p>Email:</p>
                        <a :href="`mailto:${listing.email}`" class="underline decoration-blue-500 text-blue-500 hover:opacity-50 transition-all">{{ listing.email }}</a>
                    </div>

                    <!-- links -->
                    <div v-if="listing.link" class="flex gap-2 justify-start items-center">
                        <i class="fa-solid fa-up-right-from-square"></i>
                        <p>External link:</p>
                        <a :href="listing.link" target="_blank" class="underline decoration-blue-500 text-blue-500 hover:opacity-50 transition-all">{{ listing.link }}</a>
                    </div>
                    <div class="flex gap-2 justify-start items-center">
                        <i class="fa-solid fa-circle-user"></i>
                        <p>Listed by:</p>
                        <Link :href="route('home', {user_id: user.id})" class="underline decoration-blue-500 text-blue-500 hover:opacity-50 transition-all">{{ user.name}}</Link>
                       
                    </div>
                </div>

                <!-- tags -->
                <div v-if="listing.tags" class="my-5">
             
                    <h3 class="text-base font-normal text-slate-500 border-b border-slate-500 mb-3 flex gap-2 items-center justify-start"> <i class="fa-solid fa-tag"></i>Tags</h3>
                    <div class="flex gap-2 text-nowrap text-slate-300 overflow-x-auto">
                        <Link :href="route('home', {tag: tag})" v-for="tag, i in listing.tags.split(',')" :key="i" class="p-2 bg-slate-700 rounded-md hover:bg-green-500 transition-all">{{ tag }}</Link>
                    </div>
                    
                </div>
            </div>
        </div>

        
   </Container>
</template>