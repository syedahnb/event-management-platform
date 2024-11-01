<template>
    <div class="relative" @click.stop="toggleDropdown">
        <button class="relative text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-gray-400">
            <!-- Show red dot if there are unread notifications -->
            <span
                v-if="hasUnreadNotifications"
                class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"
            ></span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 22c1.656 0 3-1.344 3-3H9c0 1.656 1.344 3 3 3zm1-9V5c0-1.104-.896-2-2-2s-2 .896-2 2v8c-.552 0-1 .448-1 1s.448 1 1 1h6c.552 0 1-.448 1-1s-.448-1-1-1z"
                />
            </svg>
        </button>

        <!-- Dropdown for notifications, visible only when `isDropdownOpen` is true -->
        <div
            v-if="isDropdownOpen"
            class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-50"
        >
            <ul class="p-2 space-y-2">
                <!-- Display each notification message -->
                <li
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="p-2 hover:bg-gray-100"
                >
                    {{ notification.data.message }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

export default {
    props: {
        notifications: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        // State to control dropdown visibility
        const isDropdownOpen = ref(false);

        // Check if there are any unread notifications
        const hasUnreadNotifications = computed(() => props.notifications.length > 0);

        // Toggle the dropdown visibility
        const toggleDropdown = () => {
            isDropdownOpen.value = !isDropdownOpen.value;
        };

        // Close dropdown when clicking outside
        const handleClickOutside = (event) => {
            if (!event.target.closest('.relative')) {
                isDropdownOpen.value = false;
            }
        };

        onMounted(() => {
            document.addEventListener('click', handleClickOutside);
        });

        onBeforeUnmount(() => {
            document.removeEventListener('click', handleClickOutside);
        });

        return {
            isDropdownOpen,
            toggleDropdown,
            hasUnreadNotifications,
        };
    },
};
</script>
