@extends('frontend.layouts.couponedit')
@section('title', 'Deals en Route|Index')
@section('content')


<div class="content">

    <div class="tab-content">
        <div id="update" class="tab-pane active in">
            <div class="content content-create">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="content">
                                    <div class="wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul class="nav nav-tabs nav-tabs-step" role="tablist">
                                                <li role="presentation" class="active"> <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"> <span class="round-tab"> 1 </span> </a> </li>
                                                <li role="presentation" class="disabled"> <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"> <span class="round-tab"> 2 </span> </a> </li>
                                                <li role="presentation" class="disabled"> <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"> <span class="round-tab"> 3 </span> </a> </li>
                                            </ul>
                                        </div>

                                           {{ Form::model($coupon, [
                                                                'id' => 'update-coupon',
                                                                'method' => 'POST',
                                                                'files'=> true
                                                            ]) }}
                                        
                                            {{ csrf_field() }}
                                            @include("frontend/coupon/_form",['vendor_detail'=>$vendor_detail,
                                            'start_date_converted'=>$start_date_converted,'end_date_converted'=>$end_date_converted,
                                            'total_geofencing'=>$total_geofencing,'total_additional_cost'=>$total_additional_cost])

                                            {{ Form::close() }}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div




            </div>
        </div>

    </div>

</div>

@endsection