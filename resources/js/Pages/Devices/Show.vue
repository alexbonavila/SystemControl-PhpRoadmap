<template>
    <div>
        <h1>Device Details</h1>
        <p>ID: {{ device.id }}</p>
        <p>Name: {{ device.name }}</p>
        <inertia-link :href="route('devices.index')">Back to List</inertia-link>
        <inertia-link :href="route('devices.edit', device.id)">Edit</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        device: Object
    }
}
</script>
