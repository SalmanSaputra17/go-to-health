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
				<h6 class="font-weight-bold text-primary">Add New Article</h6>
			</div>
			<div class="card-body">
				{!! Form::model($model, ['method' => 'post', 'url' => url($__route . '/' . $action, $action == 'update' ? ['id' => encryptStringValue($model->id)] : []), 'files' => true, 'id' => 'form']) !!}
					<div class="form-group">
						{!! Form::label('title') !!}
						{!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('banner') !!}
						<div class="custom-file">
							{!! Form::file('banner', ['class' => 'custom-file-input', 'id' => 'banner']) !!}
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>

						@if(!empty($model->banner))
	                    	{!! Html::image(\Storage::url($model->banner), null, ['style' => 'width: 150px; height: 100px; margin-top: 10px;']) !!}
	                    @endif
					</div>
					<div class="form-group">
						{!! Form::label('content') !!}
						{!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content', 'rows' => 30]) !!}
					</div>

					{!! Form::submit($action == 'create' ? 'Save' : 'Update', ['class' => 'btn btn-primary btn-sm btn-block']) !!}
				{!! Form::close() !!}				
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
{!! JsValidator::formRequest('App\Http\Requests\ArticleRequest', '#form'); !!}
<script>
	tinymce.init({selector:'textarea'});
</script>
@endpush