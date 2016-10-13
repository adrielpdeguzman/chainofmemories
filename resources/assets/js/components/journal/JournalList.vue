<template>
    <div class="Journal__list" v-if="journals.length">
        <div class="panel" v-for="journal of journals">
            <a class="utility-anchor" :id="journal.id"></a>
            <div class="panel__heading">
                <div class="Journal__info">
                    Day {{ journal.day }} | {{ journal.publish_date | formatDate('YYYY-MM-DD') }}
                    <hr>
                    Posted by: {{ journal.user.name }}
                </div>
                <div class="Journal__edit" v-if="isOwner(journal)">
                    <button type="button" class="button" @click="eventBus.$emit('journal-edit', journal)">
                        <i class="fa fa-pencil-square-o fa" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="panel__body">
                <div class="Journal__contents">
                    <p v-for="paragraph of journal.contents.match(/[^\r\n]+/g)" v-text="paragraph"></p>
                </div>
            </div>

            <div class="panel__footer" v-if="journal.events.length > 0">
                <ul class="Journal__events">
                    <li v-for="event of journal.events.match(/[^\r\n]+/g)" v-text="event"></li>
                </ul>
            </div>
        </div>
        
        <div class="panel" v-if="journals.length" id="events">
            <div class="panel__heading">
                Outline of Special Events
            </div>

            <div class="panel__body">
                <div v-for="journal of journals">
                    <div v-if="journal.events.length > 0">
                        <h4>Day {{ journal.day }} | {{ journal.publish_date | formatDate('YYYY-MM-DD') }} by: {{ journal.user.name }}</h4>
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
    export default {
        props: ['journals', 'user'],

        /**
         * The component's data.
         */
        data() {
            return {
                eventBus,
            };
        },

        methods: {
            isOwner(journal) {
                return journal.user_id === this.user.data.id;
            },
        },
    }
</script>
