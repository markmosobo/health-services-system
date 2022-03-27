<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">

            <!-- lab feedback -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pending Prescriptions</h3>
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
                      <th>Lab Result(s)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in labfindings.data" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>
                          <a href="#" style="align:center;" @click = "viewModal(item)">
                              <i class="fa fa-eye green"></i>
                          </a>                    
                      </td>
                      <td>
                          <button v-show="$gate.isDoc()" type="button" class="btn btn-primary" @click = "editModal(item)">Prescribe <i class="fas fa-tablets"></i></button>   
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

                <!-- View modal -->
            <div class="modal fade" id="viewNew" tabindex="-1" role="dialog"
            aria-labelledby="viewNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form > 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Lab Finding
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
                            <label>Results</label>  
                                    <textarea v-model="form.results" id="results"
                                    name="results" class="form-control" readonly="readonly">
                                    </textarea>
                                    <div v-if="form.errors.has('results')" v-html="form.errors.get('results')" />
                            </div>
                           
                    </div>
                   
                    </form>    
                </div>
            </div>
            </div>
        <!-- end of view modal --> 

        <!-- Modal -->
            <div class="modal fade" id="prepNew" tabindex="-1" role="dialog"
            aria-labelledby="prepNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updatePrep() : createPrep()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Prescription
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Prescription
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
                            <label>Results</label>  
                                    <textarea v-model="form.results" id="results"
                                    name="results" class="form-control" readonly="readonly">
                                    </textarea>
                                    <div v-if="form.errors.has('results')" v-html="form.errors.get('results')" />
                            </div>

                            <div class="form-group">
                            <label>Prescription</label>  
                                    <textarea v-model="form.prescription" id="prescription"
                                    name="prescription" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('prescription')" v-html="form.errors.get('prescription')" />
                            </div>
                           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-primary">
                        Post</button>
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
                labfindings: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        results: '',
                        prescription: ''
                })
            }
        },
        methods: {           
              viewModal(lab){
                  this.editmode = true,
                  this.form.reset();
                  $('#viewNew').modal('show')
                  this.form.fill(lab);  
              },
              editModal(lab){
                  this.editmode = true,
                  this.form.reset();
                  $('#prepNew').modal('show')
                  this.form.fill(lab);  
              },
              updatePrep(){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to prescribe this patient?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Deny`,
                }).then((result) => {
                    $('#prepNew').modal('hide')
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    this.form.put('api/lab/'+ this.form.id)
                    this.form.post('api/prescribe').then((response)=>{
                    toast.fire(
                    'Posted!',
                    "Prescription has been posted.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
                    }else if(result.isDenied){
                    Swal.fire('The prescription was not posted','','warning')
                    }
                })
              },              
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patients = response.data.data;
                    });
              },
              loadLabFindings(){
                  axios.get('api/labfindings').then((response) => {this.labfindings = response.data});
              }
        },
        mounted() {
            this.listPatients();
            this.loadLabFindings();
            Fire.$on('Refresh',() => {this.loadLabFindings();})
        }
    }
</script>
