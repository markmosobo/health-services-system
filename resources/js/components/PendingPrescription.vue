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
              <no-pending-task v-if ="labfindingscount == 0"></no-pending-task>
              <div v-else class="card-body table-responsive p-0"> 
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Patient</th>
                      <th>Test(s) Done</th>
                      <th>Lab Result(s)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in labfindings.data" :key="item.id">
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>{{item.tested.name}}</td>
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
                            <label>Patient Status</label>  
                                    <select v-model="form.patient_status" id="patient_status"
                                    name="patient_status" class="form-control">
                                    <option value="">Select Patient Status</option>
                                    <option value="inpatient">Inpatient</option>
                                    <option value="outpatient">Outpatient</option>
                                    </select>
                                    <div v-if="form.errors.has('patient_status')" v-html="form.errors.get('patient_status')" />
                            </div>                            

                            <div class="form-group">

                                <label>Drugs and Medicine</label>
                                <br>
                                <div class="form-check form-check-inline">
                                  <input @click="showTablets()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked/>
                                    <label class="form-check-label">Tablet</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input @click="showInjections()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">Injection</label>
                                </div> 
                                
                                <div class="form-check form-check-inline">
                                  <input @click="showLiquids()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">Liquid</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input @click="showInhalations()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">Inhalation</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input @click="showOralLiquids()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">Oral liquid</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input @click="showPfis()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">PFI</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input @click="showOthers()" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                  <label class="form-check-label" for="inlineRadio2">Others</label>
                                </div>

                                <select id="choosetablets" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in tabletdrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />


                                <select id="chooseinjections" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in injectiondrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />


                                <select id="chooseliquids" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in liquiddrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />


                                <select id="chooseinhalations" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in inhalationdrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />


                                <select id="chooseoralliquids" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in oralliquiddrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />


                                <select id="choosepfis" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in pfidrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />

                                <select id="chooseothers" class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in otherdrugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }} {{item.quantity}}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />

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
                labfindingscount: {},
                drugs: {},
                tabletdrugs: {},
                injectiondrugs: {},
                liquiddrugs: {},
                inhalationdrugs: {},
                oralliquiddrugs: {},
                pfidrugs: {},
                otherdrugs: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        results: '',
                        prescription: '',
                        status: '',
                        patient_status:''
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
                    this.form.post('api/prescribe')
                    this.form.post('api/drugbill').then((response)=>{
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
              listDrugs(){
                  axios.get('api/listdrugs').then((response) => {
                    this.drugs = response.data.data;
                    });
              }, 
              listTabletDrugs(){
                  axios.get('api/listtabletdrugs').then((response) => {
                    this.tabletdrugs = response.data.data;
                    });
              }, 
              listInjectionDrugs(){
                  axios.get('api/listinjectiondrugs').then((response) => {
                    this.injectiondrugs = response.data.data;
                    });
              }, 
              listLiquidDrugs(){
                  axios.get('api/listliquiddrugs').then((response) => {
                    this.liquiddrugs = response.data.data;
                    });
              }, 
              listInhalationDrugs(){
                  axios.get('api/listinhalationdrugs').then((response) => {
                    this.inhalationdrugs = response.data.data;
                    });
              },
              listOralLiquidDrugs(){
                  axios.get('api/listoralliquiddrugs').then((response) => {
                    this.oralliquiddrugs = response.data.data;
                    });
              },
              listPfiDrugs(){
                  axios.get('api/listpfidrugs').then((response) => {
                    this.pfidrugs = response.data.data;
                    });
              },
              listOtherDrugs(){
                  axios.get('api/listotherdrugs').then((response) => {
                    this.otherdrugs = response.data.data;
                    });
              },                                                       
              loadLabFindings(){
                  axios.get('api/labfindings').then((response) => {this.labfindings = response.data});
              },
              loadLabFindingsCount(){
                  axios.get('api/countpendinglabfindings').then((response) => {this.labfindingscount = response.data});
              },
              showTablets(){
                  document.getElementById("choosetablets").style.visibility="visible"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="hidden"
              }, 
              showInjections(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="visible"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="hidden"
              }, 
              showLiquids(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="visible"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="hidden"
              }, 
              showInhalations(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="visible"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="hidden"
              },
              showOralLiquids(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="visible"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="hidden"
              },  
              showPfis(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="visible"
                  document.getElementById("chooseothers").style.visibility="hidden"
              }, 
              showOthers(){
                  document.getElementById("choosetablets").style.visibility="hidden"
                  document.getElementById("chooseinjections").style.visibility="hidden"
                  document.getElementById("chooseliquids").style.visibility="hidden"
                  document.getElementById("chooseinhalations").style.visibility="hidden"
                  document.getElementById("chooseoralliquids").style.visibility="hidden"
                  document.getElementById("choosepfis").style.visibility="hidden"
                  document.getElementById("chooseothers").style.visibility="visible"
              },              
        },
        mounted() {
            this.listPatients();
            this.listDrugs();
            this.listTabletDrugs();
            this.listInjectionDrugs();
            this.listLiquidDrugs();
            this.listInhalationDrugs();
            this.listOralLiquidDrugs();
            this.listPfiDrugs();
            this.listOtherDrugs();
            this.loadLabFindings();
            this.loadLabFindingsCount();
            //hide dropdowns not clicked on
            document.getElementById("choosetablets").style.visibility="visible"
            document.getElementById("chooseinjections").style.visibility="hidden"
            document.getElementById("chooseliquids").style.visibility="hidden"
            document.getElementById("chooseinhalations").style.visibility="hidden"
            document.getElementById("chooseoralliquids").style.visibility="hidden"
            document.getElementById("choosepfis").style.visibility="hidden"
            document.getElementById("chooseothers").style.visibility="hidden"
            Fire.$on('Refresh',() => {this.loadLabFindings();})
        }
    }
</script>
