<template>
    <modal
        :show="show"
        :callback="edit"
        :ok-text="'Edit'"
        @close="$emit('close')"
    >
        <div slot="heading">
            Day {{ journal.day }} | {{ journal.publish_date | formatDate('YYYY-MM-DD') }}
        </div>
        <div slot="body">
            <form @submit.prevent="callback">
                <textarea class="textarea" v-model="journal.contents"></textarea>
                <textarea class="textarea" v-model="journal.events"></textarea>
            </form>
        </div>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';

    export default {
        props: ['show'],

        components: {
            Modal,
        },

        /**
         * The component's data.
         */
        data() {
            return {
                isLoading: false,

                journal: {
                    errors: [],
                    contents: '',
                    events: '',
                },
            };
        },

        /** 
         * Register event handlers.
         */
        created() {
            eventBus.$on('journal-edit', this.setJournal);
        },

        methods: {
            /**
             * Create the journal entry.
             */
            edit() {
                this.isLoading = true;
                this.$http.patch(`/api/journals/${this.journal.id}`, this.journal)
                        .then(() => {
                            this.reset();
                            this.$emit('close');
                            eventBus.$emit('refresh');
                        })
                        .catch(({body}) => {
                            this.journal.errors = body.error.message;
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
            },

            /**
             * Reset the form.
             */
            reset() {
                this.isLoading = false;

                this.journal.errors = [];
                this.journal.contents = '';
                this.journal.events = '';
            },

            /**
             * Set the journal to be updated.
             */
            setJournal(journal) {
                _.assign(this.journal, journal);
            },
        },

        watch: {
            show() {
                if (!this.show) {
                    this.reset();
                }
            },
        },
    }
</script>
