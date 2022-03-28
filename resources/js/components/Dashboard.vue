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
                <span class="info-box-text"><router-link to="/labs">Lab Tests</router-link></span>
                <span class="info-box-number">{{labfindings}}</span>
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
                <span class="info-box-text"><router-link to="/patients"> Patients</router-link></span>
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
                <span class="info-box-text"><router-link to="/patientvitals">Patient Vitals</router-link></span>
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
                <span class="info-box-text"><router-link to="/labs">Lab Tests</router-link></span>
                <span class="info-box-number">{{labfindings}}</span>
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
                <span class="info-box-text"><router-link to="/patients">Patients</router-link></span>
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
                <span class="info-box-text"><router-link to="/drugsales">Sales</router-link></span>
                <span class="info-box-number">{{drugpurchases}}</span>
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

        <div v-if="$gate.isStaff()" class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Patient Visits</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Patients Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 12.5%
                    </span>
                    <span class="text-muted">Since last week</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <!-- <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="visitors-chart" height="200" width="479" style="display: block; width: 479px; height: 200px;" class="chartjs-render-monitor"></canvas>
                </div> -->

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This Week
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last Week
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

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

            <div v-if="$gate.isNurse()"  class="card">
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

            <div v-if="$gate.isPharm()" class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <!-- <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="sales-chart" height="200" style="display: block; width: 479px; height: 200px;" width="479" class="chartjs-render-monitor"></canvas>
                </div> -->

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div v-if="$gate.isAccountant()" class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Processed Bills</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Patients Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 12.5%
                    </span>
                    <span class="text-muted">Since last week</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <!-- <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="visitors-chart" height="200" width="479" style="display: block; width: 479px; height: 200px;" class="chartjs-render-monitor"></canvas>
                </div> -->

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This Week
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last Week
                  </span>
                </div>
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
                <div v-if="$gate.isDoc()" class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <i class="ion ion-ios-refresh-empty"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> {{consultations/patients * 100}}%
                    </span>
                    <span class="text-muted">CONSULTATION RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div v-if="$gate.isPharm()" class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <i class="ion ion-ios-refresh-empty"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> {{drugpurchases/patients * 100}}%
                    </span>
                    <span class="text-muted">SALES RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div v-if="$gate.isDocOrNurse()" class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i> {{labfindings/patients * 100}}%
                    </span>
                    <span class="text-muted">LAB TESTING RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div v-if="$gate.isDoc()" class="d-flex justify-content-between align-items-center mb-0">
                  <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-down text-danger"></i> {{prescriptions/patients * 100}}%
                    </span>
                    <span class="text-muted">PRESCRIPTION RATE</span>
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
            labfindings: {},
            prescriptions: {},
            drugpurchases: {},
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
              loadLabFindings(){
                axios.get('api/countlabfindings').then((response) => {this.labfindings = response.data});
              },
              loadPrescriptions(){
                axios.get('api/countprescriptions').then((response) => {this.prescriptions = response.data});
              },
              loadPendingLabsCount(){
                axios.get('api/countpendinglabs').then((response) => {this.pendinglabs = response.data});
              },
              loadPendingLabFindingsCount(){
                axios.get('api/countpendinglabfindings').then((response) => {this.pendinglabfindings = response.data});
              },
              loadDrugPurchases(){
                axios.get('api/countdrugpurchases').then((response) => {this.drugpurchases = response.data});
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
          this.loadLabFindings();
          this.loadPrescriptions();
          this.loadDrugPurchases();
          this.loadPendingLabsCount();
          this.loadPendingLabFindingsCount();
          this.loadPendingDrugSales();
          this.loadCompletedLabFindings();
          this.loadCompletedPrescriptions();
        }
    }
</script>
