<script setup>
import { themeSwitch } from '../darkmode';
import Navlinks from '../Components/Navlinks.vue';
import Dropdown from '../Components/Dropdown.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(()=>page.props.auth.user);
</script>

<template>
        <header class=" bg-slate-800 flex justify-between text-white items-center">
            <div class="ms-4">
                 <Link :href="route('home')" class="text-2xl font-bold tracking-wider uppercase" >Listing</Link>
            </div>
           
            <nav class="flex space-x-10 p-6 ">

                <!-- nav links -->
                <Navlinks uri="home" componentName="Home">Home</Navlinks>
                
                <div v-if="user" class="space-x-10 flex">
                        
                        <Dropdown :user="user">
                            <Navlinks uri="listings.create" componentName="Auth/Listings/Create" class="hover:opacity-40">Create</Navlinks>
                            <Navlinks uri="dashboard" componentName="Auth/Dashboard" class="hover:opacity-40">Dashboard</Navlinks>
                            <Navlinks uri="profile.edit" componentName="Auth/Profile" class="hover:opacity-40">Settings</Navlinks>
                            <Link :href="route('logout')" as="button" method="post" class="text-slate-100 hover:opacity-40">Logout</Link>
                        </Dropdown>
                         <Link v-if="user.role === 'admin'" :href="route('admin.index')" :class="{'!text-pink-500': page.component === 'Admin/AdminDashboard'}"><i class="fa-solid fa-lock hover:opacity-50"></i></Link>
                </div>
                <div v-else class="space-x-10">
                    <Navlinks uri="register" componentName="Register">Register</Navlinks>
                    <Navlinks uri="login" componentName="Login">Login</Navlinks>
                   
                </div>


                <!-- dark mode -->
                <div>
                    <button @click="themeSwitch()" class="hover:opacity-30 transition-all">
                        <i class="fa-solid fa-circle-half-stroke"></i>
                    </button>
                </div>
            </nav>
            
        </header>
        <main class="p-6 mx-auto max-w-screen-lg ">
           <slot></slot>
        </main>
  
</template>