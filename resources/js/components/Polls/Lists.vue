<template>
    <div>
        <v-container>
            <v-layout row wrap>
                <v-flex>
                    <h1 class="text-xs-left display-1" style="max-width:40%">
                        Polls
                    </h1>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-pagination
                    v-model="currentPage"
                    :length="pagination.total"
                    ></v-pagination>
                </v-flex>
            </v-layout>
        </v-container>
        
        <v-container
            fluid
            grid-list-lg
        >
            <v-layout row wrap>
                <v-flex xs16 md3 v-for="poll in polls" :key="poll.id">
                    <v-card>
                        <v-card-title primary-title>
                            <div>
                            <div class="title">{{ poll.title }}</div>
                            <span>{{ poll.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn flat :to="`/poll/${poll.id}`">View</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat color="red" :to="`/poll/${poll.id}/edit`" v-if="poll.isMyPoll">Edit</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
    
</template>

<script>
export default {
    computed: {
        polls() {
            return this.$store.getters.polls
        },
        pagination() {
            return this.$store.getters.pagination
        },
        currentPage: {
            get() {
                return this.$store.getters.pagination.current
            },
            set(page) {
                this.$store.commit('PAGE', page)
            }
        }
    },
    watch: {
        currentPage() {
            console.log()
            this.fetchPolls(this.pagination.current)
        }
    },
    methods:{
        fetchPolls(page = 1) {
            this.$store.dispatch('pollLists', page)
        }
    },
    mounted() {
        this.fetchPolls()
    }   
}
</script>

<style>

</style>
