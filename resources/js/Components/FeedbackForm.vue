<template>
    <div class="mt-6">
        <h2 class="text-lg font-semibold mb-2">Leave Feedback</h2>
        <form @submit.prevent="submitFeedback">
            <label class="block mb-2">Rating (1-5):</label>
            <input v-model="rating" type="number" min="1" max="5" required class="mb-2 p-2 border rounded w-full" />

            <label class="block mb-2">Comments:</label>
            <textarea v-model="comment" class="p-2 border rounded w-full"></textarea>

            <button type="submit" class="mt-3 px-4 py-2 bg-blue-500 text-white rounded">Submit Feedback</button>
        </form>
        <p v-if="successMessage" class="text-green-500 mt-2">{{ successMessage }}</p>
        <p v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</p>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import {ref} from 'vue';

export default {
    props: {
        eventId: Number,
    },
    setup(props) {
        const rating = ref(1);
        const comment = ref('');
        const successMessage = ref('');
        const errorMessage = ref('');

        const submitFeedback = () => {
            Inertia.post(`/events/${props.eventId}/feedback`, {rating: rating.value, comment: comment.value})
                .then(() => {
                    successMessage.value = "Thank you for your feedback.";
                    errorMessage.value = "";
                    rating.value = 1;
                    comment.value = "";
                })
                .catch(error => {
                    errorMessage.value = error.response.data.message || "An error occurred while submitting feedback.";
                    successMessage.value = "";
                });
        };

        return {
            rating,
            comment,
            successMessage,
            errorMessage,
            submitFeedback,
        };
    },
};
</script>
