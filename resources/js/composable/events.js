import {ref} from 'vue'

export default function useEvents(){
    const events = ref({})
    const getEvents = async (page = 1) => {
        axios.get('api/v1/events?page='+ page).then(response => {
            events.value = response.data;
        })
    }
    return {events, getEvents}
}
