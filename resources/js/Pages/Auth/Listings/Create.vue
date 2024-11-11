<script setup>
import Container from '@/Components/Container.vue';
import Textinputs from '@/Components/Textinputs.vue';
import Primarybutton from '@/Components/Primarybutton.vue';

import Imageholder from '../../../Components/Imageholder.vue';
import Formtitle from '@/Components/Formtitle.vue';
import Textarea from '../../../Components/Textarea.vue';
import { useForm } from '@inertiajs/vue3';


//    'title',
//         'desc',
//         'tags',
//         'email',
//         'link',
//         'image',
//         'approved'
const form = useForm({
    title: null,
    desc: null,
    tags: null,
    email: null,
    link: null,
    image: null,
})



const handleSubmit = ()=>{
    form.post(route('listings.store'));
}
</script>


<template>
    <Head title="Create"/>

    <Container>
         <form @submit.prevent="handleSubmit"  action="" class="w-full">
            <Formtitle>Create new listing</Formtitle>

          
            <!-- <Textinputs> -->
            <div class="grid grid-cols-2 w-full gap-6">
                <div>
                     <Textinputs type="text" placeholder="List title" name="Title" icon="pen" iconStyle="solid" v-model="form.title" class="w-full"/>
                     <small v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</small>
                </div>
                <div>
                     <Textinputs type="text" placeholder="Example: AWS, JS, Python" name="Tags (seperate with comma)" icon="tags" iconStyle="solid" v-model="form.tags" class="w-full"/>
                     <small v-if="form.errors.tags" class="text-red-500">{{ form.errors.tags }}</small>
                </div>
               <div>
                    <Textinputs type="email" placeholder="Example@example.com" name="Email" icon="at" iconStyle="solid" v-model="form.email" class="w-full"/>
                     <small v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</small>
               </div>
               <div>
                    <Textinputs type="text" placeholder="https://example...." name="External link" icon="up-right-from-square" iconStyle="solid" v-model="form.link" class="w-full"/>
                    <small v-if="form.errors.link" class="text-red-500">{{ form.errors.link }}</small>
               </div>
               <div>
                    <Textarea placeholder="Description here...." name="Add Description" icon="pen" iconStyle="solid" v-model="form.desc" class="w-full"/>
                    
               </div>
               
                <div>
                    <Imageholder @image="(img)=> form.image = img"/>
                    <small v-if="form.errors.image" class="text-red-500">{{ form.errors.image }}</small>
                </div>
                
                
              

                <Primarybutton :disabled="form.processing" btnType='submit'>Create</Primarybutton>
            </div>
        
        </form>
    </Container>
   
</template>

