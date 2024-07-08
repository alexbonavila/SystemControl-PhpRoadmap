<template>
    <div>
        <h1>Create Configuration</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="name">Name:</label>
                <input type="text" v-model="form.name" id="name">
            </div>
            <button type="submit">Create</button>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    data() {
        return {
            form: {
                name: ''
            }
        }
    },
    methods: {
        submit() {
            Inertia.post(this.route('configurations.store'), this.form);
        }
    }
}
</script>
