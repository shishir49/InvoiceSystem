<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 login-panel">
                    <div class="card">
                        <div class="card-header">
                           <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <label for="username">Email</label>
                            <input v-model="inputs.email" type="text" class="form-control mb-2">
                            <label for="password">Password</label>
                            <input v-model="inputs.password" type="password" class="form-control mb-2">
                            <button class="btn btn-success" @click="login">Login</button>
                            <p>Don't have an account ? Register <router-link to="/registration">here</router-link></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errorMessage : '',
            inputs : {
                email : '',
                password : '',
                device_name : 'browser'
            },
            errors : {}
        }
    },

    methods : {
        login() {
            axios.post('/api/login', this.inputs).then(response => {
                localStorage.setItem('token', response.data.access_token)
                this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Success',
                   text: 'Login Successful !',
               })
               this.$router.push({ path: '/dashboard' })
             }).catch((errors) => {
                this.errors = errors.response.data.error
                this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'error',
                   title: 'Failed',
                   text: 'Incorrect Login Credential !',
               })
            })
        }
    }
}
</script>

<style scoped>
body {
    background: #eee;
}
.login-panel {
    /* background:red; */
}
</style>