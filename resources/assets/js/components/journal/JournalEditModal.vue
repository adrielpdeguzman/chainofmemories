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
            <form @submit.prevent="edit" @keyup.enter="hotkeySubmit">
                <div :class="['input-group', journal.errors.contents ? 'input-group--has-error' : '']">
                    <label class="input-label" for="journal.contents">Journal Contents</label>
                    <textarea class="input-field" rows="10" v-model="journal.contents" name="journal.contents" id="journal.contents"></textarea>
                    <span class="input-error" v-for="error in journal.errors.contents" v-text="error"></span>
                </div>

                <div :class="['input-group', journal.errors.events ? 'input-group--has-error' : '']">
                    <label class="input-label" for="journal.events">Special Events</label>
                    <textarea class="input-field" rows="5" v-model="journal.events" name="journal.events" id="journal.events"></textarea>
                    <span class="input-error" v-for="error in journal.errors.events" v-text="error"></span>
                </div>
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
                            eventBus.$emit('journal-refresh');
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
             * Submit the form when pressing ctrl/alt + enter.
             */
            hotkeySubmit(event) {
                if (event.ctrlKey || event.altKey) {
                    this.edit();
                };
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
