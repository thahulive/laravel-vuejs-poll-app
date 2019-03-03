export default {
    async loggedUser({commit, state}) {
        if(state.user.id) return
        let user = await axios.get('/me').catch(error=>{
            console.log(error)
        })
        if(user.status == 200) {
            commit('USER', user.data.data)
            return 
        }
    },
    async createNewPoll({commit, state}) {
        let newPoll = await axios.post('/polls/create', state.poll)
        if(newPoll.status == 201) {
            commit('POLL', newPoll.data.data)
            return 'created'
        }
        return 'error'
    },
    async updatePoll({commit, state}) {
        let updatePoll = await axios.patch(`/polls/${state.poll.id}/edit`, state.poll)
        if(updatePoll.status == 201) {
            if(updatePoll.data.message == 'updated')
                commit('POLL', updatePoll.data.data)
            return 'updated'
        }
        return 'error'
    },
    async deletePoll({commit, state}, payload) {
        let res = await axios.delete(`/polls/${payload}`)
        if(res.status == 200) {
            if(res.data.message == 'deleted')
                return res.data.message
        }
        return 'error'
    },
    async saveOptions({commit, state}, payload) {
        let options = await axios.put('/polls/'+ state.poll.id, {
            options: payload
        })
        if(options.status == 201) {
            commit('POLL', options.data.data)
            return 'created'
        }
        return 'error'
    },
    async suggestOptions({commit, state}, payload) {
        let options = await axios.put(`/polls/${state.poll.id}/suggestion`, {
            options: payload
        })
        if(options.status == 201) {
            commit('POLL', options.data.data)
            return 'created'
        }
        return 'error'
    },
    async approveOption({commit, state}, payload) {
        let options = await axios.put(`/polls/${state.poll.id}/approve`, {
            option: payload
        })
        if(options.status == 201) {
            commit('POLL', options.data.data)
            return 'created'
        }
        return 'error'
    },
    async pollLists({commit, state}, page = 1) {
        let polls = await axios.get('/polls?page='+page)
        if(polls.status == 200) {
            if(polls.data.meta) {
                let pagination = {
                    total: polls.data.meta.last_page,
                    current: polls.data.meta.current_page
                }
                commit('PAGINATION', pagination)  
            }
            commit('POLLS', polls.data.data)
            return 'fetched'
        }
    },
    async poll({commit, state}, payload) {
        let poll = await axios.get(`/polls/${payload}`)
        if(poll.status == 200) {
            commit('POLL', poll.data.data)
            return 'fetched'
        }
    },
    async submitPoll({commit, state}, payload) {
        let options = []
        if(state.poll.type === 'single')
            options.push({
                option_id : payload,
                user_id: state.user.id
            })
        
        if(state.poll.type === 'multi')
            payload.map( vote => {
                options.push({
                    option_id : vote,
                    user_id: state.user.id
                })
            })
        if(options.length < 1)  return false 
        let vote = await axios.post(`/polls/${state.poll.id}/vote`, {
            votes: options
        })
        console.log(vote)
        if(vote.status == 200) {
            commit('POLL', vote.data.data)
            return 'voted'
        }
    }
}