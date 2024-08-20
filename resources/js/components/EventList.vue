<template>
    <div class="events-container">
        <h1 class="title">Events</h1>
        <div class="events-list">
            <div class="event-card" v-for="event in events" :key="event.id">
                <div class="event-header">
                    <strong>{{ event.title }}</strong> - {{ event.date }}
                </div>
                <div v-if="selectedEvent === event" class="event-description">
                    {{ event.description || "/" }}
                </div>
                <button @click="toggleDescription(event)">
                    {{ selectedEvent === event ? 'Hide' : 'Show' }} Description
                </button>
            </div>
        </div>
        <button @click="fetchEvents" class="refresh-button">Refresh Events</button>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import axios from 'axios';

interface Event {
    id: number;
    title: string;
    date: string;
    description?: string;
}

export default defineComponent({
    setup() {
        const events = ref<Event[]>([]);
        const selectedEvent = ref<Event | null>(null);

        const fetchEvents = async () => {
            try {
                await axios.get('/events/refresh');

                const response = await axios.get<Event[]>('/api/events');
                events.value = response.data;
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        };

        const toggleDescription = (event: Event) => {
            selectedEvent.value = selectedEvent.value === event ? null : event;
        };

        onMounted(() => {
            fetchEvents();
        });

        return {
            events,
            selectedEvent,
            fetchEvents,
            toggleDescription
        };
    }
});
</script>