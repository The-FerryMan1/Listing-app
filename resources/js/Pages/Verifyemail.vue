<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '@/Components/Container.vue';
import Primarybutton from '@/Components/Primarybutton.vue';

defineProps({
    message: String
})

const formData = useForm({});

const submit = ()=>{
    formData.post(route('verification.send'))
}
</script>
<template>
    <Head title="Email-Verification"/>

    <Container class="w-1/2">
        <div>
            <p>Verify your email first</p>
        </div>

        <p v-if="message">{{ message }}</p>
        <form @submit.prevent="submit">
            <Primarybutton btnType="submit">Resend Verification Email</Primarybutton>
        </form>
    </Container>
</template>