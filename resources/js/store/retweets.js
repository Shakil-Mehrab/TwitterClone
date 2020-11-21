import { without } from 'lodash'

export default {
  namespaced: true,

  state: {
    retweets: []
  },

  getters: {
    retweets (state) {
      return state.retweets
    }
  },

  mutations: {
    PUSH_RETWEETS (state, data) {//timeline.js theke asche
      state.retweets.push(...data)
    },

    PUSH_RETWEET (state, id) {
      state.retweets.push(id)
    },

    POP_RETWEET (state, id) {
      state.retweets = without(state.retweets, id)
    }
  },

  actions: {
    async retweetTweet (_, tweet) {
      await axios.post(`/api/tweets/${tweet.id}/retweets`)
    },

    async unretweetTweet (_, tweet) {
      await axios.delete(`/api/tweets/${tweet.id}/retweets`)
    },

    syncRetweet ({ commit, state }, id) {//app.js theke asche ja broadcasting er fall.oi broadcastinf linten kore
      if (state.retweets.includes(id)) {
        commit('POP_RETWEET', id)
        return
      }

      commit('PUSH_RETWEET', id)
    }
  }
}
