<template>
    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                    <li class="breadcrumb-item active">View Invoice</li>
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
                    <h3 class="card-title">Invoice for Sale #{{ invoiceInfo.id }}</h3>
                    
                    <div class="card-tools">
                        <i @click ="print" class="fa fa-print text-success ml-2" data-toggle="Print Invoice" title="Print Invoice"></i>
                        <i @click ="pdfGenerator" class="fa fa-file-pdf ml-2" data-toggle="Download" title="Download">
                           
                        </i>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="invoice">
                    <div class="row" id="printable">
                        <h5>Invoice #{{ invoiceInfo.id }}</h5>
                        
                        <div class="col-sm-6">
                            <table class="">
                                <tr>
                                    <td><strong>Company</strong></td>
                                    <td>: {{ companyInfo.company_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Company Phone</strong></td>
                                    <td>: {{ companyInfo.company_phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Company Address</strong></td>
                                    <td>: {{ companyInfo.company_address }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-sm-6">
                            <table class="">
                                <tr>
                                    <td><strong>Customer</strong></td>
                                    <td>: {{ invoiceInfo.customers.name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Phone</strong></td>
                                    <td>: {{ invoiceInfo.customers.phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Address</strong></td>
                                    <td>: {{ invoiceInfo.customers.address }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <h5>Billing Address : </h5>
                            <hr>
                            <table class="">
                                <tr>
                                    <td><strong>Customer</strong></td>
                                    <td>: {{ invoiceInfo.customers.name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Phone</strong></td>
                                    <td>: {{ invoiceInfo.customers.phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Address</strong></td>
                                    <td>: {{ invoiceInfo.customers.address }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-sm-9 mt-4">
                            <div class="row">
                                <h5>Product Info : </h5>
                                <hr>
                                <table id="features" class="tabel table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(product, i) in products" :key="i">
                                            <td>{{ product.product_name }}</td>
                                            <td>{{ invoiceInfo.invoice_products.quantity }}</td>
                                            <td>{{ product.rate }}</td>
                                            <td>{{ invoiceInfo.invoice_products.total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Vat</td>
                                            <td>: {{ invoiceInfo.vat }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Tax</td>
                                            <td>: {{ invoiceInfo.tax }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Sub Total</td>
                                            <td>: {{ invoiceInfo.gross_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                
                </div>
                <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</template>

<script>
import jspdf from 'jspdf'
import html2canvas from 'html2canvas'

export default {
    
    data() {
        return {
            allerrors : [],
            invoiceInfo : {
                customers : {},
                invoice_products : {}
            },
            products : [],
            data : {
                product_id : '',
                quantity : ''
            },
            companyInfo : {}
        }
    },

    methods : {

        print() {
            this.$htmlToPaper('printable')
        },

        getProductCost() {
           axios.get('/api/product-cost?product_id='+this.getInvoiceById.product_id+'&&quantity='+this.getInvoiceById.quantity, this.data).then(response => {
               this.getInvoiceById.gross_total = response.data
           })
        },

        pdfGenerator() {
            window.html2canvas = html2canvas
            var doc = new jspdf({
                orientation: 'p',
                unit: 'px',
                format: 'a4',
                hotfixes: ['px_scaling'],
            })
            doc.html(document.querySelector('#invoice'), {
                callback : function(pdf) {
                    pdf.save('invoice.pdf')
                }
            })
        }
    },

    async created() {
         await axios.get('/api/general-data').then(response => {
            this.companyInfo = response.data.companyInfo
        })

        await axios.get('/api/single-invoice/'+this.$route.params.id).then(response => {
            this.invoiceInfo = response.data.invoice
        })

        await axios.get('/api/invoice-products/'+this.invoiceInfo.invoice_products.product_id).then(response => {
            this.products = response.data
        })
    },
}
</script>

<style scoped>
.fa {
    cursor : pointer;
    font-size: 20px;
}
</style>