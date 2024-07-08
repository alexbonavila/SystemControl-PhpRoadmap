<template>
    <div>
        <h1>Edit Configuration</h1>
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
        configuration: Object
    },
    data() {
        return {
            form: {
                name: this.configuration.name
            }
        }
    },
    methods: {
        submit() {
            Inertia.put(this.route('configurations.update', this.configuration.id), this.form);
        }
    }
}
</script>
