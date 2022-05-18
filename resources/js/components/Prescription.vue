<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!--lab results -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Prescriptions</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Patient</th>
                      <th>Prescription(s)</th>
                      <th>Prescribed On</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in prescriptions.data" :key="item.id">
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>{{item.drug.name}}</td>
                      <td>{{item.created_at | monthDateTime}}</td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
       
    </div>
</template>

<script>
    export default {
        data(){
            return{
                editmode: false,
                prescriptions: {},
                patientslist: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        prescription: ''
                })
            }
        },
        methods: {
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              loadPrescriptions(){
                  axios.get('api/prescribe').then((response) => {this.prescriptions = response.data});
              }
        },
        mounted() {
            this.listPatients();
            this.loadPrescriptions();
            Fire.$on('Refresh',() => {this.loadPrescriptions();})
        }
    }
</script>
