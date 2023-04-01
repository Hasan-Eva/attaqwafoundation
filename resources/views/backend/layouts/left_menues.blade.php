     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
		<!-- Employee Start -->
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Theme 
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('header.view') }}" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Header </p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="{{ route('slider.view') }}" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Slider </p>
                </a>
              </li>
            </ul>
          </li>
		<!-- Employee End --> 
		<!-- Post Start -->
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Post 
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('post.view') }}" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Add New </p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="{{ route('post.edit') }}" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Edit </p>
                </a>
              </li>
            </ul>
          </li>
		<!-- Post End -->
		
		<!-- Management Report  --> 
		   <li class="nav-item">
            <a href="#" class="nav-link">
               <i class="nav-icon fas fa-th"></i>
              <p>
                Management Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('staff_report.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Staff List</p>
                </a>
              </li>
            </ul>
          </li>
		<!-- End Management Report  -->   
		<!-- Inventory Report  -->  
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Inventory Report
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('purchase_report.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Reports </p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="{{ route('issue_report.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Issue Reports </p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="{{ route('inventory_report.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock Reports </p>
                </a>
              </li>
            </ul>
          </li>
		<!-- End Inventory Report  -->  
		<!-- Start Routine Work Report  -->  
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Routine Work
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('routine_work.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show All </p>
                </a>
              </li>
            </ul>
          </li>
		<!-- End Routine Work Report  -->  
		<!-- Start Leave Register  -->  		  
		  <li class="nav-item">
            <a href="#" class="nav-link">
               <i class="nav-icon far fa-image"></i>
              <p>
                Leave Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('leave.staff.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave Guard</p>
                </a>
              </li>
            </ul>
          </li> 
		<!-- End Leave Section  --> 
		<!-- Start Leave Register  -->  		  
		<li class="nav-item">
            <a href="#" class="nav-link">
               <i class="nav-icon far fa-image"></i>
              <p>
                Leave Register
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('leave.staff.view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave Guard</p>
                </a>
              </li>
            </ul>
        </li> 
		<!-- End Leave Register  --> 
		  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                UI Elements
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/ribbons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ribbons</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
            	<a href="#" class="nav-link">
              	<i class="far fa-circle nav-icon"></i>
                  <p>General Elements
				  <i class="fas fa-angle-left right"></i>
				  </p>
                </a>
              
			  
				  <ul class="nav nav-treeview">
					  <li class="nav-item">
						<a href="pages/forms/general.html" class="nav-link">
						  <p>General Elements</p>
						</a>
					  </li>
				 </ul>
			 </li>
			  
            </ul>
          </li>
	<!-- Logout -->
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                {{ Auth::user()->name }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									<i class="far fa-circle nav-icon"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
              </li>
            </ul>
          </li>
         
        </ul>
      </nav>