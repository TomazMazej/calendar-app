import { createApp } from 'vue';
import EventList from './components/EventList.vue';

const app = createApp(EventList);
app.component('event-list', EventList)

app.mount('#app');