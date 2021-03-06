<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/assetsadmin')  }}/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/assetsadmin')  }}/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/assetsadmin')  }}/css/core.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/assetsadmin')  }}/css/components.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('public/assetsadmin')  }}/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('public/assetsadmin')  }}/js/pages/login.js"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container bg-slate-800">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Advanced login -->
					<form action="" method='post' >
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
								<h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
								<h4 style="color:red" >{{ session()->get('msg') }}</h4>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" placeholder="Username" name="username" >
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								<div style="color:red" >{{ $errors->first('username') }}</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" placeholder="Password" name='password' >
								<div style="color:red" >{{ $errors->first('password') }}</div>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
							<!----
							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" checked="checked">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="javascript:void()" >Forgot password?</a>
									</div>
								</div>
							</div>
							----->
							<div class="form-group">
								<button type="submit" class="btn bg-blue btn-block">Login <i class="icon-circle-right2 position-right"></i></button>
							</div>

							
							
						</div>
					</form>
					<!-- /advanced login -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
