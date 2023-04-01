

<header id="header" class="header-one">

  <div class="site-navigation">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg navbar-dark p-0">
                
                
                <div id="navbar-collapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav mr-auto">
                      <li class="nav-item dropdown active">
                          <a href="{{route('frontend.home')}}" class="nav-link dropdown-toggle" >Home <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li class="active"><a href="{{route('frontend.home')}}">Home One</a></li>
                             <li class="active"><a href="{{route('frontend.home')}}">Home Two</a></li>
                          </ul>
                      </li>
					  
					  <li class="nav-item dropdown">
                          <a href="{{route('electricity.view')}}" class="nav-link dropdown-toggle" data-toggle="dropdown">Electricity <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('electricity.view')}}">Monthly Entry</a></li>
							<li><button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#tbviewModal"><i class='fa fa-list'></i> Letter To All </button></label></li>
							<li><a href="{{route('electricity.view')}}">Metter Reading</a></li>
							<li><a data-toggle="modal" data-target="#metterreadingModal">Metter Reading</a></li>
						  </ul>
                      </li>

                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Report <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a data-toggle="modal" data-target="#albillviewModal">All Tenant Bills</a></li>
							<li><a data-toggle="modal" data-target="#tbviewModal">Letter All</a></li>
                            <li><a href="team.html">Summery</a></li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Projects <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="projects.html">Projects All</a></li>
                            <li><a href="projects-single.html">Projects Single</a></li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Services <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="services.html">Services All</a></li>
                            <li><a href="service-single.html">Services Single</a></li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Features <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="404.html">404</a></li>
                            <li class="dropdown-submenu">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown">Parent Menu</a>
                                <ul class="dropdown-menu">
                                  <li><a href="#!">Child Menu 1</a></li>
                                  <li><a href="#!">Child Menu 2</a></li>
                                  <li><a href="#!">Child Menu 3</a></li>
                                </ul>
                            </li>
                          </ul>
                      </li>
                            
                      <li class="nav-item add" id="getEditArticleData" data-toggle="modal" data-target="#AddModal">
								<a class="nav-link" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
								   document.getElementById('logout-form').submit();">
								   {{ __('Logout') }}
							  </a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							 @csrf
							</form> 
					  </li>
                    </ul>
                </div>
              </nav>
          </div>
          <!--/ Col end -->
        </div>
        <!--/ Row end -->

        <div class="search-block" style="display: none;">
          <label for="search-field" class="w-100 mb-0">
            <input type="text" class="form-control" id="search-field" placeholder="Type what you want and enter">
          </label>
          <span class="search-close">&times;</span>
        </div><!-- Site search end -->
    </div>
    <!--/ Container end -->

  </div>
  <!--/ Navigation end -->
 
  
</header>
