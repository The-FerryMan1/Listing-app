<script setup>
import { router, useForm } from '@inertiajs/vue3';
const props = defineProps({user:Object});
const params = route().params;
const selectRole = useForm({role: props.user.role})
const submit = () =>{
    if (confirm(`Are you sure you want to change ${props.user.name}'s role to ${selectRole.role}?`)) {
        selectRole.put(route('admin.role', props.user.id), {
            onFinish:()=>router.get(route('admin.index', {...params}))
        }   );
    } else {
        selectRole.role = props.user.role;
    }
}
</script>

<template>
    <div>
        <form @change="submit" action="">
            <label for="roles" class="sr-only">Roles:</label>
            <select class="text-slate-800 bg-slate-300 text-xs rounded-lg p-1 ring-1 ring-indigo-600" v-model="selectRole.role" name="roles">
                <option value="general">General</option>
                <option value="suspended">Suspended</option>
                <option value="admin">Admin</option>
            </select>
        </form>
    </div>
</template>