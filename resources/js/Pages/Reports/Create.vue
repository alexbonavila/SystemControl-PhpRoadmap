<script setup>
import Report from '@/Pages/Reports/Report.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Create Report">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Report
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Report :report="{ id: null, reportable_id: '', reportable_type: '', format: '', content: '' }" @close="$inertia.visit(route('reports.index'))" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
