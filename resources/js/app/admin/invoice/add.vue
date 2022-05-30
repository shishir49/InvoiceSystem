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
                </div><!-- /.container-fluid -->
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                    <label>Customer <span class="text-danger">*</span></label>
                                    <select v-model="data.customer_id" class="form-control mb-2" placeholder="Customer">
                                        <option value="">Select Customer</option>
                                        <option v-for="(customer,i) in customers" :key="i" :value="customer.id"> {{customer.name}}</option>
                                    </select>
                                    <span v-if="allerrors.customer_id" class="text-danger">{{allerrors.customer_id[0]}}</span>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                    <label>Vat</label>
                                    <input type="text" class="form-control mb-2" v-model="data.vat" placeholder="Vat">
                                    <span v-if="allerrors.vat">{{allerrors.vat[0]}}</span>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Tax</label>
                                        <input type="text" class="form-control mb-2" v-model="data.tax" placeholder="Tax">
                                        <span v-if="allerrors.tax">{{allerrors.tax[0]}}</span>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                    <label>Tota Product Price  <span class="text-danger">*</span></label>
                                    <input disabled type="text" class="form-control mb-2" v-model="data.total_product_price" placeholder="Tota Product Price">
                                    <span v-if="allerrors.total_product_price">{{allerrors.total_product_price[0]}}</span>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select v-model="data.status" class="form-control mb-2" placeholder="Status">
                                            <option value="">Status</option>
                                            <option value="1">Paid</option>
                                            <option value="2">Due</option>
                                        </select>
                                        <span v-if="allerrors.status">{{allerrors.status[0]}}</span>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <!-- <div class="col-md-6">
                                    <label for="">Product </label>
                                    <select class="form-control" v-model="data.product_id" @change="getProductCost">
                                        <option value="">Select a Product</option>
                                        <option v-for="(product, i) in products" :key="i" :value="product.id">{{ product.product_name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" placeholder="Quantity" v-model="data.quantity" @keyup="getProductCost">
                                </div> -->
                                <!-- /.col -->
                                <h3>Add Products</h3>
                                <div class="form-group" v-for="(item,k) in inputs" :key="k">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <select class="form-control" v-model="item.product_id" @change="getProductCost">
                                                <option value="">Select Product</option>
                                                <option v-for="(product, i) in products" :key="i" :value="product.id">{{ product.product_name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" placeholder="Quantity" v-model="item.quantity" @keyup="getProductCost">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" placeholder="Total" v-model="item.total">
                                        </div>
                                        <div class="col-md-3">
                                            <span>
                                                <i class="fa fa-minus-circle text-danger" @click="removeElement(k)" v-show="k || ( !k && inputs.length > 1)"></i>
                                                <i class="fa fa-plus-circle text-success ml-4" @click="addElement(k)" v-show="k == inputs.length-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                    <button @click="addInvoice" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
                            the plugin.
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.container-fluid -->
           </section>
           <!-- /.content -->
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
                vat : '',
                tax : '',
                total_product_price : '',
                status : ''
            },
            inputs : [{
                product_id : '',
                quantity : '',
                total : ''
            }],

            input : {
                product_id : '',
                quantity : '',
                total : ''
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
                this.data.vat = ''
                this.data.tax = ''
                this.data.total_product_price = ''
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
            console.log(this.item.product_id)
           axios.get('/api/product-cost?product_id='+this.item.product_id+'&&quantity='+this.item.quantity, this.data).then(response => {
               this.input.total = response.data
           })
        },

        addElement() {
           this.inputs.push({
                product_id : '',
                quantity : '',
                total : ''
           })
        },

        removeElement (index) {
           this.inputs.splice(index, 1)
        },
    },

    computed : {

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