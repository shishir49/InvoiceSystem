<template>
    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                    <li class="breadcrumb-item active">Update Invoice</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Inputs with (*) mark is compulsory</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer <span class="text-danger">*</span></label>
                                        <select v-model="invoiceInfo.customer_id" class="form-control mb-2">
                                            <option v-for="(customer,i) in customers" :key="i" :value="customer.id"> {{customer.name}}</option>
                                        </select>
                                        <span v-if="allerrors.name" class="text-danger">{{allerrors.name[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Product <span class="text-danger">*</span></label>
                                    <select class="form-control" v-model="invoiceInfo.invoice_products.product_id" @change="getProductCost">
                                        <option value="">Select a Product</option>
                                        <option v-for="(product, i) in products" :key="i" :value="product.id">{{ product.product_name }}</option>
                                    </select>
                                    <span v-if="allerrors.product_id" class="text-danger">{{allerrors.product_id[0]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vat</label>
                                        <input @keyup="calculateGrossTotal" type="text" class="form-control mb-2" v-model="invoiceInfo.vat" placeholder="Vat">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax</label>
                                        <input @keyup="calculateGrossTotal" type="text" class="form-control mb-2" v-model="invoiceInfo.tax" placeholder="Tax">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Quantity" v-model="invoiceInfo.invoice_products.quantity" @keyup="getProductCost">
                                    <span v-if="allerrors.quantity" class="text-danger">{{allerrors.quantity[0]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select v-model="invoiceInfo.status" class="form-control mb-2" placeholder="Status">
                                            <option value="">Status</option>
                                            <option value="1">Paid</option>
                                            <option value="2">Due</option>
                                        </select>
                                        <span v-if="allerrors.status" class="text-danger">{{allerrors.status[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tota Product Price  <span class="text-danger">*</span></label>
                                        <input disabled type="text" class="form-control mb-2" v-model="invoiceInfo.invoice_products.total" placeholder="Tota Product Price">
                                    <span class="text-danger" v-if="allerrors.total_product_price">{{allerrors.total_product_price[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gross Total  <span class="text-danger">*</span></label>
                                        <input disabled type="text" class="form-control mb-2" v-model="invoiceInfo.gross_total" placeholder="Gross Total">
                                    <span class="text-danger" v-if="allerrors.gross_total">{{allerrors.gross_total[0]}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <button @click="updateInvoice" type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    
    data() {
        return {
            allerrors : [],
            invoiceInfo : {
                customers : {},
                invoice_products : {},
                vat : 0
            },
            products : [],
            customers : [],
            data : {
                product_id : '',
                quantity : ''
            },
        }
    },

    methods : {
        async updateInvoice() {
            await axios.post('/api/update-invoice/'+this.$route.params.id, this.invoiceInfo).then(respone => {
                this.allerrors = []
                this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Status',
                   text: 'Invoice Updated Successfully !',
               })
            }).catch((error) => {
                this.allerrors = error.response.data.errors
                this.success - false
            })
        },

        getProductCost() {
           axios.get('/api/product-cost?product_id='+this.invoiceInfo.invoice_products.product_id+'&&quantity='+this.invoiceInfo.invoice_products.quantity, this.invoiceInfo).then(response => {
               this.invoiceInfo.invoice_products.total_product_price = Number(response.data)
               this.calculateGrossTotal
           })
        },
    },

    computed : {
        calculateGrossTotal() {
            var total = this.invoiceInfo.gross_total = Number(this.invoiceInfo.invoice_products.total_product_price)+Number(this.invoiceInfo.vat)+Number(this.invoiceInfo.tax)
            return total;
        }
    },

    async created() {
         await axios.get('/api/general-data').then(response => {
            this.products = response.data.products
            this.customers = response.data.customers
        })

        await axios.get('/api/single-invoice/'+this.$route.params.id).then(response => {
            this.invoiceInfo = response.data.invoice
        })
    },
}
</script>