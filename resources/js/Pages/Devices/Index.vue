<script setup>
import { ref, watchEffect } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Device from '@/Pages/Devices/Device.vue';

const page = usePage();
const devices = ref(page.props.devices || []);
const currentDevice = ref(null);

const fetchDevices = () => {
    router.get(route('devices.index'), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            devices.value = page.props.devices;
        }
    });
};

const showDevice = (id) => {
    router.get(route('devices.show', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentDevice.value = page.props.device;
        }
    });
};

const editDevice = (id) => {
    router.get(route('devices.edit', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentDevice.value = page.props.device;
        }
    });
};

const deleteDevice = (id) => {
    router.delete(route('devices.destroy', id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            fetchDevices();
        }
    });
};

const createDevice = () => {
    currentDevice.value = { id: null, user_id: '', model: '', serial_number: '' };
};

// Usamos watchEffect para asegurarnos de que las llamadas se realicen de manera eficiente
watchEffect(() => {
    if (!devices.value.length) {
        fetchDevices();
    }
});
</script>

<template>
    <AppLayout title="Devices">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Devices
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Model</th>
                            <th>Serial Number</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="device in devices" :key="device.id">
                            <td>{{ device.id }}</td>
                            <td>{{ device.user_id }}</td>
                            <td>{{ device.model }}</td>
                            <td>{{ device.serial_number }}</td>
                            <td>
                                <button @click="showDevice(device.id)">View</button>
                                <button @click="editDevice(device.id)">Edit</button>
                                <button @click="deleteDevice(device.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button @click="createDevice">Create New Device</button>

                    <Device v-if="currentDevice" :device="currentDevice" @close="currentDevice = null" @updated="fetchDevices" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
