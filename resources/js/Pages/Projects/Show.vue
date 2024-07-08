<template>
    <div>
        <h1>Project Details</h1>
        <p>ID: {{ project.id }}</p>
        <p>Name: {{ project.name }}</p>
        <inertia-link :href="route('projects.index')">Back to List</inertia-link>
        <inertia-link :href="route('projects.edit', project.id)">Edit</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        project: Object
    }
}
</script>
