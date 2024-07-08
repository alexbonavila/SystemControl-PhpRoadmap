<template>
    <div>
        <h1>Devices</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="device in devices" :key="device.id">
                <td>{{ device.id }}</td>
                <td>{{ device.name }}</td>
                <td>
                    <inertia-link :href="route('devices.show', device.id)">View</inertia-link>
                    <inertia-link :href="route('devices.edit', device.id)">Edit</inertia-link>
                    <form :action="route('devices.destroy', device.id)" method="POST" @submit.prevent="destroy(device.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <inertia-link :href="route('devices.create')">Create New Device</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        devices: Array
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(this.route('devices.destroy', id));
        }
    }
}
</script>
