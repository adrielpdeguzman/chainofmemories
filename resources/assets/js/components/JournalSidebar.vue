<template>
    <div class="Journal__sidebar">
        <select class="select" v-if="volumes.length" :value="$route.params.volume" @change="volumeChanged">
            <option v-for="volume of volumes" :value="volume.volume">
                Vol. {{ volume.volume }} | {{ volume.publish_date | formatDate('MMMM\'YY') }}
            </option>
        </select>
        <div class="Journal__links">
            <ul>
                <li v-for="journal of journals">
                    <a :href="'#' + journal.id">
                        Day {{ journal.day }} | {{ journal.publish_date | formatDate('YYYY-MM-DD') }}
                    </a>
                </li>
                <li v-if="journals.length"><a href="#events">Outline of Special Events</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['journals', 'volumes'],

        methods: {
            /**
             * Emit an event when volume changed.
             */
            volumeChanged(event) {
                eventBus.$emit('volume-changed', event.target.value);
            },
        },
    }
</script>
