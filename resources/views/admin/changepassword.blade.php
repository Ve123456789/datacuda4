@include('lib.header')
<body>

	<!-- Main navbar -->
	@include('lib.nav')
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			@include('lib.sidebar')
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">
			
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h5><a href="{{ url('/adviser') }}" ><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$heading}}</span></a></h5>
						<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="javascript:void(0)" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span></span></a>
								
							</div>
						</div>
					</div>

					<div class="breadcrumb-line breadcrumb-line-component"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
						<ul class="breadcrumb">
							<li><a href="{{ url('/dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="{{ url('/adviser') }}">{{$heading}}</a></li>
							
						</ul>
					</div>
				</div>
			
			
			
			

				<!-- Content area -->
				<div class="content">
					<!--  Page content -->
					
					
					<div class="row" > 

						<h3 style="text-align: center;color: red;"> {{ Session('errmsg') }}</h3>
						<h3 style="text-align: center;color: green;"> {{ Session('msg') }}</h3>

						<div class="col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-2">
							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">Change Password</h5>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										{{ csrf_field() }}
												
										<div class="form-group">
											<label class="control-label col-lg-2">Old Password <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-6">
												<input type="password" class="form-control" name="oldpassword" value="" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('oldpassword') }}</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2">New Password <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-6">
											<input type="password" class="form-control" name="newpassword" value="" >
											
										</div>

										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('newpassword') }}</div>
										</div>

										<div class="form-group">
											<label class="control-label col-lg-2">Confirm Password<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-6">
												<input type="password" class="form-control" name="confirmpassword" value="" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('confirmpassword') }}</div>
										</div>
																	
											

										
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="save" value="submit" >Submit <i class="icon-arrow-right14 position-right"></i></button>
										</div>
										
									</div>
								</div>
							</form>
						</div>
					</div>
					
					
					
					
					
					<!-- /// Page content -->
					

				@include('lib.footer')
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
