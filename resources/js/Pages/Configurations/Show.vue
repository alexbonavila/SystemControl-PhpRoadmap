<template>
    <div>
        <h1>Configuration Details</h1>
        <p>ID: {{ configuration.id }}</p>
        <p>Name: {{ configuration.name }}</p>
        <inertia-link :href="route('configurations.index')">Back to List</inertia-link>
        <inertia-link :href="route('configurations.edit', configuration.id)">Edit</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        configuration: Object
    }
}
</script>
