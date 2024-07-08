<template>
    <div>
        <h1>Configurations</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="configuration in configurations" :key="configuration.id">
                <td>{{ configuration.id }}</td>
                <td>{{ configuration.name }}</td>
                <td>
                    <inertia-link :href="route('configurations.show', configuration.id)">View</inertia-link>
                    <inertia-link :href="route('configurations.edit', configuration.id)">Edit</inertia-link>
                    <form :action="route('configurations.destroy', configuration.id)" method="POST" @submit.prevent="destroy(configuration.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <inertia-link :href="route('configurations.create')">Create New Configuration</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        configurations: Array
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(this.route('configurations.destroy', id));
        }
    }
}
</script>
