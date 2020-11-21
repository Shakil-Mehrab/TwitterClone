<template>
  <div class="h-10 w-10 relative">
    <svg class="transform -rotate-90" viewBox="0 0 120 120">
      <circle
        cx="60"
        cy="60"
        fill="none"
        stroke-width="8"
        :r="radius"
        class="stroke-current text-gray-700"
      />
    <!-- stroke onek property dhrore - eta prefix.stroke-width mota/chikon.cy,cx margin,fill diye circle er vitor transparent, -->

      <circle
        cx="60"
        cy="60"
        fill="none"
        stroke-width="8"
        :r="radius"
        class="stroke-current text-blue-500"
        :stroke-dasharray="dash"
        :stroke-dashoffset="offset"
        :class="{
          '!text-red-500': percentageIsOver,
        }"
      />
       <!-- :class="{
          'text-red-500': percentageIsOver,
          'text-blue-500': !percentageIsOver
        }" -->
      <!-- eta agertake replace kore.dasg er karone color blue hoy.offset r dash first equal.offset 0 means dash fully vorat.anti property.2 jon same mane no circle color. -->
      <!-- dash-offset ja thakbe tia color hobe -->
    </svg>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        radius: 30
      }
    },

    props: {
      body: {
        required: true,
        type: String
      }
    },

    computed: {
      dash () {
        return 2 * Math.PI * this.radius
      },

      percentageIsOver () {
        return this.percentage > 100
      },

      percentage () {
        return Math.round((this.body.length * 100) / 280)
      },

      displayPercentage () {//percentage 100 er beshi hole ulto blue color remove hoy
        return this.percentage <= 100 ? this.percentage : 100
      },

      offset () {
        let circ = this.dash
        let progress = this.displayPercentage / 100
        return circ * (1 - progress)
      }
    }
  }
</script>
