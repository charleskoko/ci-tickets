<template>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200">
        <div class="min-w-full align-middle">
            <div class="mb-4">
                <select v-model="selectedType"
                        class="block mt-1 w-full sm:w-1/4 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" selected>-- Filtrer par type d'evenements --</option>
                    <option v-for="eventType in eventTypes" :value="eventType.id">
                        {{ eventType.label }}
                    </option>
                </select>
            </div>
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nom</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Type</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span
                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span
                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                <tr v-for="event in events.data">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ event.id }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ event.name }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ event.eventType }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ event.description }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ event.date }}</td>
                </tr>
                </tbody>
            </table>
            <Pagination :data="events" @pagination-change-page="getEvents"/>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue"
import useEvents from "../../composable/events.js";
import useEventTypes from "../../composable/eventTypes.js";

export default {
    setup() {
        const selectedType = ref('')
        const {events, getEvents} = useEvents();
        const {eventTypes, getEventTypes} = useEventTypes();
        onMounted(() => {
            getEvents()
            getEventTypes()
        })

        return {events, getEvents, eventTypes}
    }
}
</script>

<style>
.pagination {
    display: flex;
    justify-content: center;
    margin: 15px 0;
}

li.page-item {
    margin: 0 3px;
}

a.page-link {
    border-radius: 50%;
    display: block;
    height: 30px;
    width: 30px;
    display: flex;
    justify-content: center;
    place-items: center;
    transition: all 0.18s ease-in-out;
}

a.page-link:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: scale(1.2);
}

.active a.page-link {
    background: rgba(0, 0, 0, 0.1);
}

a.page-link span.sr-only {
    display: none;
}
</style>
