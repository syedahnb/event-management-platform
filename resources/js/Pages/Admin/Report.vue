<template>
    <authenticated-layout>
        <wrapper>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4">Event Statistics and Reporting</h1>

                <!-- Total Events and Registrations -->
                <div class="mb-6">
                    <p class="text-lg font-semibold">Total Events Created: {{ totalEvents }}</p>
                    <p class="text-lg font-semibold">Total Registrations: {{ totalRegistrations }}</p>
                </div>

                <!-- Average Feedback Rating per Event -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Average Feedback Ratings</h2>
                    <ul>
                        <li v-for="(rating, eventId) in averageFeedbackRatings" :key="eventId">
                            Event ID {{ eventId }}: {{ Number(rating || 0).toFixed(2) }} / 5
                        </li>
                    </ul>
                </div>

                <!-- Top Rated Events -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Top-Rated Events</h2>
                    <table class="min-w-full bg-white border">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border">Event Title</th>
                            <th class="py-2 px-4 border">Average Rating</th>
                            <th class="py-2 px-4 border">Attendees</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="event in topRatedEvents" :key="event.id">
                            <td class="py-2 px-4 border">{{ event.title }}</td>
                            <td class="py-2 px-4 border">{{ Number(event.average_rating || 0).toFixed(2) }} / 5</td>
                            <td class="py-2 px-4 border">{{ event.registrations_count }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </wrapper>
    </authenticated-layout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wrapper from "@/Components/Wrapper.vue";

export default {
    components: {Wrapper, AuthenticatedLayout},
    props: {
        totalEvents: Number,
        totalRegistrations: Number,
        averageFeedbackRatings: Object,
        topRatedEvents: Array,
    },
};
</script>
