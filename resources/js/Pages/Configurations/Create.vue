<script setup>
import Configuration from '@/Pages/Configurations/Configuration.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Create Configuration">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Configuration
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Configuration :configuration="{ id: null, device_id: '', cpu: '', ram: '', storage: '' }" @close="$inertia.visit(route('configurations.index'))" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
