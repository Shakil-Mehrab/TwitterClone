import actions from './tweet/actions'
import mutations from './tweet/mutations'

export default {
  namespaced: true,

  state: {
    tweets: []
  },

  getters: {
    tweet (state) {
        return id=>state.tweets.find(t=>t.id==id)//only ekta
    },
    parents (state) {
        return id=>state.tweets.filter(t=>{//array
            return t.id!=id && !t.parent_ids.includes(parseInt(id))
        })
        .sort((a, b) => a.created_at - b.created_at)
    },
    replies (state) {
        return id=>state.tweets.filter(t=>t.parent_id==id)//array
        .sort((a, b) => a.created_at - b.created_at)
    },
  },
  mutations,
  actions
}
