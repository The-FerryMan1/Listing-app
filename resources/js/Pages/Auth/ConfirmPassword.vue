<script setup>

import Container from '@/Components/Container.vue';
import Textinputs from '@/Components/Textinputs.vue';
import Primarybutton from '@/Components/Primarybutton.vue';
import Errormessage from '@/Components/Errormessage.vue';
import Formtitle from '@/Components/Formtitle.vue';
import { useForm } from '@inertiajs/vue3';


const formData = useForm({
    password: null,
})

const handleSubmit = () =>{
    formData.post(route('password.confirm'), {
        onFinish: ()=>formData.reset()
    })
}
</script>


<template>
    <Head title="Confirm password"/>
    <Container class="w-[70%]">
        <div class="p-5 flex justify-center items-center">

            <form @submit.prevent="handleSubmit" class=" w-full grid grid-cols-1 place-items-center ">
                <Formtitle>Comnfirm Password</Formtitle>

                <Errormessage :errors="formData.errors"/>
            
                <Textinputs type="password" name="Password" icon="lock" iconStyle="solid" v-model="formData.password" placeholder="*********" />

                <Primarybutton btnType="submit" :disabled="formData.processing">Confirm</Primarybutton>
            </form>
            
        </div>
      
    </Container>
        
     
    
</template>