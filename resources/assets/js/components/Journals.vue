<template>
    <div class="Journal">
        <div class="Journal__sidebar">
            <select class="select" v-if="volumes.length" v-model="currentVolume">
                <option v-for="item of volumes" :value="item.volume">
                    {{ `Vol. ${item.volume} ${'|'} ${moment(item.publish_date).format('MMMM\'YY')}` }}
                </option>
            </select>
            <div class="Journal__links">
                <ul>
                    <li v-for="(journal, index) of journals">
                        <a :href="'#' + journal.id">
                            {{ `Day ${journal.day} ${'|'} ${moment(journal.publish_date).format('YYYY-MM-DD')}` }}
                        </a>
                    </li>
                    <li v-if="journals.length"><a href="#events">Outline of Special Events</a></li>
                </ul>
            </div>
        </div>

        <div class="Journal__list" v-if="journals.length">
            <div class="Journal__entry" v-for="journal of journals" :id="journal.id">
                <div class="Journal__date">
                    {{ `Day ${journal.day} ${'|'} ${moment(journal.publish_date).format('YYYY-MM-DD')}` }}
                </div>
                <div class="Journal__author">
                    {{ `Posted by: ${journal.user.name}` }}
                </div>
                <div class="Journal__contents">
                    <p v-for="paragraph of journal.contents.match(/[^\r\n]+/g)" v-text="paragraph"></p>
                </div>
                <div class="Journal__events" v-if="journal.events.length > 0">
                    <ul>
                        <li v-for="event of journal.events.match(/[^\r\n]+/g)" v-text="event"></li>
                    </ul>
                </div>
            </div>
            <div class="Journal__events" v-if="journals.length" id="events">
                <h3>Outline of Special Events</h3>
                <div v-for="journal of journals">
                    <div v-if="journal.events.length > 0">
                        <p>{{ `Day ${journal.day} ${'|'} ${moment(journal.publish_date).format('YYYY-MM-DD')} by: ${journal.user.name}` }}</p>
                        <ul>
                            <li v-for="event of journal.events.match(/[^\r\n]+/g)" v-text="event"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import moment from 'moment';

    export default {
        /**
         * The component's data.
         */
        data() {
            return {
                moment,

                volumes: [],
                journals: [],
                currentVolume: this.$route.params.volume || 0,
            };
        },

        /**
         * Prepare the component.
         */
        created() {
            this.getVolumes();

            if (this.currentVolume !== 0) {
                this.getJournals();
            }
        },

        methods: {
            /**
             * Get journals within the current volume.
             */
            getJournals() {
                this.$http.get('/api/journals', { params: {
                            volume: this.currentVolume,
                            sort: 'publish_date',
                        }})
                        .then(({body}) => {
                            this.journals = body;
                        });
            },
            /**
             * Get the volumes with start dates.
             */
            getVolumes() {
                this.$http.get('/api/journals/volumes_with_start_dates')
                        .then(({body}) => {
                            this.volumes = body;

                            if (!Boolean(this.$route.params.volume)) {
                                this.currentVolume = _.last(this.volumes).volume;
                                this.$router.push({ name: 'volume', params: { volume: _.last(this.volumes).volume }});
                            }
                        });
            },
        },
        watch: {
            currentVolume(newValue, oldValue) {
                this.$router.push({ name: 'volume', params: { volume: newValue }});
                this.getJournals();
            },
        },
    }
</script>
