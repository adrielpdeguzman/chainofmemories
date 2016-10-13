<template>
    <div class="Journal">
        <journal-sidebar
            :volumes="volumes"
            :journals="journals"
        ></journal-sidebar>

        <journal-list
            :user="user"
            :journals="journals"
        ></journal-list>

        <journal-edit-modal
            :show="showEditModal"
            @close="showEditModal = false"
        ></journal-edit-modal>

        <journal-create-modal
            :show="showCreateModal"
            @close="showCreateModal = false"
        ></journal-create-modal>
    </div>
</template>

<script>
    import auth from '../services/auth';
    import JournalList from './journal/JournalList.vue';
    import JournalSidebar from './journal/JournalSidebar.vue';
    import JournalEditModal from './journal/JournalEditModal.vue';
    import JournalCreateModal from './journal/JournalCreateModal.vue';

    export default {
        /**
         * Check authentication before entering route.
         */
        beforeRouteEnter(to, from, next) {
            if (!auth.user.isAuthenticated) {
                next('/login');
            } else {
                next();
            }
        },

        components: {
            JournalList, JournalSidebar, JournalEditModal, JournalCreateModal,
        },

        /**
         * The component's data.
         */
        data() {
            return {
                user: auth.user,
                volumes: [],
                journal: [],
                journals: [],

                showCreateModal: false,
                showEditModal: false,
            };
        },

        /**
         * Register events handlers.
         */
        created() {
            eventBus.$on('journal-refresh', this.refresh);
            eventBus.$on('journal-edit', this.edit);
            eventBus.$on('journal-volume-changed', this.volumeChanged);
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
             * Check if the current route has volume param.
             */
            hasVolumeParam() {
                return Boolean(this.$route.params.volume);
            },

            /**
             * Handle journal volume changed event.
             */
            volumeChanged(volume) {
                this.$router.push({ name: 'volume', params: { volume, }});
                this.getJournals();
            },

            /**
             * Handle journal edit event.
             */
            edit(journal) {
                this.journal = journal;
                this.showEditModal = true;
            },

            /**
             * Handle journal refresh event.
             */
            refresh() {
                this.getVolumes();
                this.getJournals();
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
