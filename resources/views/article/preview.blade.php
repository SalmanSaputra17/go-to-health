<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Preview | {{ $result->title }}</title>

    <style>
    	.jumbotron {
    		height: 400px;
    		background: url({{ Storage::url($result->banner) }});
    		background-size: cover;
  			background-repeat: no-repeat;
  			background-position: 50% 50%;
  			box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.5);
    	}

      .jumbotron .title {
        color: #f0f0f0;
        font-size: 4rem;
        text-align: center;
        margin-top: 50px;
      }

    	.meta h5 {
        font-style: italic;
    		border-left: 5px solid black;
    		padding-left: 10px;
    	}
    </style>
  </head>
  <body>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <div class="col-12">
          <h1 class="title">{{ $result->title }}</h1>
        </div>
      </div>
    </div>
	<div class="container">
		<div class="row">
			<div class="col-10 offset-1">
				<div class="meta mb-4">
					<h5>By {{ $result->admin->name }} posted on {{ date('M d, Y', strtotime($result->created_at)) }}</h5>
				</div>
				<div class="content">
					{!! $result->content !!}
				</div>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>