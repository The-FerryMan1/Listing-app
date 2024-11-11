<script setup>
import Container from '@/Components/Container.vue'
import Formtitle from '@/Components/Formtitle.vue'
import Textinputs from '@/components/Textinputs.vue'
import Primarybutton from '@/Components/Primarybutton.vue';
import Errormessage from '../../../../Components/Errormessage.vue';
import { router, useForm } from '@inertiajs/vue3';



const formData = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})


const submitHandler = () =>{
    formData.put(route('ProfileUpdate.password'), {
        onSuccess: ()=>formData.reset(),
        onError: ()=>formData.reset(),
        preserveScroll: true,
    })
}


</script>


<template>
    <Head title="update-information"/>

    <Container class="w-[80%]">
         <div class="p-5 flex flex-col justify-center items-center">
            <div class="text-center">
                <Formtitle>Change password</Formtitle>
                <p v-if="formData.recentlySuccessful" class="text-green-500">Your password has been changed.</p>
                
            </div>
       
        <form @submit.prevent="submitHandler" class=" w-full grid grid-cols-1 place-items-center "  >
            <Errormessage :errors="formData.errors"/>
            <Textinputs type="password" name="Current password" icon="lock" iconStyle="solid" v-model="formData.current_password" placeholder="Current password"/>
            <Textinputs type="password" name="Password" icon="lock" iconStyle="solid" v-model="formData.password" placeholder="New password" />
            <Textinputs type="password" name="Confirm password" icon="lock" iconStyle="solid" v-model="formData.password_confirmation" placeholder="Confirm password" />
            <Primarybutton btnType="submit" :disabled="formData.processing">Change password</Primarybutton>
        </form>
         </div>
        
    </Container>


    
</template>