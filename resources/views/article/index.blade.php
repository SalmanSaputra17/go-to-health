@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }} / List</h5>
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
						<div class="col-md-3">
							{!! Form::label('status') !!}
							{!! Form::select('filter_status', $status, null, ['class' => 'form-control', 'id' => 'filter-status']) !!}
						</div>
						<div class="col-md-3">
							{!! Form::label('author') !!}
							{!! Form::select('filter_author', $author, null, ['class' => 'form-control', 'id' => 'filter-author']) !!}
						</div>
						<div class="col-md-3">
							{!! Form::label('Start Date') !!}
							{!! Form::date('filter_start_date', null, ['class' => 'form-control', 'id' => 'filter-start-date']) !!}
						</div>
						<div class="col-md-3">
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
	          {{ Html::link(url($__route . '/create'), 'Add New', ['class' => 'btn btn-primary btn-sm float-right']) }}
	          <h6 class="font-weight-bold text-primary">Article List</h6>
	        </div>
	        <div class="card-body">
	          <div class="table-responsive" style="padding: 10px;">
	          	<table class="table table-bordered table-striped table-hover" id="table-content" width="100%" cellspacing="0">
	          		<thead>
	          			<tr>
	          				<th>Title</th>
	          				<th>Status</th>
	          				<th>Author</th>
	          				<th>Created At</th>
	          				<th>Last Updated</th>
	          				<th>Actions</th>
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
        ajax: '{!! url($__route . "/data") !!}',
        columns: [
            { data: 'title', name: 'title', searchable: true, orderable: true },
            { 
            	data: 'status',
            	name: 'status',
            	render: function(row, type, full) {
            		return row == 'draft' ? '<span class="badge badge-warning">' + row + '</span>' : '<span class="badge badge-success">' + row + '</span>'; 
            	},
            	searchable: false,
            	orderable: true
            },
            { data: 'author', name: 'author', searchable: false, orderable: false },
            { data: 'created_at', name: 'created_at', searchable: false, orderable: false },
            { data: 'last_updated', name: 'last_updated', searchable: false, orderable: false },
            { data: 'action', name: 'action', searchable: false, orderable: false }    
        ],
    });

	$("#btn-filter").on('click',function(){
    	table.ajax.url("{{ url($__route.'/data') }}?" + $("#form-filter").serialize()).load();
    });
});
</script>
@endpush

