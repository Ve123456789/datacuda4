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
							<li><a href="{{ url('/adviser/add') }}" class="btn btn-primary btn-icon btn-rounded"><i class=" icon-plus3"></i></a></li>
						</ul>
					</div>
				</div>
			
			
			
			

				<!-- Content area -->
				<div class="content">						
					
				<!---- Data Table start ----->				
				
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">{{ $heading }} table </h5>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>First Name</th>
										<td>{{ $list->{config('constants.db.user').'_fname' } }} </td>
									</tr>
									<tr>
										<th>Last Name</th>
										<td>{{ $list->{config('constants.db.user').'_lname' } }}</td>
									</tr>	
									<tr>
										<th>Email</th>
										<td>{{ $list->{config('constants.db.user').'_email' } }}</td>
									</tr>
									<tr>
										<th>Phone</th>
										<td>{{ $list->{config('constants.db.user').'_phone' } }}</td>
									</tr>

									<tr>
										<th>Username</th>
										<td>{{ $list->{config('constants.db.user').'_username' } }}</td>
									</tr>

									<tr>
										<th>Location</th>
										<td>{{ $list->{config('constants.db.user').'_location' } }}</td>
									</tr>

									<tr>
										<th>College</th>
										<td>{{ $list->{config('constants.db.college').'_name' } }}</td>
									</tr>

									<tr>
										<th>Topic</th>
										<td>{{ $list->{config('constants.db.topic').'_name' } }}</td>
									</tr>

									<tr>
										<th>Sort Bio</th>
										<td>{{ $list->{config('constants.db.user_detail').'_sort_bio' } }}</td>
									</tr>

									<tr>
										<th>Document</th>
										<td>
											@if($list->{config('constants.db.user_detail').'_doc' })
											<a href="{{ url('public/upload/'.$list->{config('constants.db.user_detail').'_doc' }) }}"  >Download</a>
											@endif
										</td>
									</tr>


									<tr>
										<th>Billing Address </th>
										<td>{{ $list->{config('constants.db.payment').'_address' } }}</td>
									</tr>
									<tr>
										<th>City </th>
										<td>{{ $list->{config('constants.db.payment').'_city' } }}</td>
									</tr>

									<tr>
										<th>State </th>
										<td>{{ $list->{config('constants.db.payment').'_state' } }}</td>
									</tr>

									<tr>
										<th>ZipCode </th>
										<td>{{ $list->{config('constants.db.payment').'_zipcode' } }}</td>
									</tr>


									<tr>
										<th>Status</th>
										<td>
										@if($list->{config('constants.db.user').'_status' } == '1' ) 
										<a href="{{ url('/adviser/status/0/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/adviser/status/1/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>
									</tr>
									<tr>
										<th>Admin Varfy Status</th>
										<td>
										@if($list->{config('constants.db.user').'_adminstatus' } == '1' ) 
										<a href="{{ url('/adviser/adminstatus/0/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/adviser/adminstatus/1/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

									</tr>

								</thead>
								
								

							</table>
						</div>			
						<div style="text-align:center;margin:20px;" >
							<a href="{{ url('/adviser') }}" class="btn border-success ">Back</a>
						</div>
					</div>
					
						
					<!-- /basic responsive table -->
			
					
					
					
					
					
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
