<template>
    <div>
        <div class="wrapper">
            <Header/>
            <Sidebar/>
            <slot></slot>
            <Footer/>
        </div>
    </div>
</template>

<script>
import Header from '../components/header.vue'
import Footer from '../components/footer.vue'
import Sidebar from '../components/sidebar.vue'
export default {
    components : {
        Header, Footer, Sidebar
    }
}
</script>