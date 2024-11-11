<script setup>

import Container from '../Components/Container.vue';
import Textinputs from '../Components/Textinputs.vue';
import Primarybutton from '../Components/Primarybutton.vue';
import Errormessage from '../Components/Errormessage.vue';
import Formtitle from '../Components/Formtitle.vue';
import Formlink from '../Components/Formlink.vue';
import SessionMessage from '../Components/SessionMessage.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({status:String})

const formData = useForm({
    email: null,
    password: null,
    remember: null,
})

const handleSubmit = () =>{
    formData.post(route('login'), {
        onError: ()=> formData.reset('password'),
        onFinish: ()=>formData.reset('password')
    })
}
</script>


<template>
    <Head title="Login"/>
    <Container class="w-[70%]">
        <div class="p-5 flex justify-center items-center">
            <div>
                
            </div>
           
            <form @submit.prevent="handleSubmit" class=" w-full grid grid-cols-1 place-items-center ">
                <Formtitle>Login</Formtitle>
                <Errormessage :errors="formData.errors"/>
                <SessionMessage :status="status"/>
                <Textinputs type="text" name="Email" icon="envelope" v-model="formData.email" placeholder="JonDoe@example.net" />
                <Textinputs type="password" name="Password" icon="lock" iconStyle="solid" v-model="formData.password" placeholder="*********" />
                <div class="flex justify-between items-center w-[70%]">
                     <div class="space-x-3 flex justify-center items-center">
                        <label for="remember">Remember</label>
                        <input type="checkbox" name="" id="remember" v-model="formData.remember">
                    </div>
                    <Formlink uri="password.request">Forgot password?</Formlink>
                </div>
               
                
                <Formlink uri="register">Create an account</Formlink>
                <Primarybutton btnType="submit" :disabled="formData.processing">Confirm</Primarybutton>
            </form>
            
        </div>
      
    </Container>
        
     
    
</template>