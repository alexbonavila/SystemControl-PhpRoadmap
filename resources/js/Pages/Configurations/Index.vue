<script setup>
import { ref, watchEffect } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Configuration from '@/Pages/Configurations/Configuration.vue';

const page = usePage();
const configurations = ref(page.props.configurations || []);
const currentConfiguration = ref(null);

const fetchConfigurations = () => {
    router.get(route('configurations.index'), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            configurations.value = page.props.configurations;
        }
    });
};

const showConfiguration = (id) => {
    router.get(route('configurations.show', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentConfiguration.value = page.props.configuration;
        }
    });
};

const editConfiguration = (id) => {
    router.get(route('configurations.edit', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentConfiguration.value = page.props.configuration;
        }
    });
};

const deleteConfiguration = (id) => {
    router.delete(route('configurations.destroy', id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            fetchConfigurations();
        }
    });
};

const createConfiguration = () => {
    currentConfiguration.value = { id: null, device_id: '', cpu: '', ram: '', storage: '' };
};

// Usamos watchEffect para asegurarnos de que las llamadas se realicen de manera eficiente
watchEffect(() => {
    if (!configurations.value.length) {
        fetchConfigurations();
    }
});
</script>

<template>
    <AppLayout title="Configurations">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Configurations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device ID</th>
                            <th>CPU</th>
                            <th>RAM</th>
                            <th>Storage</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="configuration in configurations" :key="configuration.id">
                            <td>{{ configuration.id }}</td>
                            <td>{{ configuration.device_id }}</td>
                            <td>{{ configuration.cpu }}</td>
                            <td>{{ configuration.ram }}</td>
                            <td>{{ configuration.storage }}</td>
                            <td>
                                <button @click="showConfiguration(configuration.id)">View</button>
                                <button @click="editConfiguration(configuration.id)">Edit</button>
                                <button @click="deleteConfiguration(configuration.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button @click="createConfiguration">Create New Configuration</button>

                    <Configuration v-if="currentConfiguration" :configuration="currentConfiguration" @close="currentConfiguration = null" @updated="fetchConfigurations" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
