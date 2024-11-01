<template>
    <authenticated-layout>

        <wrapper>
            <h1 class="text-2xl font-bold mb-4">Edit Event</h1>
            <form @submit.prevent="updateEvent">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Title</label>
                    <input v-model="form.title" type="text" class="input-field" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea v-model="form.description" class="input-field"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Location</label>
                    <input v-model="form.location" type="text" class="input-field" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Date</label>
                    <input v-model="form.date" type="date" class="input-field" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Capacity</label>
                    <input v-model="form.capacity" type="number" min="1" class="input-field" required/>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Update Event
                </button>
            </form>

        </wrapper>
    </authenticated-layout>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wrapper from "@/Components/Wrapper.vue";

export default {
    components: {Wrapper, AuthenticatedLayout},
    props: {
        event: Object,
    },
    data() {
        return {
            form: {
                title: this.event.title,
                description: this.event.description,
                location: this.event.location,
                date: this.event.date,
                capacity: this.event.capacity,
            },
        };
    },
    methods: {
        updateEvent() {
            Inertia.put(`/events/${this.event.id}`, this.form);
        },
    },
};
</script>

<style scoped>
.input-field {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
}
</style>
