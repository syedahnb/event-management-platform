<template>
    <authenticated-layout>
        <Wrapper>
            <div class="py-5">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-bold mb-4">Your Events</h1>
                    <div v-if="can_create">
                        <button
                            @click="createEvent"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-300"
                        >
                            Create Event
                        </button>
                    </div>
                </div>
                <!-- Events Table -->
                <div v-if="events.data.length > 0" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Location</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Capacity</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="event in events.data" :key="event.id" class="border-t">
                            <td class="py-2 px-4 border-b">{{ event.title }}</td>
                            <td class="py-2 px-4 border-b">{{ event.description }}</td>
                            <td class="py-2 px-4 border-b">{{ event.location }}</td>
                            <td class="py-2 px-4 border-b">{{ event.date }}</td>
                            <td class="py-2 px-4 border-b">{{ event.capacity }}</td>
                            <td class="py-2 px-4 border-b">
                                <span v-if="event.is_full" class="text-red-500 font-bold">Full</span>
                                <span v-else class="text-green-500 font-bold">Open</span>
                            </td>
                            <td class="py-2 px-4 border-b flex">
                                <!-- Attend Button -->
                                <button
                                    v-if="!event.is_full"
                                    @click="showEvent(event)"
                                    class="bg-green-950 text-white px-4 py-2 rounded"
                                >
                                    Attend
                                </button>
                                <!-- Edit Button, restricted based on authorization -->
                                <button
                                    v-if="event.can_edit"
                                    @click="editEvent(event)"
                                    class="bg-blue-500 text-white px-4 py-2 rounded mr-2"
                                >
                                    Edit
                                </button>
                                <!-- Delete Button, restricted based on authorization -->
                                <button
                                    v-if="event.can_delete"
                                    @click="deleteEvent(event.id)"
                                    class="bg-red-500 text-white px-4 py-2 rounded"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- No Events Message -->
                <p v-else>No events available.</p>

                <!-- Pagination Links -->
                <div class="mt-6">
                    <button
                        v-if="events.prev_page_url"
                        @click="fetchPage(events.prev_page_url)"
                        class="px-4 py-2 mr-2 text-white bg-blue-500 rounded"
                    >
                        Previous
                    </button>
                    <button
                        v-if="events.next_page_url"
                        @click="fetchPage(events.next_page_url)"
                        class="px-4 py-2 text-white bg-blue-500 rounded"
                    >
                        Next
                    </button>
                </div>
            </div>
        </Wrapper>
    </authenticated-layout>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wrapper from "@/Components/Wrapper.vue";

export default {
    components: {Wrapper, AuthenticatedLayout},
    props: {
        events: Object,
        can_create: Boolean,
    },
    methods: {
        fetchPage(url) {
            Inertia.visit(url);
        },
        createEvent() {
            this.$inertia.visit('/events/create');
        },
        editEvent(event) {
            this.$inertia.visit(`/events/${event.id}/edit`);
        },
        showEvent(event) {
            this.$inertia.visit(`/events/${event.id}/attend`);
        },
        deleteEvent(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                Inertia.delete(`/events/${id}`);
            }
        },
    },
};
</script>

<style scoped>
.table-wrapper {
    overflow-x: auto;
}
</style>
