<template>
    <aside class="Journal__sidebar panel">
        <div class="panel__heading">
            <select class="input-field utility-max-width" v-if="volumes.length" :value="$route.params.volume" @change="volumeChanged">
                <option v-for="volume of volumes" :value="volume.volume">
                    Vol. {{ volume.volume }} | {{ volume.publish_date | formatDate('MMMM\'YY') }}
                </option>
            </select>
        </div>
        <div class="panel__body">
            <ul class="Journal__links">
                <li v-for="journal of filteredJournals">
                    <a :href="'#' + journal.id">
                        Day {{ journal.day }} | {{ journal.publish_date | formatDate('YYYY-MM-DD') }}
                    </a>
                </li>
                <li v-if="journals.length"><a href="#events">Outline of Special Events</a></li>
            </ul>
        </div>
    </aside>
</template>

<script>
    export default {
        props: ['journals', 'volumes'],

        methods: {
            /**
             * Emit an event when volume changed.
             */
            volumeChanged(event) {
                eventBus.$emit('journal-volume-changed', event.target.value);
            },
        },

        computed: {
            filteredJournals() {
                return _.uniqBy(this.journals, 'day');
            },
        },
    }
</script>
