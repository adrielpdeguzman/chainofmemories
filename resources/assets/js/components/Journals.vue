<template>
    <div class="Journal">
        <div class="Journal__entry" v-for="journal of journals">
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
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        /**
         * The component's data.
         */
        data() {
            return {
                moment,

                journals: [],
            };
        },

        /**
         * Prepare the component.
         */
        mounted() {
            this.getJournals();
        },

        methods: {
            /**
             * Get all the Journals.
             */
            getJournals() {
                this.$http.get('/api/journals', { params: {
                            sort: 'publish_date',
                        }})
                        .then(({body}) => {
                            this.journals = body;
                        });
            },
        },
    }
</script>
