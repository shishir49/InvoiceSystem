<template>
    <div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link to="/" class="nav-link">Home</router-link>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="/user/avator.jpg" height="20" width="20" alt=""  class="img-circle elevation-2"> &nbsp; {{ currentUser.name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <button @click="logout()" type="button" class="dropdown-item text-center">
                            Logout
                        </button>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import 'sweetalert2/dist/sweetalert2.min.css';

export default defineComponent({
    data() {
        return {
            token : localStorage.getItem('token'),
            currentUser : {}
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
        
    },

    created() {
        if(localStorage.getItem('token')) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${this.token}`
                    axios.get('/api/user').then(response => {
                    localStorage.setItem('userInfo', JSON.stringify(response.data))
                    let getUser = localStorage.getItem('userInfo')
                    this.currentUser = JSON.parse(getUser)
                    }).catch(errors => {
                        // console.log(errors)
                    })
        }
        
    }

})
</script>
