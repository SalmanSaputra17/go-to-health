@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }} / User Log</h5>
@endsection

@section('content')
<div class="row mb-3">
	<div class="col-md-12">
		<div class="card shadow">
			<div class="card-header py-3">
				<h6 class="font-weight-bold text-primary">Filter</h6>
			</div>
			<div class="card-body">
				{!! Form::open(['id' => 'form-filter']) !!}
					<div class="row mb-2">
						<div class="col-md-6">
							{!! Form::label('Start Date') !!}
							{!! Form::date('filter_start_date', null, ['class' => 'form-control', 'id' => 'filter-start-date']) !!}
						</div>
						<div class="col-md-6">
							{!! Form::label('End Date') !!}
							{!! Form::date('filter_end_date', null, ['class' => 'form-control', 'id' => 'filter-end-date']) !!}
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							{!! Form::button('Submit', ['class' => 'btn btn-primary btn-sm float-right', 'id' => 'btn-filter']) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card shadow">
	        <div class="card-header py-3">
				{{ Html::link(url($__route), 'Back', ['class' => 'btn btn-secondary btn-sm float-right']) }}
	          	<h6 class="font-weight-bold text-primary">User Log</h6>
	        </div>
	        <div class="card-body">
	          <div class="table-responsive" style="padding: 10px;">
	          	<table class="table table-bordered table-striped table-hover" id="table-content" width="100%" cellspacing="0">
	          		<thead>
	          			<tr>
	          				<th>Time</th>
	          				<th>Activity</th>
	          				<th>IP</th>
	          			</tr>
	          		</thead>
	          		<tbody></tbody>
	          	</table>
	          </div>
	        </div>
	    </div>
	</div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
	var table = $('#table-content').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! url($__route . '/user-log/' . encryptStringValue($user->id)) !!}",
        columns: [
            { data: 'time', name: 'time', searchable: false, orderable: false },
            { 
            	data: 'activity',
            	name: 'activity',
            	render: function(row, type, full) {
            		return row + '&nbsp;&nbsp; <span class="badge badge-dark">' + full.type + '</span>';
            	},
            	searchable: true, 
            	orderable: true
            },
            { data: 'ip', name: 'ip', searchable: true, orderable: true },   
        ],
    });

    $("#btn-filter").on('click',function(){
    	table.ajax.url("{{ url($__route . '/user-log/' . $user->id) }}?" + $("#form-filter").serialize()).load();
    });
});
</script>
@endpush
