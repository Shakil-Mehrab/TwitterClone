<template>
  <p class="text-gray-300 whitespace-pre-wrap">
    <component :is="body" />
    <!-- component a muloto hashtag & mention file show hobe -->
    <!-- {{tweet.body}} -->
  </p>
</template>

<script>
  export default {
    props: {
      tweet: {
        required: true,
        type: Object
      }
    },

    computed: {
      body () {
        return {
          'template': `<div>${this.replaceEntities(this.tweet.body)}</div>`
        }
      },

      entities () {
        return this.tweet.entities.data.sort((a, b) => b.start - a.start)//desc .age last er tag niye kaj then tar agerta
      }
    },

    methods: {
      replaceEntities (body) {
        this.entities.forEach((entity) => {
          body = body.substring(0, entity.start) + this.entityComponent(entity) + body.substring(entity.end)//0(body er start) theke start(tager start) position a kay korbe
        })

        return body
      },

      entityComponent (entity) {
        return `<app-tweet-${entity.type}-entity body="${entity.body}" />`//2ta file ache.hastag & mention.ekhane body prop
      }
    }
  }
</script>
