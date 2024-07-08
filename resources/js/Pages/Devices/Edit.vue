<template>
    <div>
        <h1>Edit Device</h1>
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
        device: Object
    },
    data() {
        return {
            form: {
                name: this.device.name
            }
        }
    },
    methods: {
        submit() {
            Inertia.put(this.route('devices.update', this.device.id), this.form);
        }
    }
}
</script>
