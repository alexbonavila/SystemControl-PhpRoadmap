<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Project from '@/Pages/Projects/Project.vue';

const page = usePage();
const projects = ref(page.props.projects || []);
const currentProject = ref(null);

const fetchProjects = () => {
    router.get(route('projects.index'), {}, {
        onSuccess: (page) => {
            projects.value = page.props.projects;
        }
    });
};

const showProject = (id) => {
    router.get(route('projects.show', id), {}, {
        onSuccess: (page) => {
            currentProject.value = page.props.project;
        }
    });
};

const editProject = (id) => {
    router.get(route('projects.edit', id), {}, {
        onSuccess: (page) => {
            currentProject.value = page.props.project;
        }
    });
};

const deleteProject = (id) => {
    router.delete(route('projects.destroy', id), {
        onSuccess: () => {
            fetchProjects();
        }
    });
};

const createProject = () => {
    currentProject.value = { id: null, name: '' };
};
</script>

<template>
    <AppLayout title="Projects">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td>{{ project.id }}</td>
                            <td>{{ project.name }}</td>
                            <td>
                                <button @click="showProject(project.id)">View</button>
                                <button @click="editProject(project.id)">Edit</button>
                                <button @click="deleteProject(project.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button @click="createProject">Create New Project</button>

                    <Project v-if="currentProject" :project="currentProject" @close="currentProject = null" @updated="fetchProjects" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
