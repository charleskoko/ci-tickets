require('./bootstrap');

import {createApp} from "vue";
import EventsIndex from './components/Events/index'
import LaravelVuePagination from "laravel-vue-pagination";

const app = createApp({})
app.component('events-index',EventsIndex)
app.component('Pagination', LaravelVuePagination)
app.mount('#app')
