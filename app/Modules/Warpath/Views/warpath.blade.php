@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/segmented-js/segment.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/fullcalendar/fullcalendar.min.css')}}">
<style type="text/css">
 .avatar {
    width: 85px;
    height: 85px;
    object-fit: cover;

    vertical-align: top;
}

 .no-image {
    width: 85px;
    height: 85px;
    line-height: 85px;
    vertical-align: top;
}


.chart.easy-pie-chart-1 .no-image {
    margin-top: -2px;
    position: absolute;
    right: 2px;
    top: 55%;
    width: 85px;
    height: 85px;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    margin: 0 auto;
}


.chart.easy-pie-chart-1>span>img {
    width: 85px;
    height: 85px;
    line-height: 85px;
    right: 2px;
    top: 55%;
    left: auto;
}

.rounded-circle {
    border-radius: 50%!important;
}

.no-image span{
    font-size: 25px;
}

.card .counter{
    position: absolute;
    right: -10px;
    top: -10px;
    color: white;
    border-radius: 100%;
    width: 25px;
    height: 25px;
    display: inline-block;
    border:none;
     font-size: 11px;
   margin: 0;
   padding:0;
   text-align:center;
   line-height:23px;
}

.rounded-circle .avatar{
    border: 1px solid #ddd;
}

.dep{
    margin-bottom: 20px;
}

.tag{
    border:none;color:white;margin-top: -20px;
}

.progress-bar {
    background-color: #dc3545;
}

.progress.progress-xs {
    height: 8px;
    border-radius: 10px;
}

.no-image-number span{
    font-size: 16px;
}


