<div id="dashboard" class="tab-pane fade in active">
    <div class="container-fluid">
        <div class="row">
          <?php  //print_R($total_age_wise_redeem['redeem_by_18_below_male']); exit;?>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="card card-dash1">
                            <div class="header head-coupons">
                                <h5>Coupon Redemption</h5>
                            </div>
                            <div class="card-content">
                                <div class="row coupons-redeem-flex">
                                    <div class="col-sm-6 coupons-redeem-left">
                                        <div class="logo-redeem">
                                            <img src="{{ $vendor_detail->vendor_logo}}"  alt="" class="img-circle" >
                                        </div>
                                        <h4>{{ $vendor_detail->vendor_name}}</h4>
                                        <p class="grey-redeem">{{ $vendor_detail->vendor_address}}</p>
                                    </div>
                                    <div class="col-sm-6 coupons-redeem-right">
                                        <h4>Redemption Code</h4>
                                         {{ Form::open([ 'id' => 'redeemcoupon']) }}
                                                        {{ csrf_field() }}
                                        <div class="form-group coupon-code-val">
                                             {{ Form::text('coupon','',['id'=>'coupon_reddem']) }}
                                        </div>
                                        <a href="" class="btn btn-info btn-fill btn-wd btn-create redeemnow">Redeem Now</a>
                                          {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 ">
                        <div class="card card-dash0 row-md-5">
                            <div class="header head-coupons">
                                <div class="pull-left">
                                    <h5>Coupons</h5>
                                </div>
                                <div class="chart-legend1 pull-right">
                                    <span><i class="fa fa-circle"></i> Redeemed</span>
                                    <span><i class="fa fa-circle"></i> Created</span>
                                    <span><i class="fa fa-circle"></i> Active</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="chartCoupons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="card card-dash0">
                            <div class="header head-coupons">
                                <h5 class="text-capitalize">Remaining Deals in Package</h5> 
                            </div>
                            <div class="card-content" align="center">
                                <div id="dealtotal" class="chart-circle" data-percent="0"> <span>0%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="card card-dash0">
                            <div class="header head-coupons">
                                <h5>Total Coupons Redemption Rate</h5>
                            </div>
                            <div class="card-content" align="center">
                                <div id="charttotal" class="chart-circle" data-percent="0"> <span>0%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="card card-dash0">
                            <div class="header head-coupons">
                                <h5>Additional Geofencing</h5>
                            </div>
                            <div class="card-content" align="center">
                                <div id="geofencingtotal" class="chart-circle" data-percent="0"> <span>0%</span></div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="card card-dash0">
                            <div class="header head-coupons">
                                <h5>Additional Geolocation</h5>
                            </div>
                            <div class="card-content" align="center">
                                <div id="geolocationtotal" class="chart-circle" data-percent="0"> <span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                             
            <div class="row row-coupons @if ($subscription['stripe_plan']=='bronze' && $is_free_trial['is_trial']==0 ) show-silver @endif">   
            @if ($subscription['stripe_plan']=='bronze' && $is_free_trial['is_trial']==0)   <div class="show-plan-text-bronze">  To unlock Gender & Age wise analytics please <a href="{{URL::route('changesubscription')}}">UPGRADE NOW </a>. </div>  @endif

            <div class="age-coupons  @if ($subscription['stripe_plan']=='silver' && $is_free_trial['is_trial']==0) show-silver @endif" > 
            @if ($subscription['stripe_plan']=='silver' && $is_free_trial['is_trial']==0)  <div class="show-plan-text-silver"> To unlock Gender wise analytics please <a href="{{URL::route('changesubscription')}}">UPGRADE NOW </a> .  </div> @endif
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">&lt;18</span>
                        </h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption1">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartunder18" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                            <div class="col-xs-12 horizontal-bar-chart">
                                <div class="h-label">
                                    male <span>{{ $total_age_wise_redeem['redeem_by_18_below_male'] }}%</span>
                                </div>
                                <div class="progress no-margin">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$total_age_wise_redeem['redeem_by_18_below_male']}}%"></div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{$total_age_wise_redeem['redeem_by_18_below_female']}}%"></div>
                                </div>
                                <div class="h-label">
                                    Female <span>{{ $total_age_wise_redeem['redeem_by_18_below_female'] }}%</span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">18-34</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption2">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chart18-34" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                            <div class="col-xs-12 horizontal-bar-chart">
                                <div class="h-label">
                                    male <span>{{ $total_age_wise_redeem['redeem_by_18_34_per_male'] }}%</span>
                                </div>
                                <div class="progress no-margin">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{$total_age_wise_redeem['redeem_by_18_34_per_male']}}%"></div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $total_age_wise_redeem['redeem_by_18_34_per_female'] }}%"></div>
                                </div>
                                <div class="h-label">
                                    Female <span>{{ $total_age_wise_redeem['redeem_by_18_34_per_female'] }}%</span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">35-50</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption3">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chart35-50" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                             <div class="col-xs-12 horizontal-bar-chart">
                                <div class="h-label">
                                    male <span>{{ $total_age_wise_redeem['redeem_by_35_50_male'] }}%</span>
                                </div>
                                <div class="progress no-margin">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{$total_age_wise_redeem['redeem_by_35_50_male']}}%"></div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $total_age_wise_redeem['redeem_by_35_50_female'] }}%"></div>
                                </div>
                                <div class="h-label">
                                    Female <span>{{ $total_age_wise_redeem['redeem_by_35_50_female'] }}%</span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">50&gt;</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption4">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartabove50" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                         <div class="col-xs-12 horizontal-bar-chart">
                              <div class="h-label">
                                    male <span>{{$total_age_wise_redeem['redeem_by_above_50_male']}}%</span>
                                </div>
                                <div class="progress no-margin">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{$total_age_wise_redeem['redeem_by_above_50_male']}}%"></div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{$total_age_wise_redeem['redeem_by_above_50_female']}}%"></div>
                                </div>
                                <div class="h-label">
                                    Female <span>{{$total_age_wise_redeem['redeem_by_above_50_female']}}%</span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-lg-6 col-sm-6">
               
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for male:
                            <span class="age-right"></span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption5">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartmale" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for female:
                            <span class="age-right">;</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption6">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartfemale" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Coupons Redeemed</h5>
                    </div>
                    <div class="card-content">
                        <div id="my-tab-content" class="tab-content">
                            <div class="tab-pane active" id="monthly">
                                <form class="form-inline pad-b pull-right mon-form">
                                    <div class="form-group">
                                        <label for="charty">Year:</label>
                                        {{ Form::select('select_year',$year,'',['id'=>'charty','class'=>'form-control'])}}

                                    </div>
                                </form>
                                <div id="chartMonthly"></div>
                            </div>
                            <div class="tab-pane" id="weekly">
                                <form class="form-inline pad-b pull-right mon-form">
                                    <div class="form-group">
                                        <label for="charty1">Year:</label>
                                        {{ Form::select('select_year',$year,'',['id'=>'charty1','class'=>'form-control'])}}

                                    </div>
                                    <div class="form-group">
                                        <label for="chartm1">Month:</label>
                                        {{ Form::selectMonth('month','',['id'=>'chartm1','class'=>'form-control']) }}

                                    </div>
                                </form>
                                <div id="chartWeekly"></div>
                            </div>
                        </div>
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs user-tabs" data-tabs="tabs">
                                    <li class="active"><a href="#monthly" data-toggle="tab">Monthly</a></li>
                                    <li id="weeklyChart"><a href="#weekly" data-toggle="tab">Weekly</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>