<script setup>
import Container from "../Components/Container.vue";
import Textinputs from "../Components/Textinputs.vue";
import Primarybutton from "../Components/Primarybutton.vue";
import Errormessage from "../Components/Errormessage.vue";
import Formtitle from "../Components/Formtitle.vue";
import SessionMessage from "../Components/SessionMessage.vue";
import { useForm } from "@inertiajs/vue3";


defineProps({status: String});
const formData = useForm({
    email: null,
});

const handleSubmit = () => {
    formData.post(route("password.email"));
};
</script>

<template>
    <Head title="Reset-Password" />
    <Container class="w-[70%]">
        <div class="p-5 flex justify-center items-center">
           
            <form
                @submit.prevent="handleSubmit"
                class="w-full grid grid-cols-1 place-items-center space-y-10"
            >
            <Formtitle>Reset password</Formtitle>
             <div>
                <p>
                    To reset your password, please enter your email address in
                    the field provided. Note: Only valid email addresses will be
                    accepted. Once you submit your email, you will receive an
                    email with a link to reset your password. Click the link in
                    the email to complete the password reset process.
                </p>
            </div>
                

                <Errormessage :errors="formData.errors" />
                <SessionMessage :status="status"/>

                <Textinputs
                    type="text"
                    name="Email"
                    icon="envelope"
                    v-model="formData.email"
                    placeholder="JonDoe@example.net"
                />

                <Primarybutton btnType="submit" :disabled="formData.processing"
                    >Confirm</Primarybutton
                >
            </form>
        </div>
    </Container>
</template>
