@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }}</h5>
@endsection

@section('content')
<div class="row mb-4">
	<div class="col-xl-4 col-md-4 col-sm-6">
      	<div class="card border-left-primary shadow h-100 py-2">
        	<div class="card-body">
          		<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Foods</div>
		              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalData['foods'] }}</div>
		            </div>
		            <div class="col-auto">
		              <i class="fas fa-utensils fa-2x text-gray-300"></i>
		            </div>
          		</div>
        	</div>
      	</div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-6">
      	<div class="card border-left-success shadow h-100 py-2">
        	<div class="card-body">
          		<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Articles</div>
		              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalData['articles'] }}</div>
		            </div>
		            <div class="col-auto">
		              <i class="fas fa-newspaper fa-2x text-gray-300"></i>
		            </div>
          		</div>
        	</div>
      	</div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-6">
      	<div class="card border-left-info shadow h-100 py-2">
        	<div class="card-body">
          		<div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Active User</div>
		              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalData['users'] }}</div>
		            </div>
		            <div class="col-auto">
		              <i class="fas fa-user-check fa-2x text-gray-300"></i>
		            </div>
          		</div>
        	</div>
      	</div>
    </div>
</div>

<div class="row">
	<div class="col-12">
      	<div class="card shadow">
	        <!-- Card Header - Dropdown -->
	        <div class="card-header">
	          	<div class="font-weight-bold text-primary">User Activity</div>
	        </div>
	        <!-- Card Body -->
	        <div class="card-body">
	    		{!! $lineChart->container() !!}
	        </div>
      	</div>
    </div>
</div>
@endsection

@push('js')
{!! $lineChart->script() !!}
<script>
	let line_chart_url = {{ $lineChart->id }}_api_url;	
</script>
@endpush
