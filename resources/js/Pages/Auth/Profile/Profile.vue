<script setup>
import UpdateInfo from './Partials/UpdateInfo.vue';
import PasswordUpdate from './Partials/PasswordUpdate.vue';
import DeleteAccount from './Partials/DeleteAccount.vue';
defineProps({user:Object}) 
</script>




<template>
    <Head title="Profile-settings"/>
    <div class="space-y-2">
         <UpdateInfo :user="user"/>
        <PasswordUpdate/>
        <DeleteAccount/>
    </div>
   
</template>