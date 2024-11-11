<script setup>
defineProps({
    paginator: Object
})


const labelFormat =(label)=>{
    if(label.includes('Previous')){
        return '<<-'
    }else if(label.includes('Next')){
        return '->>'
    }else{
        return label
    }
}
</script>

<template>
    <div class="flex justify-between items-center">
        <div class="flex items-center  overflow-hidden rounded-lg space-x-2 shadow-lg">
            <div v-for="page, i in paginator.links" :key="i">
                <component
                    :is="page.url? 'Link':'span'"
                    :href="page.url"
                    v-html="labelFormat(page.label)"
                    class="border-x p-2 border-slate-50 rounded-md h-12 flex justify-center items-center text-nowrap hover:opacity-50 transition-all bg-white dark:bg-slate-800 dark:border-slate-800"
                    :class="{'!text-green-500':page.active, '!hidden':!page.url}"
                />
            </div>
        </div>
        <div>
            <p class="text-slate-400">Showing {{ paginator.form }} to {{ paginator.to }} of {{ paginator.total }} result</p>
        </div>
    </div>
</template>