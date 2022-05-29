<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 login-panel">
                    <div class="card">
                        <div class="card-header">
                           <h4>Registration</h4>
                        </div>
                        <div class="card-body">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input v-model="inputs.name" type="text" class="form-control mb-2">
                            <span class="text-danger" v-if="allerrors.name">{{allerrors.name[0]}}</span>
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input v-model="inputs.email" type="text" class="form-control mb-2">
                            <span class="text-danger" v-if="allerrors.email">{{allerrors.email[0]}}</span>
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input v-model="inputs.password" type="password" class="form-control mb-2">
                            <span class="text-danger" v-if="allerrors.password">{{allerrors.password[0]}}</span>
                            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                            <input v-model="inputs.confirm_password" type="password" class="form-control mb-2">
                            <span class="text-danger" v-if="allerrors.confirm_password">{{allerrors.confirm_password[0]}}</span>
                            <button class="btn btn-success" @click="registration">Register</button>
                            <p>Already have an account ? Login <router-link to="/login">here</router-link></p>
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
           allerrors : [],
           inputs : {
               name : '',
               email : '',
               password : '',
               confirm_password : ''
           }
       }
   },

   methods : {
       async registration() {
           const registration = await axios.post('/api/registration', this.inputs).then(response => {
               this.allerrors = []
               this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Success',
                   text: 'Registration Successful !',
               })
               this.$router.push('/login')
           }).catch((error) => {
               this.allerrors = error.response.data.error
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