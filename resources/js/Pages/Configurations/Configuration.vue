<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['configuration', 'readonly']);
const emit = defineEmits(['close', 'updated']);
const form = ref({ ...props.configuration });

watch(() => props.configuration, newConfiguration => {
    form.value = { ...newConfiguration };
});

const saveConfiguration = () => {
    if (form.value.id) {
        router.put(route('configurations.update', form.value.id), form.value, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                emit('updated');
                close();
            }
        });
    } else {
        router.post(route('configurations.store'), form.value, {
            preserveState: true,
            preserveScroll: true,
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
        <h2 v-if="form.id">Edit Configuration</h2>
        <h2 v-else>Create Configuration</h2>

        <form @submit.prevent="saveConfiguration">
            <div>
                <label for="device_id">Device ID:</label>
                <input type="text" v-model="form.device_id" id="device_id" :readonly="readonly">
            </div>
            <div>
                <label for="cpu">CPU:</label>
                <input type="text" v-model="form.cpu" id="cpu" :readonly="readonly">
            </div>
            <div>
                <label for="ram">RAM:</label>
                <input type="text" v-model="form.ram" id="ram" :readonly="readonly">
            </div>
            <div>
                <label for="storage">Storage:</label>
                <input type="text" v-model="form.storage" id="storage" :readonly="readonly">
            </div>
            <button type="submit" v-if="!readonly">Save</button>
            <button type="button" @click="close" v-else>Close</button>
        </form>
    </div>
</template>
