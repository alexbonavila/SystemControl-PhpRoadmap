<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['report', 'readonly']);
const emit = defineEmits(['close', 'updated']);
const form = ref({ ...props.report });

watch(() => props.report, newReport => {
    form.value = { ...newReport };
});

const saveReport = () => {
    if (form.value.id) {
        router.put(route('reports.update', form.value.id), form.value, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                emit('updated');
                close();
            }
        });
    } else {
        router.post(route('reports.store'), form.value, {
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
        <h2 v-if="form.id">Edit Report</h2>
        <h2 v-else>Create Report</h2>

        <form @submit.prevent="saveReport">
            <div>
                <label for="reportable_id">Reportable ID:</label>
                <input type="text" v-model="form.reportable_id" id="reportable_id" :readonly="readonly">
            </div>
            <div>
                <label for="reportable_type">Reportable Type:</label>
                <input type="text" v-model="form.reportable_type" id="reportable_type" :readonly="readonly">
            </div>
            <div>
                <label for="format">Format:</label>
                <input type="text" v-model="form.format" id="format" :readonly="readonly">
            </div>
            <div>
                <label for="content">Content:</label>
                <textarea v-model="form.content" id="content" :readonly="readonly"></textarea>
            </div>
            <button type="submit" v-if="!readonly">Save</button>
            <button type="button" @click="close" v-else>Close</button>
        </form>
    </div>
</template>
