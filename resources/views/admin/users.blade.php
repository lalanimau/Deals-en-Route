<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="description" content="Bootstrap Admin App + jQuery">
      <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
      <title>DealsEnRoute - Admin Panel</title>
      <link rel="shortcut icon" href="{{ asset('img/admin/favicon.ico') }}" type="image/x-icon">
      <!-- =============== VENDOR STYLES ===============-->
      <!-- FONT AWESOME-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/fontawesome/css/font-awesome.min.css') }}">
      <!-- SIMPLE LINE ICONS-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/simple-line-icons/css/simple-line-icons.css') }}">
      <!-- ANIMATE.CSS-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/animate.css/animate.min.css') }}">
      <!-- WHIRL (spinners)-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/whirl/dist/whirl.css') }}">
      <!-- =============== PAGE VENDOR STYLES ===============-->
      <!-- WEATHER ICONS-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/weather-icons/css/weather-icons.min.css') }}">
      <!-- DATATABLES-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/datatables-colvis/css/dataTables.colVis.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/admin/datatables/media/css/dataTables.bootstrap.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/admin/dataTables.fontAwesome/index.css') }}">
      <!-- =============== BOOTSTRAP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css') }}" id="bscss">
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}" id="maincss">
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}">
   </head>
   <body>
      <div class="wrapper">
         <!-- top navbar-->
         <header class="topnavbar-wrapper">
            <!-- START Top Navbar-->
            <nav role="navigation" class="navbar topnavbar">
               <!-- START navbar header-->
               <div class="navbar-header">
                  <a href="#/" class="navbar-brand">
                     <div class="brand-logo">
                        <img src="{{ asset('img/admin/logo.png') }}" alt="App Logo" class="img-responsive">
                     </div>
                     <div class="brand-logo-collapsed">
                        <img src="{{ asset('img/admin/logo-single.png') }}" alt="App Logo" class="img-responsive">
                     </div>
                  </a>
               </div>
               <!-- END navbar header-->
               <!-- START Nav wrapper-->
               <div class="nav-wrapper">
                  <!-- START Left navbar-->
                  <ul class="nav navbar-nav">
                     <li>
                        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                        <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                           <em class="fa fa-navicon"></em>
                        </a>
                        <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                        <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                           <em class="fa fa-navicon"></em>
                        </a>
                     </li>
                  </ul>
                  <!-- END Left navbar-->
                  <!-- START Right Navbar-->
                  <ul class="nav navbar-nav navbar-right">
                     <!-- START user name-->
                     <li class="dropdown dropdown-list user-name">
                        <a href="dashboard.html" data-toggle="dropdown">
                           <em class="icon-user"></em> Admin
                        </a>
                        <!-- START Dropdown menu-->
                        <ul class="dropdown-menu animated flipInX">
                           <li>
                              <!-- START list group-->
                              <div class="list-group">
                                 <!-- last list item-->
