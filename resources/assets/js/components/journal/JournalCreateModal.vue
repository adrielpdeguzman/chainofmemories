<template>
    <modal
        large
        :show="show"
        :callback="create"
        :ok-text="'Create'"
        @close="$emit('close')"
    >
        <div slot="heading">
            Create New Journal
        </div>

        <div slot="body">
            <form v-if="dates.length > 0" @submit.prevent="create" @keyup.enter="hotkeySubmit">
                <div :class="['input-group', journal.errors.publish_date ? 'input-group--has-error' : '']">
                    <label class="input-label" for="journal.publish_date">Publish Date</label>
                    <select class="input-field" v-model="journal.publish_date" name="journal.publish_date" id="journal.publish_date">
                        <option v-for="date of dates" :value="date">
                            {{ date }}
                        </option>
                    </select>
                    <span class="input-error" v-for="error in journal.errors.publish_date" v-text="error"></span>
                </div>

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
                dates: [],
                isLoading: false,

                journal: {
                    errors: {},
                    publish_date: '',
                    contents: '',
                    events: '',
                },
            };
        },

        methods: {
            /**
             * Get the list of dates without entries for the user.
             */
            getDatesWithoutEntries() {
                this.$http.get('/api/journals/dates_without_entry')
                        .then(({body}) => this.dates = body);
            },

            /**
             * Create the journal entry.
             */
            create() {
                this.isLoading = true;
                this.$http.post('/api/journals', this.journal)
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
                this.dates = [];
                this.isLoading = false;

                this.journal.errors = {};
                this.journal.publish_date = '';
                this.journal.contents = '';
                this.journal.events = '';
            },

            /**
             * Submit the form when pressing ctrl/alt + enter.
             */
            hotkeySubmit(event) {
                if (event.ctrlKey || event.altKey) {
                    this.create();
                };
            },
        },

        watch: {
            show() {
                if (this.show) {
                    this.getDatesWithoutEntries();
                } else {
                    this.reset();
                }
            },
        },
    }
</script>
