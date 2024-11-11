<script setup>
import { ref } from 'vue';


const props = defineProps({listingImage: String});

const currentImage = props.listingImage? `/storage/${props.listingImage}` : null;

const emit = defineEmits(['image']);


const previewImg = ref(currentImage);
const exceedSize = ref(false);
const showRevertImage = ref(false);


const imageHandler = (e)=>{
    previewImg.value = URL.createObjectURL(e.target.files[0]);
    exceedSize.value = e.target.files[0].size > 3000000;
    showRevertImage.value = true;
    emit('image', e.target.files[0]);
} 

const revertImagetoDefault = ()=>{
    showRevertImage.value = false;
    previewImg.value = currentImage;
    exceedSize.value = false;
     emit('image', null);
    
}

</script>

<template>


    <div>
        <div>
            <span :class="{'!text-red-500': exceedSize}">
                <i class="fa-solid fa-image mx-2"></i>
                Select Image (Max 3mb)
            </span>

            <div>
                <label for="preview" :class="{'!border-red-500': exceedSize}" class=" relative h-32 block mt-2 overflow-hidden rounded-md cursor-pointer bg-white border border-slate-300">
                    <div v-if="exceedSize" :class="{'!h-full': exceedSize}" class="absolute flex-col bg-slate-600 h-0 w-full flex justify-center items-center overflow-hidden transition-all">
                       <i class="fa-solid fa-triangle-exclamation"></i>
                       <small class="underline">File size exeeded to 3mb</small>
                    </div>
                    <img class="object-cover object-center h-full w-full" :src="previewImg ?? '/storage/images/listings/Alice gou devil woman cry baby2.png'" alt="">


                    <button @click.prevent="revertImagetoDefault" v-if="showRevertImage" type="button"  class="absolute right-2 top-2 h-5 w-5 bg-slate-500 shadow-2xl hover:opacity-70 transition-all drop-shadow-lg p-5 rounded-full flex justify-center items-center" >

                        <i class="fa-solid fa-arrow-rotate-left"></i>

                    </button>
                </label>

                <input @input="imageHandler" id="preview" type="file" hidden>
            </div>
        </div>
    </div>
</template>