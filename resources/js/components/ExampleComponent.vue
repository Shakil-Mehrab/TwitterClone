<template>
    <div class="container">
    {{user}}
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            user:null
        }
    },
    methods: {
        async getUser(){
            let response = await axios.get('/user')
            this.user= response.data
            console.log(this.user)
        }
    },
    mounted() {
        this.getUser()
    }
}
</script>
