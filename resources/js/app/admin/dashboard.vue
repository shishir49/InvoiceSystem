<template>
    <div>
        Assalamu Alaikum {{userInfo.name}}
    </div>
</template>

<script>
export default {
    data() {
        return {
            token : localStorage.getItem('token'),
            userInfo : {}
        }
    },

    mounted() {
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        axios.get('/api/user').then(response =>{
            this.userInfo = response.data
        })
    }
}
</script>