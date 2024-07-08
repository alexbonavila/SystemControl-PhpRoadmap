<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['project', 'readonly']);
const emit = defineEmits(['close', 'updated']);
const form = ref({ ...props.project });

watch(() => props.project, newProject => {
    form.value = { ...newProject };
});

const saveProject = () => {
    if (form.value.id) {
        router.put(route('projects.update', form.value.id), form.value, {
            onSuccess: () => {
                emit('updated');
                close();
            }
        });
    } else {
        router.post(route('projects.store'), form.value, {
            onSuccess: () => {
                emit('updated');
                close();
            }
        });
    }
};

const close = () => {
    emit('close');
};
</script>

<template>
    <div>
        <h2 v-if="form.id">Edit Project</h2>
        <h2 v-else>Create Project</h2>

        <form @submit.prevent="saveProject">
            <div>
                <label for="name">Name:</label>
                <input type="text" v-model="form.name" id="name" :readonly="readonly">
            </div>
            <button type="submit" v-if="!readonly">Save</button>
            <button type="button" @click="close" v-else>Close</button>
        </form>
    </div>
</template>
