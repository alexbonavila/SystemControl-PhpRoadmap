<script setup>
import Project from '@/Pages/Projects/Project.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['project']);
</script>

<template>
    <AppLayout title="Edit Project">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Project :project="project" @close="$inertia.visit(route('projects.index'))" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
