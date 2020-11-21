import { get } from 'lodash'

export default {
  PUSH_TWEETS (state, data) {//same twwet id paginate a double count hobe na
    state.tweets.push(
      ...data.filter((tweet) => {
        return !state.tweets.map((t) => t.id).includes(tweet.id)
      })
    )
  },

  POP_TWEET (state, id) {//pop tweet exclude kore.eta total thakbe na tai map na kore filter
    state.tweets = state.tweets.filter((t) => {
      return t.id !== id
    })
  },

  SET_LIKES (state, { id, count }) {//id r count from broad casr theke.dynamic like count korar jono eta kora hoy.app.js theke eta call hoey Echo madhome
    state.tweets = state.tweets.map((t) => {
      if (t.id === id) {///t.like_count ascehe TweetResource theke r count asche TweetLikesWereUpdated event theke
        t.likes_count = count
      }

      if (get(t.original_tweet, 'id') === id) {//onek tweet er original_tweet nei .tae jonno like korle error dekhay/
        //tai lodsah theke get use kora hoy jate na thakle null dekahabe
        t.original_tweet.likes_count = count
      }

      return t
    })
  },

  SET_RETWEETS (state, { id, count }) {//id r count asche broadcast theke.dynamic count er jonno erokom ashce
    state.tweets = state.tweets.map((t) => {
      if (t.id === id) {
        t.retweets_count = count
      }

      if (get(t.original_tweet, 'id') === id) {
        t.original_tweet.retweets_count = count
      }

      return t
    })
  },

  SET_REPLIES (state, { id, count }) {//id r count asche broadcast theke ja app.js event carch kore ekhane pathay.ei mutation ti daynamic replies count er jonno
    state.tweets = state.tweets.map((t) => {
      if (t.id === id) {
        t.replies_count = count
      }

      if (get(t.original_tweet, 'id') === id) {
        t.original_tweet.replies_count = count
      }

      return t
    })
  }
}