</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="DailyplanController"> 
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a>{{$parent->name}}</h2>
                
            </div>            
            <div class="col-lg-8 col-md-8 col-sm-12 hidden-sm">
                <div class="float-right">
                    <ul class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>     
                        @foreach($breadcrumbs as $key=>$breadcrumb)                 
                        <li class="breadcrumb-item active">
                            <a href="{{url('warpath/index')}}/{{$breadcrumb['id']}}">{{$breadcrumb['name']}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
            <a href="{{url('warpath/index')}}/{{$parent->id}}">
                <div class="card parent">
                    <div class="body text-center">
                        <div class="text-center">
                            @if($parent->hod)
                                @if($parent->hod->employee->image) 
                                    <img image="{{asset('storage')}}{{$parent->hod->employee->image}}" 
                                        image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$parent->name}}" style="border:1px solid #ddd">
                                @else
                                    <img image="{{asset('storage')}}{{$parent->hod->employee->image}}" 
                                        image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$parent->name}}" style="border:1px solid #ddd">
                                @endif
                                <br>
                                <span class="badge bg-success align-middle ng-binding tag">{{$parent->hod->employee->first_name}}
                                </span>
                            @else
                                <img image="{{asset('storage')}}" 
                                        image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$parent->name}}" style="border:1px solid #ddd"><br>
                                <span class="badge bg-success align-middle ng-binding tag">No HOD</span>
                            @endif
                        </div>
                        <h6 class="m-0" style="font-size: 14px;">{{$parent->name}}</h6>
                    </div>
                    <hr class="m-0">
                    <div style="padding-left: 10px;padding-top:10px;">
                        <a href="" class="float-right" style="padding-right:10px"><i class="fas fa-arrow-right"></i></a>
                        <p  class="float-left">Go To WarBoard</p>
                    </div>
                </div>
            </a>   



            <div class="card">
                <div class="header">
                    <h2>KPI</h2>
                </div>
                <div class="body">
                    <ul class=" list-unstyled basic-list">
                        @if(count($kpis)>0)
                            @foreach($kpis as $kpi)
                            <li data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    data-original-title="
                                        Value - {{$kpi->value}} <br>
                                        Target - {{$kpi->target}} ">
                               <strong>{{$kpi->kpi}} ({{($kpi->value > 0)? floor(($kpi->value/$kpi->target)*100):0 }}%)</strong>
                               <div class="progress progress-xs">
                                    <div class="progress-bar" role="progressbar" style="width: {{($kpi->value > 0)? floor(($kpi->value/$kpi->target)*100):0 }}%;"> 
                                        <span class="sr-only">
                                            {{($kpi->value > 0)? floor(($kpi->value/$kpi->target)*100):0 }}% Complete
                                        </span> 
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @else
                            <li class="text-center">
                                <h5>No KPI</h5>
                                <p>No KPI Lines Attached</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">

            @if(count($childs)>0) 
            <div class="row">
                @foreach($childs as $child)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <a href="{{url('warpath/index')}}/{{$child->id}}">
                        <div class="card child">
                            <div class="body text-center">
                                <div class="text-center">
                                    @if($child->hod)
                                        @if($child->hod->employee->image) 
                                            <img image="{{asset('storage')}}{{$child->hod->employee->image}}" 
                                                image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$child->name}}" style="border:1px solid #ddd">
                                        @else
                                            <img image="{{asset('storage')}}{{$child->hod->employee->image}}" 
                                                image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$child->name}}" style="border:1px solid #ddd">
                                        @endif
                                        <br>
                                        <span class="badge bg-success align-middle ng-binding tag">{{$child->hod->employee->first_name}}
                                        </span>
                                    @else
                                         <img image="" 
                                        image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " data-title="{{$child->name}}" style="border:1px solid #ddd"><br>
                                        <span class="badge bg-success align-middle ng-binding tag">No HOD</span>
                                    @endif
                                </div>
                                <h6 class="m-0" style="font-size: 14px;">{{$child->name}}</h6>
                            </div>
                            <hr class="m-0">
                            <div style="padding-left: 10px;padding-top:10px;">
                                <a href="{{url('issue/boards/warboard/')}}/{{$child->id}}?tag=0" class="float-right" style="padding-right:10px"><i class="fas fa-arrow-right"></i></a>
                                <p  class="float-left">Go To WarBoard</p>
                            </div>
                        </div>
                    </a>   
                </div>
                @endforeach
            </div>
            @endif

              
            <h5>
                <a href="javascript:void(0);" class="btn btn-xs btn-link p-0" >
                    <i class="fa fa-arrow-left" style="color:black" ng-click="loadUnder(up)" ng-show="childs.length==0"></i></a> 
                SVA ({{count($sva)}})</h5>
            <hr>

            @if(count($sva)>0)    
            <div class="row">
                @foreach($sva as $emp)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <a href="{{url('/profile/index')}}/{{$emp->user->id}}">
                        <div class="card">
                            <div class="body text-center">
                                <div class="chart easy-pie-chart-1" data-percent="{{$emp->user->total_bip>0?($emp->user->total_done_bip/$emp->user->total_bip)*100:0}}"> <span>
                                   <img image="{{asset('storage')}}{{$emp->image}}" image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}" alt="user" data-title="{{$emp->first_name}} {{$emp->last_name}}" class="rounded-circle">
                                </div>
                                <h5 class="m-0" style="font-size: 14px;">{{$emp->first_name}} {{$emp->last_name}}</h5>
                                <small>BIP - {{$emp->user->total_bip}} /  {{$emp->user->total_done_bip}}</small>

                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            
            <form action="" method="get" role="form">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <h5 style="margin-top: 10px">DVA ({{count($dva)}})</h5>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        @if($request->sort=='asc')
                            <input type="hidden" name="sort" id="inputSort" class="form-control" value="desc">
                        @else
                            <input type="hidden" name="sort" id="inputSort" class="form-control" value="asc">
                        @endif
                        
                        <button type="submit" class="btn btn-default">
                            @if($request->sort=='asc')
                                <i class="fas fa-sort-amount-up"></i>
                            @else
                                <i class="fas fa-sort-amount-down"></i>
                            @endif
                        </button>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="ui-segment filters" >
                          <input type="radio" hidden name="dva_rate"  id="utilization" value="utilization"  checked="" @if($request->dva_rate=='utilization') selected @endif />
                          <label for="utilization" style="min-width: 50%;">
                            Utilization 
                          </label>
                          <input type="radio" hidden name="dva_rate" value="cpu"  id="cpu" @if($request->dva_rate=='cpu') checked @endif/>
                          <label for="cpu" style="min-width: 50%;" >
                             CPU 
                          </label>
                        </div>
                    </div>   
                 </div> 
            </form> 
            <hr>
            
            @if(count($dva)>0)    
            <div class="row">
                @foreach($dva as $emp)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <a href="{{url('/profile/index')}}/{{$emp->id}}">
                        <div class="card">
                            <div class="body text-center">
                                <div class="chart easy-pie-chart-1" data-percent="{{$emp->utilization}}"> <span>
                                   <img image="{{asset('storage')}}/{{$emp->image}}" image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}" alt="user" data-title="{{$emp->first_name}} {{$emp->last_name}}" 
                                   data-number="{{$emp->utilization}}%" class="rounded-circle">
                                   <!-- <span class="uti-precentage">25%</span> -->
                                </div>
                                <h5 class="m-0" style="font-size: 14px;">{{$emp->first_name}} {{$emp->last_name}}</h5>
                                <small>CPU - 150.5 </small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

        </div>

    </div> 





</div>

@stop


@section('js')

<script src="{{asset('assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script src="{{asset('assets/dist/easy-pie/dist/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/fullcalendar/fullcalendar.js')}}"></script>


<script type="text/javascript">

$(document).ready(function(){

    $('.chart').easyPieChart({
         barColor:'#2C3E50',
    });

    $('input[type=radio]').on('change', function() {
        $(this).closest("form").submit();
    });
        
});


var app = angular.module("ngApp",['angularImgFallback']);
//controller


app.controller("DailyplanController", function($scope,$http){
 
    

        
        
});




</script>
@stop
