<script setup>
import Container from '@/Components/Container.vue'
import Formtitle from '@/Components/Formtitle.vue'
import Textinputs from '@/components/Textinputs.vue'
import Primarybutton from '@/Components/Primarybutton.vue';
import Errormessage from '../../../../Components/Errormessage.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const show = ref(false);

const formData = useForm({
    password: '',
})


const submitHandler = () =>{
    formData.delete(route('account.destroy'), {
        onSuccess: ()=>formData.reset(),
        onError: ()=>formData.reset(),
        preserveScroll: true,
    })
}


</script>


<template>


    <Container class="w-[80%]">
         <div class="p-5 flex flex-col justify-center items-center">
            <div class="text-center mb-3">
                <Formtitle>Delete Acoount</Formtitle>
                <p class="dark:text-white">Once your account is deleted, all of its data, resources in the system will be permanently erased. This action cannot ve undone.</p>
                
            </div>
       <div class="w-full" v-if="show">
         <form @submit.prevent="submitHandler" class=" w-full grid grid-cols-1 place-items-center "  >
            <Errormessage :errors="formData.errors"/>
           
            <Textinputs type="password" name="Password" icon="lock" iconStyle="solid" v-model="formData.password" placeholder="New password" />
            <Primarybutton btnType="submit" :disabled="formData.processing" class="!bg-red-500">
                 <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Confirm
            </Primarybutton>
            <button @click="show = false" class="bg-slate-500 py-2 px-3 rounded-md drop-shadow-md w-[50%]">
                Cancel
            </button>
        </form>
       </div>
       <div v-else>
            <button @click="show = true" class="bg-red-500 py-2 px-3 rounded-md drop-shadow-md ">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Delete this account
            </button>
       </div>
       
         </div>
        
    </Container>


    
</template>