<!--                                 <a href="#" class="list-group-item">
                                    <small>My Profile</small>
                                 </a>
                                 <a href="#" class="list-group-item">
                                    <small>Change Password</small>
                                 </a>-->
                                 <a href="{{ url('/admin/logout') }}" class="list-group-item"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                             <i class="fa fa-sign-out"></i>  Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                              </div>
                              <!-- END list group-->
                           </li>
                        </ul>
                        <!-- END Dropdown menu-->
                     </li>
                     <!-- END Alert menu-->
                  </ul>
                  <!-- END Right Navbar-->
               </div>
               <!-- END Nav wrapper-->
            </nav>
            <!-- END Top Navbar-->
         </header>
         <!-- sidebar-->
         <aside class="aside">
            <!-- START Sidebar (left)-->
            <div class="aside-inner">
               <nav data-sidebar-anyclick-close="" class="sidebar">
                  <!-- START sidebar nav-->
                  <ul class="nav">
                     
                     <!-- Iterates over all sidebar items-->
                     <li class="">
                        <a href="{{ asset('admin/home') }}" title="Dashboard">
                           <em class="icon-speedometer"></em>
                           <span>Dashboard</span>
                        </a>
                        
                     </li>
                     <li class="active">
                        <a href="{{ asset('admin/userlist') }}" title="Users">
                           <em class="icon-people"></em>
                           <span>Users</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/vendorlist') }}" title="Businesses">
                           <em class="icon-briefcase"></em>
                           <span>Businesses</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/categories') }}" title="Packages">
                           <em class="fa fa-inbox"></em>
                           <span>Categories</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/reported-content') }}" title="Reported Content">
                           <em class="icon-docs"></em>
                           <span>Reported Content</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/city') }}" title="Cities">
                           <em class="fa fa-building-o"></em>
                           <span>Cities</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/payments') }}" title="Payments">
                           <em class="fa fa-money"></em>
                           <span>Payments</span>
                        </a>
                     </li>
                  </ul>
                  <!-- END sidebar nav-->
               </nav>
            </div>
            <!-- END Sidebar (left)-->
         </aside>
         
         <!-- Main section-->
         <section>
            <!-- Page content-->
            <div class="content-wrapper">
               <h3>
               Users
               <small class="sub-title"></small>
               
               </h3>
               <div class="container-fluid">
                  <!-- START DATATABLE 1-->
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <div class="col-xs-8">
                                 <div class="row">
                                     <div class="form-group">
                                         <form id="user_filter" method="get" action="{{ asset('admin/userlist') }}">
                                             <label class="col-sm-1 control-label" style="padding: 0 5px 0;top: 5px;">Filter</label>
                                             <div class="col-sm-3" style="padding: 0 5px 0;">
                                                 <select name="signuptype" class="form-control m-b">
                                                     <option value="" @if($signuptype == '') selected @endif>Signup Type</option>
                                                     <option value="facebook" @if($signuptype == 'facebook') selected @endif>Facebook</option>
                                                     <option value="google" @if($signuptype == 'google') selected @endif>Google+</option>
                                                     <option value="twitter" @if($signuptype == 'twitter') selected @endif>Twitter</option>
                                                     <option value="email" @if($signuptype == 'email') selected @endif>Email</option>
                                                 </select>
                                             </div>
                                             <div class="col-sm-3" style="padding: 0 5px 0;">
                                                 <select name="userstatus" class="form-control m-b">
                                                     <option value="" @if($userstatus == '') selected @endif>User Status</option>
                                                     <option value="1" @if($userstatus == '1') selected @endif>Active</option>
                                                     <option value="0" @if($userstatus == '0') selected @endif>Not Active</option>
                                                 </select>
                                                 
                                                 
                                             </div>
                                             <div class="col-sm-3" style="padding: 0 5px 0;"><input placeholder="User Name" type="text" class="form-control m-b" name="user_search" value="{{$user_search}}"></div>
                                             <div class="col-sm-2" style="padding: 0 5px 0;"><button class="btn btn-info btn-oval">Search</button></div>
                                             <input type="hidden" value="0" name="is_pdf" id="is_pdf">
                                         </form>
                                     </div>
                                 </div>
                              </div>
                              <div class="col-xs-4 text-right">
                                  <button type="button" class="btn btn-primary btn-oval" value='export' onclick="pdf()">Export PDF</button>
                              </div>
                              <div class="col-xs-12 mt-15">
                                   @if(count($user_list) > 0)
                                 <div class="table-responsive user-management">
                                    <table class="table table-striped table-hover">
                                       
                                       <thead>
                                          <tr>
                                             <th>Name</th>
                                             <th>Email</th>
                                             <th class="sort-numeric">Age</th>
                                             <th>Gender</th>
                                             <th class="sort-numeric">Coupons Redeemed</th>
                                             <th>SignUp Type</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($user_list as $row)
                                          <tr>
                                             <td>{{$row->first_name ?:'-'}} {{$row->last_name}}</td>
                                             <td>t{{$row->email ?:'-'}}</td>
                                             <td>{{$row->age ?:'-'}}</td>
                                             <td>{{$row->gender ?:'-'}}</td>
                                             <td>{{$row->coupons ?:'-'}}</td>
                                             <td>{{($row->fb_token != '') ?'facebook':''}}{{($row->google_token!= '') ?'google':''}}{{($row->twitter_token != '') ?'twitter':''}}</td>
                                             <td><span class="active">{{($row->is_active == 0) ?'InActive':'Active'}}</span></td>
                                             <td><a href="{{ asset('admin/user-detail/'.$row->id)}}">View Details</a></td>
                                          </tr>
                                         @endforeach
                                       </tbody>
                                    </table>
                                     {{ $user_list->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                                 </div>
                                   @else
                                   <span style="color: red;margin-left: 42%;">No Record Found</span>
                                   @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Page footer-->
         <footer>
            <span>&copy; 2018 - DealsEnRoute</span>
         </footer>
      </div>
       <script type="text/javascript">
           function pdf(){
               $('#is_pdf').val('1');
               $('#user_filter').submit();
               $('#is_pdf').val('0');
           }
   </script>
      <!-- =============== VENDOR SCRIPTS ===============-->
      <!-- MODERNIZR-->
      <script src="{{ asset('vendor/admin/modernizr/modernizr.custom.js') }}"></script>
      <!-- MATCHMEDIA POLYFILL-->
      <script src="{{ asset('vendor/admin/matchMedia/matchMedia.js') }}"></script>
      <!-- JQUERY-->
      <script src="{{ asset('vendor/admin/jquery/dist/jquery.js') }}"></script>
      <!-- BOOTSTRAP-->
      <script src="{{ asset('vendor/admin/bootstrap/dist/js/bootstrap.js') }}"></script>
      <!-- STORAGE API-->
      <script src="{{ asset('vendor/admin/jQuery-Storage-API/jquery.storageapi.js') }}"></script>
      <!-- JQUERY EASING-->
      <script src="{{ asset('vendor/admin/jquery.easing/js/jquery.easing.js') }}"></script>
      <!-- ANIMO-->
      <script src="{{ asset('vendor/admin/animo.js/animo.js') }}"></script>
      <!-- SLIMSCROLL-->
      <script src="{{ asset('vendor/admin/slimScroll/jquery.slimscroll.min.js') }}"></script>
      <!-- SCREENFULL-->
      <script src="{{ asset('vendor/admin/screenfull/dist/screenfull.js') }}"></script>
      <!-- LOCALIZE-->
      <script src="{{ asset('vendor/admin/jquery-localize-i18n/dist/jquery.localize.js') }}"></script>
      <!-- RTL demo-->
      <script src="{{ asset('js/admin/demo/demo-rtl.js') }}"></script>
      <!-- =============== PAGE VENDOR SCRIPTS ===============-->
      <!-- SPARKLINE-->
      <script src="{{ asset('vendor/admin/sparkline/index.js') }}"></script>
      <!-- FLOT CHART-->
      <script src="{{ asset('vendor/admin/flot/jquery.flot.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot/jquery.flot.resize.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot/jquery.flot.pie.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot/jquery.flot.time.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot/jquery.flot.categories.js') }}"></script>
      <script src="{{ asset('vendor/admin/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
      <!-- EASY PIE CHART-->
      <script src="{{ asset('vendor/admin/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
      <!-- MOMENT JS-->
      <script src="{{ asset('vendor/admin/moment/min/moment-with-locales.min.js') }}"></script>
      <!-- DEMO-->
      <script src="{{ asset('js/admin/demo/demo-flot.js') }}"></script>
      <!-- DATATABLES-->
      <script src="{{ asset('vendor/admin/datatables/media/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-colvis/js/dataTables.colVis.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables/media/js/dataTables.bootstrap.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/dataTables.buttons.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.bootstrap.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.colVis.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.flash.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.html5.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.print.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-responsive/js/dataTables.responsive.js') }}"></script>
      <script src="{{ asset('vendor/admin/datatables-responsive/js/responsive.bootstrap.js') }}"></script>
      <!-- =============== APP SCRIPTS ===============-->
      <script src="{{ asset('js/admin/app.js') }}"></script>
      <script src="{{ asset('js/admin/cusom.js') }}"></script>
   </body>
</html>