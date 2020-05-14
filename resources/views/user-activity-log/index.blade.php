@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }} / User List</h5>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card shadow">
	        <div class="card-header py-3">
	        	<h6 class="font-weight-bold text-primary">User List</h6>
	        </div>
	        <div class="card-body">
	          <div class="table-responsive" style="padding: 10px;">
	          	<table class="table table-bordered table-striped table-hover" id="table-content" width="100%" cellspacing="0">
	          		<thead>
	          			<tr>
	          				<th>email</th>
	          				<th>Username</th>
	          				<th>Gender</th>
	          				<th>Date of Birth</th>
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
        ajax: '{!! url($__route . "/user-list") !!}',
        columns: [
            { data: 'email', name: 'email'},
            { 
            	data: 'username', 
            	name: 'username',
            	render: function(row, type, full) {
            		return row + '&nbsp;&nbsp;<span class="badge badge-info">' + full.unique_id + '</span>'
            	}
            },
            { data: 'gender', name: 'gender'},
            { data: 'date_of_birth', name: 'date_of_birth'},
            { data: 'action', name: 'action', searchable: false, orderable: false }    
        ],
    });
});
</script>
@endpush
