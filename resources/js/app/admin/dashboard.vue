<template>
    <div>
        Assalamu Alaikum {{userInfo.name}}
        <p><button class="btn btn-danger btn-sm" @click="logout">Logout</button></p>
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

    methods : {
        logout() {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
            axios.get('/logout').then(response => {
               localStorage.removeItem('token')
               localStorage.removeItem('userInfo')
               this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Status',
                   text: 'Logout Successful !',
               })
               this.$router.push('/login')
            }).catch(errors => {
                console.log(errors.response.data)
            })
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