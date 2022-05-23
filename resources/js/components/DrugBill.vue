<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!--lab results -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Drug Bills</h3>
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
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Patient</th>
                      <th>Charge</th>
                      <th>Charged On</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in drugbills.data" :key="item.id">
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>{{item.drug.price}}</td>
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
                drugbills: {},
            }
        },
        methods: {
              loadDrugBills(){
                  axios.get('api/drugbill').then((response) => {this.drugbills = response.data});
              }
        },
        mounted() {
            this.loadDrugBills();
            Fire.$on('Refresh',() => {this.loadDrugBills();})
        }
    }
</script>
