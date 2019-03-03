export default {
    USER(state, user) {
        state.user = user
    },
    POLLS(state, polls) {
        state.polls = polls
    },
    POLL(state, poll) {
        if(poll === 'reset') {
            state.poll = null
            state.poll = {
                title: '',
                description: '',
                type: 'single'
            }
            return
        }
        state.poll = poll
    },
    POLL_TITLE(state, title) {
        state.poll.title = title
    },
    POLL_DESCRIPTION(state, description) {
        state.poll.description = description
    },
    POLL_MODE(state, mode) {
        state.poll.type = mode
    },
    POLL_OPTIONS(state, options) {
        state.poll.options = options
    },
    PAGINATION(state, pagination) {
        state.pagination = pagination
    },
    PAGE(state, page) {
        state.pagination.current = page
    },
}