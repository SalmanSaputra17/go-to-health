@extends('layouts.layout')

@section('heading')
<h5 class="text-gray-800">{{ $__title_page }} / {{ ucwords($action) }}</h5>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card shadow">
			<div class="card-header">
				{{ Html::link(url($__route), 'Back', ['class' => 'btn btn-secondary btn-sm float-right']) }}
				<h6 class="font-weight-bold text-primary">Add New Food</h6>
			</div>
			<div class="card-body">
				{!! Form::model($model, ['method' => 'post', 'url' => url($__route . '/' . $action, $action == 'update' ? ['id' => encryptStringValue($model->id)] : []), 'id' => 'form']) !!}
					<div class="form-group">
						{!! Form::label('name') !!}
						{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('calory') !!}
						{!! Form::number('calory', null, ['class' => 'form-control', 'id' => 'calory']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('portion') !!}
						{!! Form::number('portion', null, ['class' => 'form-control', 'id' => 'portion']) !!}
					</div>

					{!! Form::submit($action == 'create' ? 'Save' : 'Update', ['class' => 'btn btn-primary btn-sm btn-block']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
{!! JsValidator::formRequest('App\Http\Requests\FoodRequest', '#form'); !!}
@endpush

