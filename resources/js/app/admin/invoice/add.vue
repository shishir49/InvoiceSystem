<template>
    <div>
       <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add New Invoice</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                            <li class="breadcrumb-item active">Add Invoice</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Inputs with (*) mark is compulsory</h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Customer <span class="text-danger">*</span></label>
                                    <select v-model="data.customer_id" class="form-control mb-2" placeholder="Customer">
                                        <option value="">Select Customer</option>
                                        <option v-for="(customer,i) in customers" :key="i" :value="customer.id"> {{customer.name}}</option>
                                    </select>
                                    <span v-if="allerrors.customer_id" class="text-danger">{{allerrors.customer_id[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Product <span class="text-danger">*</span></label>
                                    <select class="form-control" v-model="data.product_id" @change="getProductCost">
                                        <option value="">Select a Product</option>
                                        <option v-for="(product, i) in products" :key="i" :value="product.id">{{ product.product_name }}</option>
                                    </select>
                                    <span v-if="allerrors.product_id" class="text-danger">{{allerrors.product_id[0]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Vat</label>
                                    <input @keyup="calculateGrossTotal" type="text" class="form-control mb-2" v-model="data.vat" placeholder="Vat">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax</label>
                                        <input @keyup="calculateGrossTotal" type="text" class="form-control mb-2" v-model="data.tax" placeholder="Tax">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Quantity" v-model="data.quantity" @keyup="getProductCost">
                                    <span v-if="allerrors.quantity" class="text-danger">{{allerrors.quantity[0]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select v-model="data.status" class="form-control mb-2" placeholder="Status">
                                            <option value="">Status</option>
                                            <option value="1">Paid</option>
                                            <option value="2">Due</option>
                                        </select>
                                        <span class="text-danger" v-if="allerrors.status">{{allerrors.status[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Total Product Price  <span class="text-danger">*</span></label>
                                    <input @change="calculateGrossTotal" disabled type="text" class="form-control mb-2" v-model="data.total_product_price" placeholder="Tota Product Price">
                                    <span class="text-danger" v-if="allerrors.total_product_price">{{allerrors.total_product_price[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Gross Total  <span class="text-danger">*</span></label>
                                    <input disabled type="text" class="form-control mb-2" v-model="data.gross_total" placeholder="Gross Total">
                                    <span class="text-danger" v-if="allerrors.gross_total">{{allerrors.gross_total[0]}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <button @click="addInvoice" type="submit" class="btn btn-success">Submit</button>
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
            data : {
                customer_id : '',
                vat : 0,
                tax : 0,
                total_product_price : '',
                status : '',
                product_id : '',
                quantity : '',
                gross_total : ''
            },
        
            companyInfo : [],
            products : [],
            customers : []
        }
    },

    methods : {
        addInvoice() {
            axios.post('/api/add-invoice', this.data).then(respone => {
                this.allerrors = []
                this.data.customer_id = ''
                this.data.product_id = ''
                this.data.vat = ''
                this.data.tax = ''
                this.data.total_product_price = ''
                this.data.gross_total = ''
                this.data.quantity = ''
                this.data.status = ''
                this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Status',
                   text: 'Invoice Added Successfully !',
               })
            }).catch((error) => {
                this.allerrors = error.response.data.errors
            })
        },

        getProductCost() {
           axios.get('/api/product-cost?product_id='+this.data.product_id+'&&quantity='+this.data.quantity, this.data).then(response => {
               this.data.total_product_price = response.data
               this.calculateGrossTotal
           })
        },
    },

    computed : {
        calculateGrossTotal() {
            var total = this.data.gross_total = Number(this.data.total_product_price)+Number(this.data.vat)+Number(this.data.tax)
            return total;
        }
    },

    async created() {
        await axios.get('/api/general-data').then(response => {
            this.companyInfo = response.data.companyInfo
            this.products = response.data.products
            this.customers = response.data.customers
        })
    },
}
</script>

<style scoped>
.fa {
    cursor:pointer;
}
</style>