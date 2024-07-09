<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['device', 'readonly']);
const emit = defineEmits(['close', 'updated']);
const form = ref({ ...props.device });

watch(() => props.device, newDevice => {
    form.value = { ...newDevice };
});

const saveDevice = () => {
    if (form.value.id) {
        router.put(route('devices.update', form.value.id), form.value, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                emit('updated');
                close();
            }
        });
    } else {
        router.post(route('devices.store'), form.value, {
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
        <h2 v-if="form.id">Edit Device</h2>
        <h2 v-else>Create Device</h2>

        <form @submit.prevent="saveDevice">
            <div>
                <label for="user_id">User ID:</label>
                <input type="text" v-model="form.user_id" id="user_id" :readonly="readonly">
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" v-model="form.model" id="model" :readonly="readonly">
            </div>
            <div>
                <label for="serial_number">Serial Number:</label>
                <input type="text" v-model="form.serial_number" id="serial_number" :readonly="readonly">
            </div>
            <button type="submit" v-if="!readonly">Save</button>
            <button type="button" @click="close" v-else>Close</button>
        </form>
    </div>
</template>
