import {ref} from 'vue'

export default function useEventTypes(){
    const eventTypes = ref({})
    const getEventTypes = async () => {
        axios.get('api/v1/event-types').then(response => {
            eventTypes.value = response.data.data;
        })
    }
    return {eventTypes, getEventTypes}
}
