<script setup>
import PaginationLink from '@/components/PaginationLink.vue';
import UserRoleSelect from '@/Components/UserRoleSelect.vue';
import SessionMessage from '@/components/SessionMessage.vue';
import Textinputs from '@/components/Textinputs.vue';
import { useForm, router } from '@inertiajs/vue3';
import { watch } from 'vue';
defineProps({
    users: Object,
    status: String
})
const params = route().params;
const form = useForm({search: params.search, roleFilter: params.roleFilter || 'Role'});

const submit = ()=>{
    router.get(route('admin.index'), {...params, search: form.search});
}
const filterRole = ()=>{
    router.get(route('admin.index'), {...params, roleFilter: form.roleFilter});
}

watch(()=>params.roleFilter, ()=>{
    console.log(params.roleFilter)
})
</script>


<template>
    <Head title="Admin"/>
    <!-- heading -->
    <SessionMessage :status="status"/>
     <h1 class="font-bold text-3xl  mb-3">User Listings</h1>
     <div class="flex justify-between items-center">
       
        <div class="flex justify-start items-center gap-3 text-xs mb-2">
            <p>
                Approved
                 <i class="fa-solid fa-circle text-green-500"></i>
            </p>
            <p>
                Pending
                 <i class="fa-solid fa-circle text-yellow-500"></i>
            </p>
        </div>
            <div class="flex items-center">
                <div class=" flex gap-2 items-center justify-end mx-2">
                    <Link v-if="params.search"  :href="route('admin.index', {...params, search: null, page: null})" class="py-2 px-2 text-xs dark:text-slate-900 dark:bg-slate-300 bg-slate-400 flex items-center rounded-lg"><i class="fa-solid fa-xmark me-2"></i>{{ params.search }}</Link>
                    <Link v-if="params.roleFilter"  :href="route('admin.index', {...params, roleFilter: null, page: null})" class="py-2 px-2 text-xs dark:text-slate-900 dark:bg-slate-300 bg-slate-400 flex items-center rounded-lg"><i class="fa-solid fa-xmark me-2"></i>{{ params.roleFilter }}</Link>
                </div>

                <!-- funnel -->
                <div class="w-3/1 flex items-center gap-1">
                    <i class="fa-solid fa-filter"></i>
                    <form @change="filterRole" action="">
                        <select v-model="form.roleFilter" class="p-1 text-xs rounded-lg shadow-lg bg-slate-500 dark:bg-slate-700 text-slate-300">
                            <option selected disabled value="Role">Role</option>
                            <option value="general">General</option>
                            <option value="suspended">Suspended</option>
                            <option value="admin">Admin</option>
                        </select>
                    </form>
                </div>
                <form @submit.prevent="submit" action="" class="flex">
                    <Textinputs v-model="form.search" type="search" placeholder="search...." class="flex justify-center items-center gap-2 w-full"/>
                </form>
            </div>
     </div>
    
    <!-- table -->

     <table class="bg-white dark:bg-slate-800 overflow-hidden ring-1 w-full rounded-lg ring-slate-300">
        <thead>
            <tr  class="bg-slate-600 text-slate-300 uppercase text-left text-xs">
                <th class="3/6 p-3">Name</th>
                <th class="2/6 p-3">Role</th>
                <th class="1/6 p-3">Listings</th>
                <th class="1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody v-if="Object.keys(users.data).length" class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="user in users.data" :key="user.id">
                <td class="w-3/6 py-6 px-3">
                    <p class="font-bold mb-1">{{ user.name }}</p>
                    <p class="font-light text-xs">{{ user.email }}</p>
                </td>

                <td class="w-2/6 py-6 px-3">
                    
                    <UserRoleSelect :user="user"/>

                </td>

                <td class="w-1/6 py-6 px-3">
                    <div class="flex gap-1 items-center text-xs">
                        <p class="flex items-center gap-1">
                            {{ user.listings.filter((l)=> l.approved).length }}
                            <i class="fa-solid fa-circle text-green-500"></i>
                        </p>
                        <p class="flex items-center gap-1">
                            {{ user.listings.filter((l)=> !l.approved).length }}
                            <i class="fa-solid fa-circle text-yellow-500"></i>
                        </p>
                    </div>
                </td>

                <td class="w-1/6 py-6 px-3 text-right">
                   <Link class="fa-solid fa-link text-indigo-500 hover:opacity-65 transition-all drop-shadow-2xl" :href="route('user.show', user.id )"></Link>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr class="w-full text-left p-4">
                <td class="w-full p-5">No data found.</td>
            </tr>
        </tbody>
     </table>

     <div class="mt-6">
        <PaginationLink :paginator="users"/>
     </div>
</template>