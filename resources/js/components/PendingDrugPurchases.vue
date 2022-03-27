<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">

            <!-- lab feedback -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pending Drug Sales</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Patient</th>
                      <th>Prescription</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in pendingprescriptions.data" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>
                          <a href="#" style="align:center;" @click = "viewModal(item)">
                              <i class="fa fa-eye green"></i>
                          </a>                    
                      </td>
                      <td>
                          <button v-show="$gate.isPharm()" type="button" class="btn btn-primary" @click = "editModal(item)">Sell <i class="fas fa-tablets"></i></button>   
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
          </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewNew" tabindex="-1" role="dialog"
            aria-labelledby="viewNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Prescription
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
                                      v-for="pat in patients" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.first_name }} {{ pat.last_name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">
                            <label>Prescription</label>  
                                    <textarea readonly="readonly" v-model="form.prescription" id="prescription"
                                    name="prescription" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('prescription')" v-html="form.errors.get('prescription')" />
                            </div>
                           
                    </div>

                    </form>    
                </div>
            </div>
            </div>
        <!-- end of view modal -->

        <!-- Modal -->
        <div class="modal fade" id="drugprepNew" tabindex="-1" role="dialog"
            aria-labelledby="drugprepNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updateDrugPrep() : createDrugPrep()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Drug Purchase
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Drug Prescription
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
                                      v-for="pat in patients" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.first_name }} {{ pat.last_name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">
                            <label>Prescription</label>  
                                    <textarea readonly="readonly" v-model="form.prescription" id="prescription"
                                    name="prescription" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('prescription')" v-html="form.errors.get('prescription')" />
                            </div>

                            <div class="form-group">
                            <label>Drugs Bought</label>  
                                    <textarea v-model="form.drugs" id="drugs"
                                    name="drugs" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('drugs')" v-html="form.errors.get('drugs')" />
                            </div>
                           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-primary">
                        Save</button>
                        <button type="submit" v-show="!editmode" class="btn btn-success">
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
                editmode: false,
                patients: {},
                pendingprescriptions: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        remarks: '',
                        status: '',
                        drugs: '',
                        prescription: ''
                })
            }
        },
        methods: {           
              viewModal(item){
                  this.editmode = true,
                  this.form.reset();
                  $('#viewNew').modal('show')
                  this.form.fill(item);  
              },
              editModal(item){
                  this.editmode = true,
                  this.form.reset();
                  $('#drugprepNew').modal('show')
                  this.form.fill(item);  
              },
              updateDrugPrep(){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to sell drugs this patient?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Deny`,
                }).then((result) => {
                    $('#drugprepNew').modal('hide')
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    this.form.put('api/prescribe/'+ this.form.id)
                    this.form.post('api/purchasedrug').then((response)=>{
                    toast.fire(
                    'Processed!',
                    "Drug sale has been saved.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
                    }else if(result.isDenied){
                    Swal.fire('The drug sale was not saved','','warning')
                    }
                })
              },              
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patients = response.data.data;
                    });
              },
              loadPendingPrescriptions(){
                  axios.get('api/pendingprescribe').then((response) => {this.pendingprescriptions = response.data});
              }
        },
        mounted() {
            this.listPatients();
            this.loadPendingPrescriptions();
            Fire.$on('Refresh',() => {this.loadPendingPrescriptions();})
        }
    }
</script>
