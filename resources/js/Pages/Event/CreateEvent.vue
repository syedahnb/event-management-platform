<AuthenticatedLayout>
<template>

    <form @submit.prevent="submit">
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Event Title</label>
            <input v-model="title" type="text" id="title" required/>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea v-model="description" id="description" ></textarea>
        </div>

    </form>
</template>

</AuthenticatedLayout>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {AuthenticatedLayout},

    data() {
        return {
            title: '',
            description: '',
        };
    },
    methods: {
        async submit() {
            await this.$inertia.post('/events', {title: this.title, description: this.description});
        },
    },
};
</script>
