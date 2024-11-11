<script setup>

import Container from '../Components/Container.vue';
import Textinputs from '../Components/Textinputs.vue';
import Primarybutton from '../Components/Primarybutton.vue';
import Errormessage from '../Components/Errormessage.vue';
import Formtitle from '../Components/Formtitle.vue';
import Formlink from '../Components/Formlink.vue';
import { useForm } from '@inertiajs/vue3';

const formData = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const handleSubmit = () =>{
    formData.post(route('register'), {
        onError: ()=> formData.reset('password','password_confirmation' ),
        onSuccess: ()=>formData.reset('password','password_confirmation' )
    })
}
</script>


<template>
    <Head title="Register"/>
    <Container class="w-[70%]">
        <div class="p-5 flex justify-center items-center">
            <div>
                
            </div>
           
            <form @submit.prevent="handleSubmit" class=" w-full grid grid-cols-1 place-items-center ">
                <Formtitle>Register an account</Formtitle>

                <Errormessage :errors="formData.errors"/>
                <Textinputs type="text" name="Name" icon="user" v-model="formData.name" placeholder="Jon doe"/>
                <Textinputs type="text" name="Email" icon="envelope" v-model="formData.email" placeholder="JonDoe@example.net" />
                <Textinputs type="password" name="Password" icon="lock" iconStyle="solid" v-model="formData.password" placeholder="*********" />
                <Textinputs type="password" name="Confirm password" icon="lock" iconStyle="solid" v-model="formData.password_confirmation" placeholder="********" />

                <Formlink uri="login">already a user?</Formlink>

                <Primarybutton btnType="submit" :disabled="formData.processing">Confirm</Primarybutton>
            </form>
            
        </div>
      
    </Container>
        
     
    
</template>