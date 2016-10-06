<template>
    <modal
        :show="show"
        :callback="edit"
        :ok-text="'Edit'"
        @close="$emit('close')"
    >
        <div slot="heading">
            Update Journal
        </div>

        <div slot="body">
            <template v-if="dates.length > 0">
                <form @submit.prevent="callback">
                    <textarea class="textarea" v-model="journal.contents"></textarea>
                    <textarea class="textarea" v-model="journal.events"></textarea>
                </form>
            </template>
        </div>
    </modal>
</template>

<script>
    import _ from 'lodash';
    import Modal from './Modal.vue';

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
                this.dates = [];
                this.isLoading = false;

                this.journal.errors = [];
                this.journal.publish_date = '';
                this.journal.contents = '';
                this.journal.events = '';
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
