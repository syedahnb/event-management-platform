<template>
    <authenticated-layout>
        <wrapper>

            <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
                <h1 class="text-3xl font-bold mb-4">{{ event.title }}</h1>
                <p class="text-gray-700 mb-2"><strong>Description:</strong> {{ event.description }}</p>
                <p class="text-gray-700 mb-2"><strong>Location:</strong> {{ event.location }}</p>
                <p class="text-gray-700 mb-2"><strong>Date:</strong> {{ event.date }}</p>

                <!-- Display Capacity and Remaining Spots -->
                <p class="text-gray-700 mb-4">
                    <strong>Capacity:</strong> {{ event.capacity }}
                    <span v-if="event.remaining_spots !== event.capacity">
            ({{ event.remaining_spots }} spots left)
          </span>
                </p>

                <!-- Show Full Status or Register Button -->
                <div v-if="event.is_full" class="text-red-500 font-bold mb-4">Status: Full</div>
                <button
                    v-else
                    v-if="!is_registered"
                    @click="registerForEvent"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-300"
                >
                    Register
                </button>

                <!-- Success and Error Messages -->
                <p v-if="successMessage" class="text-green-500 font-bold mt-4">{{ successMessage }}</p>
                <p v-if="errorMessage" class="text-red-500 font-bold mt-4">{{ errorMessage }}</p>

                <!-- Conditionally show FeedbackForm if the user is registered -->
                <FeedbackForm v-if="is_registered" :eventId="event.id" />


                <!-- Feedback List -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Feedback</h2>
                    <div v-if="feedback.length > 0">
                        <ul class="space-y-4">
                            <li v-for="item in feedback" :key="item.id" class="p-4 bg-gray-50 rounded-lg shadow">
                                <div class="flex items-center mb-2">
                                    <p class="font-semibold">{{ item.user.name }}</p>
                                    <span class="ml-auto text-yellow-500">Rating: {{ item.rating }}/5</span>
                                </div>
                                <p class="text-gray-700">{{ item.comment }}</p>
                            </li>
                        </ul>
                    </div>
                    <p v-else class="text-gray-500">No feedback available for this event.</p>
                </div>
            </div>
        </wrapper>
    </authenticated-layout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wrapper from "@/Components/Wrapper.vue";
import Notifications from "@/Components/Notifications.vue";
import FeedbackForm from "@/Components/FeedbackForm.vue";

export default {
    components: {FeedbackForm, Notifications, Wrapper, AuthenticatedLayout },
    props: {
        event: Object, // The event data passed from the server
        is_registered: Boolean,
        feedback: Array,
    },
    data() {
        return {
            successMessage: "",
            errorMessage: "",
        };
    },
    methods: {
        registerForEvent() {
            Inertia.post(`/events/${this.event.id}/register`)
                .then(response => {
                    this.successMessage = "Successfully registered for the event.";
                    this.errorMessage = "";
                })
                .catch(error => {
                    this.errorMessage = error.response.data.message || "An error occurred during registration.";
                    this.successMessage = "";
                });
        },
    },
};
</script>

