import axios from 'axios'
import { without } from 'lodash'

export default {
  namespaced: true,

  state: {
    likes: []
  },

  getters: {
    likes (state) {
      return state.likes
    }
  },

  mutations: {
    PUSH_LIKES (state, data) {
      state.likes.push(...data)
 },

    PUSH_LIKE (state, id) {
      state.likes.push(id)
    },

    POP_LIKE (state, id) {
      state.likes = without(state.likes, id)//er madhome id remove korche
    }
  },

  actions: {
    async likeTweet (_, tweet) {//'_" convention.lage na.but dey.commit er poriborte
      await axios.post(`/api/tweets/${tweet.id}/likes`)
    },

    async unlikeTweet (_, tweet) {
      await axios.delete(`/api/tweets/${tweet.id}/likes`)
    },

    syncLike ({ commit, state }, id) {// like a click korar sathe sathe j id ta ase.app.js er echo theke
      if (state.likes.includes(id)) { //PUSH_LIKES er karone state.likes paoa geche
        commit('POP_LIKE', id)
        return
      }
      commit('PUSH_LIKE', id)
    }
  }
}
