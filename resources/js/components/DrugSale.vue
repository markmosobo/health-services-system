<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!--lab results -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Drug Sales</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Patient</th>
                      <th>Drug(s) </th>
                      <th>Sold On</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in drugsales.data" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>{{item.drugs}}</td>
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
                drugsales: {},
                patientslist: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        tests: '',
                        results: ''
                })
            }
        },
        methods: {
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              loadDrugSales(){
                  axios.get('api/purchasedrug').then((response) => {this.drugsales = response.data});
              }
        },
        mounted() {
            this.listPatients();
            this.loadDrugSales();
            Fire.$on('Refresh',() => {this.loadDrugSales();})
        }
    }
</script>
