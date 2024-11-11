<script setup>
import Container from '@/Components/Container.vue'
import Formtitle from '@/Components/Formtitle.vue'
import Textinputs from '@/components/Textinputs.vue'
import Primarybutton from '@/Components/Primarybutton.vue';
import { router, useForm } from '@inertiajs/vue3';

const userAuth = defineProps({
    user: Object
})

const formData = useForm({
    name: userAuth.user.name,
    email: userAuth.user.email,
})


const submitHandler = () =>{
    formData.patch(route('profile.update'))
}

const resendEmailVerHandler = (e) =>{
    router.post(route('verification.send'), {}, {
        onStart: ()=> (e.target.disabled = true),
        onFinish:  ()=> (e.target.disabled = false),
    })
}
</script>


<template>
    <Head title="update-information"/>

    <Container class="w-[80%]">
         <div class="p-5 flex flex-col justify-center items-center">
            <div class="text-center">
                <Formtitle>Update information</Formtitle>
                <p>Update your name and email</p>
            </div>
       
        <form @submit.prevent="submitHandler" class=" w-full grid grid-cols-1 place-items-center "  >
            <Textinputs type="text" name="Name" icon="user" v-model="formData.name" placeholder="Jon doe"/>
            <Textinputs type="text" name="Email" icon="envelope" v-model="formData.email" placeholder="JonDoe@example.net" />
           
            <div v-if="!userAuth.user.email_verified_at" class="flex gap-5">
                <p class="text-red-600">Your email is not verified.</p>
                <button @click="resendEmailVerHandler" class="underline disabled:text-slate-600 text-blue-500" >
                    Click here to resend verification email.
                </button>
            </div>

            <Primarybutton btnType="submit" :disabled="formData.processing">Submit</Primarybutton>
        </form>
         </div>
        
    </Container>


    
</template>