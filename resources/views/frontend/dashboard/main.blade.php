@extends('frontend.layouts.dashboard')
@section('title', 'Deals en Route|Index')
@section('content')



<div class="main-panel">
      	
    <nav class="navbar navbar-default">
            <div class="container-fluid">
                    <div class="navbar-header">
                            <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar bar1"></span> <span class="icon-bar bar2"></span> <span class="icon-bar bar3"></span> </button>
                            <p class="navbar-brand">Hello, {{ Auth::user()->vendorDetail->vendor_name }} </p>
                    </div>
                    <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon fa fa-user"></i>
                             <p>User</p>
                           <b class="caret"></b> </a>
                                            <ul class="dropdown-menu">
                                                    <li><a href="{{ route('vendor.logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form></li>
                                            </ul>
                                    </li>
                            </ul>
                    </div>
            </div>
    </nav>
     
    <div class="content">
          
            <div class="tab-content">
                    @include('frontend/dashboard/dash')
                    @include("frontend/coupon/couponlist",['coupon_lists'=>$coupon_lists])
                   @include("frontend/coupon/create")
                  
                    <div id="settings" class="tab-pane fade in">
                            <div class="container-fluid">
                                    <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card">
                                                            <div class="header">
                                                                    <h5 class="title">Company Details</h5>
                                                            </div>
                                                            <div class="content">
                                                                    <div class="row">
                                                                            <div class="col-md-12">
                                                                                    <form>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="Business Name">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="Street Address">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="City/State">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="Zip">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="tel" placeholder="Phone (x-xxx-xxx-xxxx)" pattern="^\d{1}-\d{3}-\d{3}-\d{4}$" maxlength="11" required>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="email" placeholder="Email" required>
                                                                                            </div>
                                                                                            <fieldset>
                                                                                                    <input type="file" name="file" id="file" accept="image/*" />
                                                                                            </fieldset>
                                                                                            <ul class="list-inline pad-top1 pull-right">
                                                                                                    <li>
                                                                                                            <button type="submit" class="btn btn-create">Submit</button>
                                                                                                    </li>
                                                                                            </ul>
                                                                                    </form>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card">
                                                            <div class="header">
                                                                    <h5 class="title">Edit Credit/Debit Card Info</h5>
                                                            </div>
                                                            <div class="content">
                                                                    <div class="row">
                                                                            <div class="col-md-12">
                                                                                    <form>
                                                                                            <div class="form-group">
                                                                                                    <div class="input-group"> <span class="input-group-addon"> <span class="type"></span> </span>
                                                                                                            <input class="cardNumber type" placeholder="Card Number" required/>
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="Card Holder Name">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <!-- <input type="text" placeholder="Expiration Date MM/YY" required> -->
                                                                                                    <input class="expiry" placeholder="MM/YY" required />
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <!-- <input type="number" placeholder="CVV" required> -->
                                                                                                    <input class="cvv" maxlength="4" placeholder="CVV" required />
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="Home">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="text" placeholder="City">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <select class="form-control">
          <option>Country</option>
          <option value="United States">United States</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="India">India</option>
          <option value="Australia">Australia</option>
          <option value="Russia">Russia</option>
          <option value="New Zealand">New Zealand</option>
        </select>
                                                                                            </div>
                                                                                            <ul class="list-inline pad-top pull-right">
                                                                                                    <li>
                                                                                                            <button type="submit" class="btn btn-create">Submit</button>
                                                                                                    </li>
                                                                                            </ul>
                                                                                    </form>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card">
                                                            <div class="header">
                                                                    <h5 class="title">Change Password</h5>
                                                            </div>
                                                            <div class="content">
                                                                    <div class="row">
                                                                            <div class="col-md-12">
                                                                                    <form>
                                                                                            <div class="form-group">
                                                                                                    <input type="password" placeholder="Current Password">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="password" placeholder="New Password">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <input type="password" placeholder="Re-Enter Password">
                                                                                            </div>
                                                                                            <ul class="list-inline pad-top pull-right">
                                                                                                    <li>
                                                                                                            <button type="submit" class="btn btn-create">Submit</button>
                                                                                                    </li>
                                                                                            </ul>
                                                                                    </form>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <div id="contact" class="tab-pane fade in">
                            <div class="container-fluid">
                                    <div class="row">
                                            <div class="col-md-12">
                                                    <div class="card">
                                                            <div class="content">
                                                                    <div class="row">
                                                                            <div class="col-md-7">
                                                                                    <h5 class="title">Send us a Message</h5>
                                                                                    <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                    <form>
                                                                                                            <div class="form-group">
                                                                                                                    <label for="usr">Name:</label>
                                                                                                                    <input type="text" class="form-control" id="usr">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                    <label for="email">Email:</label>
                                                                                                                    <input type="email" class="form-control" id="email">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                    <label for="qry">Query:</label>
                                                                                                                    <textarea class="form-control" id="qry" style="height:200px !important;"></textarea>
                                                                                                            </div>
                                                                                                            <ul class="list-inline pad-top">
                                                                                                                    <li>
                                                                                                                            <button type="submit" class="btn btn-create">Submit</button>
                                                                                                                    </li>
                                                                                                            </ul>
                                                                                                    </form>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                    <h5 class="title">Contact Information</h5>
                                                                                    <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                    <ul class="table-contact">
                                                                                                            <li>
                                                                                                                    <!-- <i class="fa fa-map-marker"></i> -->
                                                                                                                    <span>35 Street Bellasis, Albani, NY, USA</span>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                                    <!-- <i class="fa fa-envelope"></i> -->
                                                                                                                    <span><a href="mailto:abc@xyz.com" style="color: #252422;">abc@xyz.com</a></span>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                                    <!-- <i class="fa fa-mobile"></i> -->
                                                                                                                    <span>+1 231 564 879</span>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                                    <div class="social-cont">
                                                                                                                            <div> <a target="_blank" href="#s"><i class="fa fa-facebook"></i> </a> </div>
                                                                                                                            <div> <a target="_blank" href="#"><i class="fa fa-linkedin"></i> </a> </div>
                                                                                                                            <div> <a target="_blank" href="#s"><i class="fa fa-twitter"></i> </a> </div>
                                                                                                                            <div> <a target="_blank" href="#"><i class="fa fa-instagram"></i> </a> </div>
                                                                                                                    </div>
                                                                                                            </li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </div>
    </div>
        @include('frontend/footer/footer_dash')
</div>

@endsection
@section('scripts')


<script type="text/javascript" src="{{ asset('frontend/js/webjs/dashboard.js') }}"></script>

<script type="text/javascript" src="{{ asset('frontend/js/webjs/couponlist.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=drawing&callback=Maps"
         async defer></script>

@endsection