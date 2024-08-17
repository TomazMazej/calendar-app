import { createApp } from 'vue';
import EventList from './components/EventList.vue';

const app = createApp();
app.component('event-list', EventList)

app.mount('#app');