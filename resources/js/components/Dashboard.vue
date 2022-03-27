<template>
    <div class="container mt-3"> 

        <div v-show="$gate.isStaff()" class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><router-link to="/patients">All Patients</router-link></span>
                <span class="info-box-number">{{patients}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><router-link to="/patientvitals">Patient Vitals</router-link></span>
                <span class="info-box-number">{{patientvitals}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <ul class="breadcrumb float-sm-right">

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{mymessages}}</span>
              </a>
          <div v-if="mymessages !== 0" class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <span class="dropdown-item dropdown-header">{{mymessages}} Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{mymessages}} new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <!-- <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new tasks
                <span class="float-right text-muted text-sm">2 days</span>
              </a> -->
              <div class="dropdown-divider"></div>
              <router-link to="/messages" href="#" class="dropdown-item dropdown-footer">See All Messages</router-link>
        </div>
        <div v-else class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-item dropdown-header">0 Notifications</span>
        </div>
            </li>
            </ul>
          </div>
          <!-- /.col -->
        </div>

        <div v-show="$gate.isDoc()" class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><router-link to="/patients">All Patients</router-link></span>
                <span class="info-box-number">{{patients}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-md"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><router-link to="/consultation">Consultations</router-link></span>
                <span class="info-box-number">{{consultations}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-vials"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Labs</span>
                <span class="info-box-number">{{labs}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <ul class="breadcrumb float-sm-right">

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{mymessages + pendinglabs + pendinglabfindings}}</span>
              </a>
          <div v-if="mymessages !== 0 || pendinglabs !== 0 || pendinglabfindings !== 0" class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <span class="dropdown-item dropdown-header">{{mymessages + pendinglabs + pendinglabfindings}} Notifications</span>
              <div class="dropdown-divider"></div>
              <router-link to="/messages" href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{mymessages}} new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link v-if="pendinglabs !== 0" to="/pendinglab" href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> {{pendinglabs + pendinglabfindings}} new tasks
                <span class="float-right text-muted text-sm">2 days</span>
              </router-link>
              <router-link v-else to="/pendingprescription" href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> {{pendinglabs + pendinglabfindings}} new tasks
                <span class="float-right text-muted text-sm">2 days</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link to="/messages" href="#" class="dropdown-item dropdown-footer">See All Messages</router-link>
        </div>
        <div v-else class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-item dropdown-header">0 Notifications</span>
        </div>
            </li>
            </ul>
          </div>
          <!-- /.col -->
        </div>

        <div v-show="$gate.isNurse()" class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">All Patients</span>
                <span class="info-box-number">{{patients}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Patient Vitals</span>
                <span class="info-box-number">{{patientvitals}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-vials"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Labs</span>
                <span class="info-box-number">{{labs}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <ul class="breadcrumb float-sm-right">

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{mymessages + pendinglabs + pendinglabfindings}}</span>
              </a>
              <div v-if="mymessages !== 0 || pendinglabs !== 0 || pendinglabfindings !== 0" class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <span class="dropdown-item dropdown-header">{{mymessages + pendinglabs + pendinglabfindings}} Notifications</span>
                    <div class="dropdown-divider"></div>
                    <router-link to="/messages" href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> {{mymessages}} new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <router-link v-if="pendinglabs !== 0" to="/pendinglab" href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> {{pendinglabs + pendinglabfindings}} new tasks
                      <span class="float-right text-muted text-sm">2 days</span>
                    </router-link>
                    <router-link v-else to="/pendingprescription" href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> {{pendinglabs + pendinglabfindings}} new tasks
                      <span class="float-right text-muted text-sm">2 days</span>
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <router-link to="/messages" href="#" class="dropdown-item dropdown-footer">See All Messages</router-link>
              </div>
              <div v-else class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                  <span class="dropdown-item dropdown-header">0 Notifications</span>
              </div>
            </li>
            </ul>
          </div>
          <!-- /.col -->
        </div>

        <div v-show="$gate.isPharm()" class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Patients</span>
                <span class="info-box-number">41,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <ul class="breadcrumb float-sm-right">

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{mymessages + pendingdrugsales}}</span>
              </a>
              <div v-if="mymessages !== 0 || pendingdrugsales !== 0" class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <span class="dropdown-item dropdown-header">{{mymessages + pendingdrugsales}} Notifications</span>
                    <div class="dropdown-divider"></div>
                    <router-link to="/messages" href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> {{mymessages}} new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <router-link to="/pendingdrugpurchase" href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> {{pendingdrugsales}} new tasks
                      <span class="float-right text-muted text-sm">2 days</span>
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <router-link to="/messages" href="#" class="dropdown-item dropdown-footer">See All Messages</router-link>
              </div>
              <div v-else class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                  <span class="dropdown-item dropdown-header">0 Notifications</span>
              </div>
            </li>
            </ul>
          </div>
          <!-- /.col -->
        </div>

        <div v-show="$gate.isAccountant()" class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Patients</span>
                <span class="info-box-number">{{patients}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bills</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <ul class="breadcrumb float-sm-right">

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{mymessages}}</span>
              </a>
          <div v-if="mymessages !== 0" class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <span class="dropdown-item dropdown-header">{{mymessages}} Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{mymessages}} new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <!-- <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new tasks
                <span class="float-right text-muted text-sm">2 days</span>
              </a> -->
              <div class="dropdown-divider"></div>
              <router-link to="/messages" href="#" class="dropdown-item dropdown-footer">See All Messages</router-link>
        </div>
        <div v-else class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-item dropdown-header">0 Notifications</span>
        </div>
            </li>
            </ul>
          </div>
          <!-- /.col -->
        </div>
        
        <div class="row mt-1">
          <div class="col-lg-6">

            <div v-if="$gate.isDoc()"  class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Latest Completed Tasks</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Patient</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="item in completedlabfindings.data" :key="item.id">
                    <td>
                      {{item.patient.first_name}} {{item.patient.last_name}}
                    </td>
                    <td><i class="fas fa-vials"></i></td>
                    <td>
                      <span class="badge badge-info">Success</span>
                    </td>
                    <td>
                      {{item.created_at | monthDateTime}}
                    </td>
                  </tr>
                  <tr v-for="item in completedprescriptions.data" :key="item.id">
                    <td>
                      {{item.patient.first_name}} {{item.patient.last_name}}
                    </td>
                    <td><i class="fas fa-tablets"></i></td>
                    <td>
                      <span class="badge badge-info">Success</span>
                    </td>
                    <td>
                      {{item.created_at | monthDateTime}}
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Performance Scale</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <i class="ion ion-ios-refresh-empty"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> 12%
                    </span>
                    <span class="text-muted">CONVERSION RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                    </span>
                    <span class="text-muted">SALES RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-down text-danger"></i> 1%
                    </span>
                    <span class="text-muted">REGISTRATION RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>

    </div>
</template>

<script>
    export default {
       props: ['app'],
       data(){
          return {
            mymessages: {},
            patients: {},
            patientvitals: {},
            consultations: {},
            labs: {},
            pendinglabs: {},
            pendinglabfindings: {},
            pendingdrugsales: {},
            completedlabfindings:{},
            completedprescriptions: {},
            newmessages: {}
          }
        },
        methods: { 
              loadMessageCount(){
                axios.get('api/countmessage').then((response) => {this.mymessages = response.data});
              },
              loadPatientCount(){
                axios.get('api/countpatients').then((response) => {this.patients = response.data});
              },                
              loadPatientVitals(){
                axios.get('api/countpatientvitals').then((response) => {this.patientvitals = response.data});
              },
              loadConsultations(){
                axios.get('api/countconsultations').then((response) => {this.consultations = response.data});
              },
              loadLabs(){
                axios.get('api/countlabs').then((response) => {this.labs = response.data});
              },
              loadPendingLabsCount(){
                axios.get('api/countpendinglabs').then((response) => {this.pendinglabs = response.data});
              },
              loadPendingLabFindingsCount(){
                axios.get('api/countpendinglabfindings').then((response) => {this.pendinglabfindings = response.data});
              },
              loadPendingDrugSales(){
                axios.get('api/countpendingdrugsales').then((response) => {this.pendingdrugsales = response.data});
              },
              loadCompletedLabFindings(){
                axios.get('api/completedlabfindings').then((response) => {this.completedlabfindings = response.data});
              },
              loadCompletedPrescriptions(){
                axios.get('api/completedprescriptions').then((response) => {this.completedprescriptions = response.data});
              },

        },
        mounted() {
          this.loadMessageCount();
          this.loadPatientCount();
          this.loadPatientVitals();
          this.loadConsultations();
          this.loadLabs();
          this.loadPendingLabsCount();
          this.loadPendingLabFindingsCount();
          this.loadPendingDrugSales();
          this.loadCompletedLabFindings();
          this.loadCompletedPrescriptions();
        }
    }
</script>
