<template>
    <div class="Journal">
        <button type="button" @click="showCreateModal = true">Create</button>
        <journal-sidebar
            :volumes="volumes"
            :journals="journals"
        ></journal-sidebar>

        <journal-list
            :journals="journals"
        ></journal-list>

        <journal-create-modal
            :show="showCreateModal"
            @close="showCreateModal = false"
        ></journal-create-modal>
    </div>
</template>

<script>
    import JournalList from './JournalList.vue';
    import JournalSidebar from './JournalSidebar.vue';
    import JournalCreateModal from './JournalCreateModal.vue';

    export default {

        components: {
            JournalList, JournalSidebar, JournalCreateModal,
        },

        /**
         * The component's data.
         */
        data() {
            return {
                volumes: [],
                journals: [],

                showCreateModal: false,
            };
        },

        /**
         * Register events handlers.
         */
        created() {
            eventBus.$on('volume-changed', this.volumeChanged);
        },

        /**
         * Prepare the component.
         */
        mounted() {
            this.getVolumes();

            if (this.hasVolumeParam()) {
                this.getJournals();
            }
        },

        methods: {
            /**
             * Get journals within the current volume.
             */
            getJournals() {
                this.$http.get('/api/journals', { params: {
                            volume: this.$route.params.volume,
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

                            if (!this.hasVolumeParam()) {
                                this.volumeChanged(_.last(this.volumes).volume);
                            }
                        });
            },

            /**
             * Handle volume changed event.
             */
            volumeChanged(volume) {
                this.$router.push({ name: 'volume', params: { volume, }});
                this.getJournals();
            },

            /**
             * Check if the current route has volume param.
             */
            hasVolumeParam() {
                return Boolean(this.$route.params.volume);
            },
        },

        watch: {
            $route() {
                if (!this.hasVolumeParam()) {
                    this.getVolumes();
                }
            },
        },
    }
</script>
