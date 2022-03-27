<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bills</h3>
                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-vials"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bill ID</th>
                      <th>Patient</th>
                      <th>Doctor Charge</th>
                      <th>Lab Chargebill</th>
                      <th>Room Charge</th>
                      <th>No of Days</th>
                      <th>Transaction Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="bill in bills.data" :key="bill.id">
                      <td><a href="#" @click="previewModal(bill.id)">BL{{bill.id}}</a></td>
                      <td>{{bill.patient.name}}</td>
                      <td>{{bill.doctor_charge}}</td>
                      <td>{{bill.lab_chargebill}}</td>
                      <td>{{bill.room_charge}}</td>
                      <td>{{bill.no_of_days}}</td>
                      <td>{{bill.created_at | monthDateTime}}</td>
                      <td >
                          <a href="#" @click = "editModal(bill)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span v-show="$gate.isSuperAdminOrAdmin()">/</span>
                          <a href="#" v-if="$gate.isSuperAdminOrAdmin()" @click = "deleteBill(bill.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                      <td  v-if="$gate.isAccountant()">                        
                        <a href="#" v-if="$gate.isAccountant()" @click = "generateBill(bill.id)" class="btn btn-sm btn-info float-left">Generate</a>                                                       
                      </td>                      
                    </tr>
  
                  </tbody>
                </table>
              </div>             
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="bills" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateBill() : createBill()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Bill Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Bill
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                             
                            <div class="form-group">

                                <label>Patient:</label>
                                <select class="form-control" v-model="form.patient_id">
                                  <option 
                                      v-for="pat in patientslist" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">
                            <label>Lab Charge</label>  
                                    <input v-model="form.lab_chargebill" type="text"
                                    name="lab_chargebill" class="form-control">
                                    <div v-if="form.errors.has('lab_chargebill')" v-html="form.errors.get('lab_chargebill')" />
                            </div>

                            <div class="form-group">
                            <label>Room Charge</label>  
                                    <input v-model="form.room_charge" type="text"
                                    name="room_charge" class="form-control">
                                    <div v-if="form.errors.has('room_charge')" v-html="form.errors.get('room_charge')" />
                            </div>

                            <div class="form-group">
                            <label>No of Days</label>  
                                    <input v-model="form.no_of_days" type="text"
                                    name="no_of_days" class="form-control">
                                    <div v-if="form.errors.has('no_of_days')" v-html="form.errors.get('no_of_days')" />
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

        <!--preview modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="addNewModalTitle">
                            Bill Preview
                        </h3>   
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
            
                        <div class="card-header">
                            <h3 class="card-title">{{this.billpreview}}</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                            <li class="item">                                
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title float-right">
                                    Name</a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Doctor Charge
                                    <span class="badge badge-warning float-right">Ksh500</span></a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Lab Chargebill
                                    <span class="badge badge-info float-right">Ksh700</span></a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">
                                    Room Charge <span class="badge badge-danger float-right">
                                    Ksh350
                                </span>
                                </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">No of Days
                                    <span class="badge badge-success float-right">6</span></a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Total Bill
                                    <span class="badge badge-info float-right">Ksh7000</span></a>
                                </div>
                            </li>                            
                            </ul>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>        
        <!--end of preview modal -->      
    </div>
</template>

<script>
    export default {
        data(){
            return{
                bills: {},
                billpreview: {},
                editmode:false,
                patientslist: {},
                form: new Form ({
                    id: '',
                    patient_id: '',
                    doctor_charge: '',
                    room_charge: '',
                    no_of_days: '',
                    lab_chargebill: ''
                })
            }
        },
        methods: { 
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/bill?page=' + page).then(({ data }) => (this.bills = data));
              this.$Progress.finish();
            },              
              previewModal(id){
                  axios.get('api/bill/'+id).then((response) =>
                   {this.billpreview = response.data.data});

                   $('#myModal').modal('show')
              },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(bill){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(bill);  
              },
              updateBill(){
                  this.$Progress.start();
                  this.form.put('api/bill/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Bill information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createBill(){
                  this.$Progress.start();
                  this.form.post('api/bill')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Bill created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              loadBills(){
                  axios.get('api/bill').then((response) => {this.bills = response.data});
              }            
        },
        mounted() {
            this.listPatients();
            this.loadBills();
            Fire.$on('Refresh',() => {this.loadBills()});
        }
    }
</script>
