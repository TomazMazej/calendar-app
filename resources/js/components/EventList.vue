<template>
    <div class="events-container">
        <h1 class="title">Events</h1>
        <div class="events-list">
            <div class="event-card" v-for="event in events" :key="event.id">
                <div class="event-header">
                    <strong>{{ event.title }}</strong> - {{ event.date }}
                </div>
                <div v-if="selectedEvent === event" class="event-description">
                    {{ event.description || "/"}}
                </div>
                <button @click="toggleDescription(event)">
                    {{ selectedEvent === event ? 'Hide' : 'Show' }} Description
                </button>
            </div>
        </div>
        <button @click="fetchEvents" class="refresh-button">Refresh Events</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            events: [],
            selectedEvent: null
        };
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            try {
                await axios.get('/events/refresh');
                const response = await axios.get('/api/events');
                this.events = response.data;
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        },
        toggleDescription(event) {
            this.selectedEvent = this.selectedEvent === event ? null : event;
        }
    }
};
</script>