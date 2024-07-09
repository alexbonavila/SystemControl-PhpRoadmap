<script setup>
import { ref, watchEffect } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Report from '@/Pages/Reports/Report.vue';

const page = usePage();
const reports = ref(page.props.reports || []);
const currentReport = ref(null);

const fetchReports = () => {
    router.get(route('reports.index'), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            reports.value = page.props.reports;
        }
    });
};

const showReport = (id) => {
    router.get(route('reports.show', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentReport.value = page.props.report;
        }
    });
};

const editReport = (id) => {
    router.get(route('reports.edit', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            currentReport.value = page.props.report;
        }
    });
};

const deleteReport = (id) => {
    router.delete(route('reports.destroy', id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            fetchReports();
        }
    });
};

const createReport = () => {
    currentReport.value = { id: null, reportable_id: '', reportable_type: '', format: '', content: '' };
};

// Usamos watchEffect para asegurarnos de que las llamadas se realicen de manera eficiente
watchEffect(() => {
    if (!reports.value.length) {
        fetchReports();
    }
});
</script>

<template>
    <AppLayout title="Reports">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reports
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reportable ID</th>
                            <th>Reportable Type</th>
                            <th>Format</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="report in reports" :key="report.id">
                            <td>{{ report.id }}</td>
                            <td>{{ report.reportable_id }}</td>
                            <td>{{ report.reportable_type }}</td>
                            <td>{{ report.format }}</td>
                            <td>{{ report.content }}</td>
                            <td>
                                <button @click="showReport(report.id)">View</button>
                                <button @click="editReport(report.id)">Edit</button>
                                <button @click="deleteReport(report.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button @click="createReport">Create New Report</button>

                    <Report v-if="currentReport" :report="currentReport" @close="currentReport = null" @updated="fetchReports" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
