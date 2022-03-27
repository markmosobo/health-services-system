<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Modes of Payment</h3>
                <div class="card-tools">
                 <button v-show="$gate.isAccountant()" type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-money-bill"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Payment ID</th>
                      <th>Name</th>
                      <th>Account Number</th>
                      <th v-show="$gate.isAccountant()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in payments.data" :key="item.id">
                      <td><a href="#">PAY{{item.id}}</a></td>
                      <td>{{item.name | capitalizeFirstLetter}}</td>
                      <td>{{item.account_number}}</td>
                      <td v-show="$gate.isAccountant()">
                          <a href="#" @click = "editModal(item)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deletePayment(item.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="payments" @pagination-change-page="getResults">
                  	<span slot="prev-nav">&lt; Previous</span>
	                  <span slot="next-nav">Next &gt;</span>
                </pagination> 
              </div>              
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updatePayment() : createPayment()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Payment Mode
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Payment Mode
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                            <label>Name</label>  
                                    <input v-model="form.name" type="text"
                                    name="name" class="form-control">
                                    <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>                           

                            <div class="form-group">
                            <label>Account Number(optional)*</label>  
                                    <input v-model="form.account_number" type="text"
                                    name="account_number" class="form-control">
                                    <div v-if="form.errors.has('account_number')" v-html="form.errors.get('account_number')" />
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-success">
                        Update</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">
                        Create</button>     
                    </div>
                   
                    </form>    
                </div>
            </div>
            </div>
        <!-- end of modal -->        
    </div>
</template>

<script>
    export default {
        data(){
           return{
            editmode:false, 
            payments: {},  
            form:new Form({
                    id: '',
                    name: '',
                    account_number: ''
                })    
            }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/payment?page=' + page).then(({ data }) => (this.payments = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(item){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(item);  
              },
              updatePayment(){
                  this.$Progress.start();
                  this.form.put('api/payment/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Payment information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createPayment(){
                  this.$Progress.start();
                  this.form.post('api/payment')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Payment created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              loadPayments(){
                  axios.get('api/payment').then((response) => {this.payments = response.data});
              }                          
        },
        created() {
            this.loadPayments();
            Fire.$on('Refresh',() => {this.loadPayments()});
        }
    }
</script>
