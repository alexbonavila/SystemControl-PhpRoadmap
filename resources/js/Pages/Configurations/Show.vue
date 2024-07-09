<script setup>
import Configuration from '@/Pages/Configurations/Configuration.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['configuration']);
</script>

<template>
    <AppLayout title="Configuration Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Configuration Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Configuration :configuration="configuration" :readonly="true" @close="$inertia.visit(route('configurations.index'))" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
