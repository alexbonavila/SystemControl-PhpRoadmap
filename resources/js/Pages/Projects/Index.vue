<template>
    <div>
        <h1>Projects</h1>
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
                    <inertia-link :href="route('projects.show', project.id)">View</inertia-link>
                    <inertia-link :href="route('projects.edit', project.id)">Edit</inertia-link>
                    <form :action="route('projects.destroy', project.id)" method="POST" @submit.prevent="destroy(project.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <inertia-link :href="route('projects.create')">Create New Project</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        projects: Array
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(this.route('projects.destroy', id));
        }
    }
}
</script>
