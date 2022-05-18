<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <!-- <li class="nav-item">
            <router-link to="/analytics" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
               Analytics
              </p>
            </router-link>
             </li> -->

               <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
               Dashboard
              </p>
            </router-link>
             </li>
             @can('isDoc')
             <li class="nav-item">
                <router-link to="/consultation" class="nav-link">
                  <i class="fas fa-user-md nav-icon teal"></i>
                  <p>Consultations</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/labtest" class="nav-link">
                  <i class="fas fa-user-md nav-icon teal"></i>
                  <p>Lab Tests</p>
                </router-link>
              </li>                             
              @endcan           

             @can('isAccountant')
             <li class="nav-item">
                <router-link to="/bills" class="nav-link">
                  <i class="fas fa-money-bill nav-icon green"></i>
                  <p>Bills</p>
                </router-link>
              </li>             
             @endcan
             @can('isNurse')
             <li class="nav-item">
                <router-link to="/patientvitals" class="nav-link">
                  <i class="nav-icon fas fa-user-injured teal"></i>
                  <p>Patients' Vitals </p>             
                </router-link>
              </li>
              @endcan  
              @can('isPharm')  
              <li class="nav-item">
                <router-link to="/drugs" class="nav-link">
                  <i class="fas fa-tablets nav-icon teal"></i>
                  <p>Drugs</p>
                </router-link>
              </li> 
              @endcan                       
              @can('isStaff')
             <li class="nav-item">
                <router-link to="/patients" class="nav-link">
                  <i class="nav-icon fas fa-user-injured teal"></i>
                  <p>Patients </p>             
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/patientvitals" class="nav-link">
                  <i class="nav-icon fas fa-user-injured teal"></i>
                  <p>Patients' Vitals </p>             
                </router-link>
              </li>              
              @endcan 

               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file white"></i>
              <p>
                Tasks
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('isDoc')  
              <li class="nav-item">
                <router-link to ="/pendinglab" class="nav-link">
                  <i class="fas fa-vials nav-icon blue"></i>
                  <p>Lab Tests</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/pendingprescription" class="nav-link">
                  <i class="fas fa-tablets nav-icon"></i>
                  <p>Prescriptions</p>
                </router-link>
              </li>              
            @endcan 
            @can('isNurse')
            <li class="nav-item">
                <router-link to ="/pendinglab" class="nav-link">
                  <i class="fas fa-vials nav-icon blue"></i>
                  <p>Lab Tests</p>
                </router-link>
              </li>            
            @endcan 
            @can('isPharm')  
              <li class="nav-item">
                <router-link to="/pendingdrugpurchase" class="nav-link">
                  <i class="fas fa-tablets nav-icon teal"></i>
                  <p>Drug Sales</p>
                </router-link>
              </li> 
              @endcan                           
            @can('isStaff')  
              <li class="nav-item">
                <router-link to ="/rooms" class="nav-link">
                  <i class="far fa-hospital nav-icon brown"></i>
                  <p>Rooms</p>
                </router-link>
              </li>
              @endcan 
              @can('isAccountant')  
              <li class="nav-item">
                <router-link to ="/payment" class="nav-link">
                  <i class="fas fa-money-bill nav-icon green"></i>
                  <p>Mode of Payments</p>
                </router-link>
              </li>
              @endcan  
              @can('isSuperAdmin')  
              <li class="nav-item">
                <router-link to ="/tasks" class="nav-link">
                  <i class="fas fa-file nav-icon white"></i>
                  <p>Manage Tasks</p>
                </router-link>
              </li>
              @endcan                                     
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user blue"></i>
              <p>
                Profile
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('isDoc')
            <li class="nav-item">
              <router-link to="/labs" class="nav-link">
                <i class="nav-icon fas fa-vials blue"></i>
                <p>My Labs </p>                            
              </router-link>
              </li>              
              <li class="nav-item">
              <router-link to="/prescription" class="nav-link">
                <i class="nav-icon fas fa-tablets blue"></i>
                <p>My Prescriptions</p>                            
              </router-link>
              </li>
            @endcan 
            @can('isNurse')
            <li class="nav-item">
                <router-link to="/labs" class="nav-link">
                  <i class="fas fa-vials nav-icon red"></i>
                  <p>My Labs</p>
                </router-link>
            </li> 
            @endcan 
            @can('isPharm')
            <li class="nav-item">
                <router-link to="/drugsales" class="nav-link">
                  <i class="fas fa-tablets nav-icon red"></i>
                  <p>My Sales</p>
                </router-link>
            </li> 
            @endcan             
              <li class="nav-item">
              <router-link to="/profile" class="nav-link">
                <i class="nav-icon fas fa-cog cyan"></i>
                <p>
                Settings
                </p>
              </router-link>
              </li>    			  
            </ul>           
          </li>

          @can('isSuperAdmin')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/users" class="nav-link">
                <i class="nav-icon fas fa-users blue"></i>
                <p>All Users </p>                            
              </router-link>
              </li>              
              <li class="nav-item">
              <router-link to="/doctors" class="nav-link">
                <i class="nav-icon fas fa-user-md blue"></i>
                <p>Doctors </p>                            
              </router-link>
              </li>              
              <li class="nav-item">
                <router-link to ="/nurses" class="nav-link">
                  <i class="fas fa-user-nurse nav-icon blue"></i>
                  <p>Nurses</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/pharmacists" class="nav-link">
                  <i class="fas fa-tablets nav-icon"></i>
                  <p>Pharmacists</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/accountants" class="nav-link">
                  <i class="fas fa-user-circle nav-icon blue"></i>
                  <p>Accountants</p>
                </router-link>
              </li>                            
              <li class="nav-item">
                <router-link to="/staff" class="nav-link">
                  <i class="fas fa-user-tie nav-icon blue"></i>
                  <p>Staff</p>
                </router-link>
              </li>       
            </ul>
          </li>                       
          @endcan
          
          <li class="nav-item">
                <router-link to="/messages" class="nav-link">
                  <i class="fas fa-envelope nav-icon cyan"></i>
                  <p>Messages</p>
                </router-link>
          </li>        

          <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="nav-icon fas fa-power-off red"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
            </a>
          </li>
        </ul>
      </nav>