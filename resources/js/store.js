import { createStore } from 'vuex'
import 'sweetalert2/dist/sweetalert2.min.css';

const store = createStore({
    state() {
        return {
            invoice_info : {}
        }
    },

    getters : {
        get_invoice_info(state) {
            return state.invoice_info
        },
    },

    mutations : {
        SINGLE_INVOICE(state, value) {
            return state.invoice_info = value
        },
    },

    actions : {
        getInvoiceById(context, payload) {
            axios.get('/api/single-invoice/'+payload).then(response => {
                context.commit('SINGLE_INVOICE', response.data.invoice)
                console.log(response.data.invoice)
            })
        },
    }
})

export default store