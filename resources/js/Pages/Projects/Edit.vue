<template>
    <div>
        <h1>Edit Project</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="name">Name:</label>
                <input type="text" v-model="form.name" id="name">
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        project: Object
    },
    data() {
        return {
            form: {
                name: this.project.name
            }
        }
    },
    methods: {
        submit() {
            Inertia.put(this.route('projects.update', this.project.id), this.form);
        }
    }
}
</script>
