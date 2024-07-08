<template>
    <div>
        <h1>Edit Report</h1>
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
import {Inertia} from '@inertiajs/inertia';

export default {
    props: {
        report: Object
    },
    data() {
        return {
            form: {
                name: this.report.name
            }
        }
    },
    methods: {
        submit() {
            Inertia.put(this.route('reports.update', this.report.id), this.form);
        }
    }
}
</script>
