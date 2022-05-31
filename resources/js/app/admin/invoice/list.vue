<template>
    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Invoice List</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <input type="date" v-model="date_from" class="form-control" placeholder="From">
                            </div>
                            <div class="col-3">
                                <input type="date" v-model="date_to" class="form-control" placeholder="To">
                            </div>
                            <div class="col-3">
                                <button @click="invoiceList" type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table v-if="showSearch == true" id="features" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Shipping Address</th>
                                    <th>Gross Total</th>
                                    <th>Vat</th>
                                    <th>Tax</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="searchResult.length>0">
                                <tr v-for="(invoice, i) in searchResult" :key="i">
                                    <td>{{i}}</td>
                                    <td>{{invoice.customers.name}}</td>
                                    <td>{{invoice.customers.phone}}</td>
                                    <td>{{invoice.customers.address}}</td>
                                    <td>{{invoice.gross_total}}</td>
                                    <td>{{invoice.vat}}</td>
                                    <td>{{invoice.tax}}</td>
                                    <td v-if="invoice.status==1"><button class="btn btn-success btn-sm">Paid</button></td>
                                    <td v-else><button class="btn btn-danger btn-sm">Due</button></td>
                                    <td>
                                        <router-link :to="/update-invoice/ + `${invoice.id}`">
                                            <i class="fa fa-edit text-primary" data-toggle="Edit Invoice" title="Edit Invoice"></i>
                                        </router-link>
                                        <i @click="showDeleteModal(invoice, i)" data-toggle="modal" data-target="#deleteModal" class="fa fa-trash text-danger ml-2" title="Delete This Hospital"></i>
                                        <router-link :to="/view-invoice/ + `${invoice.id}`">
                                            <i class="fa fa-eye text-success ml-2" data-toggle="View Invoice" title="View Invoice"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="text-center">
                                    <td colspan="9" class="text-center"><span>No data Available</span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Serial</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Shipping Address</th>
                                    <th>Gross Total</th>
                                    <th>Vat</th>
                                    <th>Tax</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        <table v-else id="features" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Shipping Address</th>
                                    <th>Gross Total</th>
                                    <th>Vat</th>
                                    <th>Tax</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="invoices.length>0">
                                <tr v-for="(invoice, i) in invoices" :key="i">
                                    <td>{{i}}</td>
                                    <td>{{invoice.customers.name}}</td>
                                    <td>{{invoice.customers.phone}}</td>
                                    <td>{{invoice.customers.address}}</td>
                                    <td>{{invoice.gross_total}}</td>
                                    <td>{{invoice.vat}}</td>
                                    <td>{{invoice.tax}}</td>
                                    <td v-if="invoice.status==1"><button class="btn btn-success btn-sm">Paid</button></td>
                                    <td v-else><button class="btn btn-danger btn-sm">Due</button></td>
                                    <td>
                                        <router-link :to="/update-invoice/ + `${invoice.id}`">
                                            <i class="fa fa-edit text-primary" data-toggle="Edit Invoice" title="Edit Invoice"></i>
                                        </router-link>
                                        <i @click="showDeleteModal(invoice, i)" data-toggle="modal" data-target="#deleteModal" class="fa fa-trash text-danger ml-2" title="Delete This Hospital"></i>
                                        <router-link :to="/view-invoice/ + `${invoice.id}`">
                                            <i class="fa fa-eye text-success ml-2" data-toggle="View Invoice" title="View Invoice"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="text-center">
                                    <td colspan="9">No data Available</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Serial</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Shipping Address</th>
                                    <th>Gross Total</th>
                                    <th>Vat</th>
                                    <th>Tax</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            </section>
            <!-- /.content -->

            <!-- Delete Modal -->

            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalheadline" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalheadline">Delete Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete Invoice #{{deletingItemData.id}}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
                            <button @click="deleteInvoice" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
</template>

<script>
export default {
    data() {
        return {
           invoices : [], 
           searchResult : [],
           showSearch : false,

           deleteModalCall : true,
           deletingItemData : {},

           date_from : '',
           date_to : ''

        }
    },
    
    methods : {
        invoiceList() {
           fetch('/api/search-invoice?date_from='+this.date_from+'&&date_to='+this.date_to)
           .then(res => res.json())
           .then(res => {
               this.searchResult = res
               this.showSearch = true
           })
        },

        // Display Data in Delete Modal 

        showDeleteModal(invoice, i) {
            this.deletingItemData = invoice
            this.i = i
        },

        // Delete Item

        async deleteInvoice() {
            await axios.post('/api/delete-invoice/'+this.deletingItemData.id).then(response => {
                this.invoices.splice(this.i,1)
                this.searchResult.splice(this.i,1)
                this.$swal({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   icon: 'success',
                   title: 'Status',
                   text: 'Hospital Deleted Successfully !',
               })
            }).catch((error) => {
                this.deleteSuccess = false
            })
        }
    },

    mounted() {

    },

    async created() {
        await axios.get('/api/invoice-list').then(response => {
            this.invoices = response.data.invoiceList.data
            console.log(response.data.invoiceList.data)
        })

        await axios.get('/api/get-district').then(response => {
            this.districtList = response.data
        })
    }
}
</script>

<style scoped>
.fa {
    cursor:pointer;
    transition: 0.5s ease;
}

.fa:hover {
    opacity : .5;
}
</style>