<template>
    <v-container>
        <v-layout>
            <v-flex md8 pr-2>
                <v-card>
                    <v-card-title primary-title>
                        <div  class="text-xs-left">
                            <div class="headline">{{ poll.title }}</div>
                            
                            <span>{{ poll.description }}</span>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <v-container fluid>
                            <template v-if="poll.type === 'single'">
                                <v-radio-group v-model="votes" column>
                                    <template v-for="option in poll.options">
                                        <v-radio :key="option.id" :label="option.option" :value="option.id"></v-radio>
                                    </template>
                                </v-radio-group>
                            </template>
                            <template v-else>
                                <template v-for="option in poll.options">
                                    <v-checkbox v-model="votes" :key="option.id" :label="option.option" :value="option.id"></v-checkbox>
                                </template>
                            </template>
                            <v-list v-if="viewOptionRequests">
                                <v-subheader>Option Suggestions</v-subheader>
                                <v-list-tile
                                    v-for="option in poll.option_requests"
                                    :key="option.id"
                                    @click="true"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="option.option"></v-list-tile-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-icon :color="option.status == 'requested' ? 'teal' : 'grey'" @click="approveOption(option)">done</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                            <v-btn
                                color="primary"
                                @click="submitPoll"
                                :loading="isLoading"
                                >
                                {{ myVotesCount > 0 ? 'Vote again' : 'Vote'}}
                            </v-btn> 
                            <template v-if="poll.isMyPoll">
                                <v-btn flat color="orange" :to="`/poll/${poll.id}/edit`">Edit</v-btn>
                                <v-btn flat color="red" @click="deleteConfirm = true">Delete</v-btn>
                            </template>
                            <template  v-else>
                                <OptionRequest/>
                            </template>
                        </v-container>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex md4 pl-2>
                <v-card>
                    <v-card-title primary-title>
                        <template v-if="chartData">
                            <pie-chart :data="chartData"></pie-chart>
                        </template>
                         
                        <template v-if="!myVotesCount &&  !poll.isMyPoll">
                            <p>
                                Vote to see result
                            </p>
                        </template>
                        <template v-if="poll.isMyPoll && !chartData">
                            <p>
                                No votes yet
                            </p>
                        </template>
                    </v-card-title>
                    <v-card-actions>
                        <p v-if="myVotesCount" class="font-weight-medium">
                            Your votes: 
                            <span class="font-weight-black">{{ myVotesCount }}</span>
                        </p>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-snackbar
            v-model="snackbar"
            :timeout="3000"
            top="top"
            vertical="vertical"
            >
            {{ message }}
            <v-btn
                color="red"
                flat
                @click="snackbar = false"
            >
                Close
            </v-btn>
        </v-snackbar>
        <v-dialog
            v-model="deleteConfirm"
            max-width="400"
            >
            <v-card>
                <v-card-title class="headline">This action will delete this poll</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        flat="flat"
                        @click="deleteConfirm = false"
                    >
                        Disagree
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        flat="flat"
                        @click="deletePoll"
                    >
                        Agree
                    </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
    </v-container>
</template>

<script>
import OptionRequest from './OptionRequest'

export default {
    components: {
        OptionRequest
    },
    data() {
        return {
            deleteConfirm: false,
            message: '',
            snackbar: false,
            votes: [],
            isLoading: false
        }
    },
    computed: {
        viewOptionRequests() {
            if(typeof this.poll.option_requests !== 'undefined' && this.poll.option_requests.length > 0 && this.poll.isMyPoll)
                return true
            return false
        },
        poll() {
            return this.$store.getters.poll
        },
        chartData() {
            let poll = this.$store.getters.poll
            let options = poll.options
            let voteCount = poll.votes_count
            if(voteCount < 1 || !options)
                return false

            if(!poll.isMyPoll)
                if(!poll.my_votes_count)
                    return false
            let chart = []
            options.map(option => {
                chart.push([
                    option.option,
                    option.vote_count
                ])
            })
            return chart
        },
        myVotesCount() {
            return this.$store.getters.poll.my_votes_count
        }
    },
    methods:{
        fetchPoll() {
            this.$store.dispatch('poll', this.$route.params.id)
        },
        async submitPoll() {
            if(this.votes.length < 1) {
                this.message = 'Select one choice'
                this.snackbar = true
                return false
            }
            let res = await this.$store.dispatch('submitPoll', this.votes)
            if(res == 'voted') {
                this.message = 'Thak you for voting'
                this.snackbar = true
                this.votes = []
            }
        },
        async deletePoll() {
            let res = await this.$store.dispatch('deletePoll', this.$route.params.id)
            if(res == 'deleted')
                this.$router.push({'path': '/'})
        },
        async approveOption(option) {
            let res = await this.$store.dispatch('approveOption', option.id)
        }
    },
    mounted() {
        this.fetchPoll()
    }   
}
</script>

<style>

</style>
