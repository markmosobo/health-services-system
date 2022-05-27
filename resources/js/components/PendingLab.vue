<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pending Labs</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <no-pending-task v-if ="pendinglabscount == 0"></no-pending-task>
              <div v-else class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Patient</th>
                      <th>Test(s)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="lab in pendinglabs.data" :key="lab.id">
                      <td>{{lab.id}}</td>
                      <td>{{lab.patient.first_name}} {{lab.patient.last_name}}</td>
                      <td>
                          <a href="#" style="align:center;" @click = "viewModal(lab)">
                              <i class="fa fa-eye green"></i>
                          </a>                    
                      </td>
                      <td>
                          <button v-show="$gate.isDocOrNurse()" type="button" class="btn btn-primary" @click = "editModal(lab)">Post Finding <i class="fas fa-vials"></i></button>   
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
                    <form> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                             Lab Test
                            </h5>   
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                             
                            <div class="form-group">

                                <label>Patient:</label>
                                <select readonly="readonly" class="form-control" v-model="form.patient_id">
                                  <option 
                                      v-for="pat in patientslist" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.first_name }} {{ pat.last_name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">

                                <label>Tests to be done:</label><br>
                                    <select readonly="readonly" class="form-control" v-model="form.lab_test_id">
                                      <option 
                                          v-for="test in labtests" :key="test.id"
                                          :value="test.id"
                                          :selected="test.id == form.lab_test_id">{{ test.name }} </option>
                                    </select>
                                    <div v-if="form.errors.has('lab_test_id')" v-html="form.errors.get('lab_test_id')" /> 
                            </div> 

                    </div>

                    </form>    
                </div>
            </div>
            </div>
        <!-- end of view modal -->  

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updateLab() : createLab()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Lab Finding
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Lab
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
                                      :selected="pat.id == form.patient_id">{{ pat.first_name }} {{ pat.last_name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">

                                <label>Tests done:</label><br>
                                    <select readonly="readonly" class="form-control" v-model="form.lab_test_id">
                                      <option 
                                          v-for="test in labtests" :key="test.id"
                                          :value="test.id"
                                          :selected="test.id == form.lab_test_id">{{ test.name }} </option>
                                    </select>
                                    <div v-if="form.errors.has('lab_test_id')" v-html="form.errors.get('lab_test_id')" /> 
                            </div>

                            <div class="form-group">
                            <label>Finding</label>  
                                    <textarea v-model="form.results" id="results"
                                    name="results" placeholder="Test results" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('results')" v-html="form.errors.get('results')" />
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
import NoPendingTask from './NoPendingTask.vue';
import NotFound from './NotFound.vue';
    export default {
  components: { NotFound, NoPendingTask },
        data(){
            return{
                editmode: false,
                pendinglabs: {},
                pendinglabscount: {},
                patientslist: {},
                labtests: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        lab_test_id: '',
                        results: ''
                })
            }
        },
        methods: {
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              viewModal(lab){
                  this.editmode = true,
                  this.form.reset();
                  $('#viewNew').modal('show')
                  this.form.fill(lab);  
              },
              editModal(lab){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(lab);  
              },
              updateLab(){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to post the lab finding?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Deny`,
                }).then((result) => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    this.form.put('api/pendinglab/'+ this.form.id)
                    this.form.post('api/lab')
                    this.form.post('api/labtestbill').then((response)=>{
                    toast.fire(
                    'Posted!',
                    "Lab finding has been posted.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
                    }else if(result.isDenied){
                    Swal.fire('The finding was not posted','','warning')
                    }
                })
              },
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              listLabTests(){
                  axios.get('api/listlabtests').then((response) => {
                    this.labtests = response.data.data;
                    });
              },               
              loadPendingLabs(){
                  axios.get('api/pendinglab').then((response) => {this.pendinglabs = response.data});
              },
              loadPendingLabsCount(){
                  axios.get('api/countpendinglabs').then((response) => {this.pendinglabscount = response.data});
              },
        },
        mounted() {
            this.loadPendingLabsCount();
            this.listPatients();
            this.listLabTests();
            this.loadPendingLabs();
            Fire.$on('Refresh',() => {this.loadPendingLabs();})
        }
    }
</script>
