<template>
    <div>
        <h1>Report Details</h1>
        <p>ID: {{ report.id }}</p>
        <p>Name: {{ report.name }}</p>
        <inertia-link :href="route('reports.index')">Back to List</inertia-link>
        <inertia-link :href="route('reports.edit', report.id)">Edit</inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        report: Object
    }
}
</script>
