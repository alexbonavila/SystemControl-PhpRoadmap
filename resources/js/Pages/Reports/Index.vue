<template>
    <div>
        <h1>Reports</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="report in reports" :key="report.id">
                <td>{{ report.id }}</td>
                <td>{{ report.name }}</td>
                <td>
                    <inertia-link :href="route('reports.show', report.id)">View</inertia-link>
                    <inertia-link :href="route('reports.edit', report.id)">Edit</inertia-link>
                    <form :action="route('reports.destroy', report.id)" method="POST" @submit.prevent="destroy(report.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <inertia-link :href="route('reports.create')">Create New Report</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        reports: Array
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(this.route('reports.destroy', id));
        }
    }
}
</script>
