@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }} / List</h5>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card shadow">
	        <div class="card-header py-3">
	          	{{ Html::link(url($__route . '/create'), 'Add New', ['class' => 'btn btn-primary btn-sm float-right']) }}
	          	<h6 class="font-weight-bold text-primary">Food List</h6>
	        </div>
	        <div class="card-body">
	          <div class="table-responsive" style="padding: 10px;">
	          	<table class="table table-bordered table-striped table-hover" id="table-content" width="100%" cellspacing="0">
	          		<thead>
	          			<tr>
	          				<th>Name</th>
	          				<th>Calory</th>
	          				<th>Portion</th>
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
            { data: 'name', name: 'name'},
            { data: 'calory', name: 'calory'},
            { data: 'portion', name: 'portion'},
            { data: 'action', name: 'action', searchable: false, orderable: false}    
        ],
    });
});
</script>
@endpush
