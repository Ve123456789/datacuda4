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
					<!--  Page content -->
					
					@if(Request::segment(2) == 'add' || Request::segment(2) == 'edit')
					<div class="row" > 
						<div class="col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-2">
							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">Advice Form  </h5>
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
											<label class="control-label col-lg-2">First Name <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="fname" value="{{ $fname }}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('fname') }}</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2">Last Name <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-8">
											<input type="text" class="form-control" name="lname" value="{{$lname}}" >
											
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('lname') }}</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">Email <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-8">
												<input type="email" class="form-control" name="email" value="{{$email}}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('email') }}</div>
										</div>
										<?php /*?>
										<div class="form-group">
											<label class="control-label col-lg-2">Adviser Logo</label>
											<div class="col-lg-8">
												<input type="file" class="file-styled" name="logo"  >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('logo') }}</div>
										@if(isset($logo))
											<br/><br/><br/>
											<div style="text-align:center;" >
												<img src="{{url('/public/upload').'/'.$logo}}" width="100" >
											</div>
										@endif
										</div><?php */ ?>

										<div class="form-group">
											<label class="control-label col-lg-2">Password</label>
											<div class="col-lg-8">
												<input type="password" class="form-control" name="password" value="{{$password}}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('password') }}</div>
										</div>

										<div class="form-group">
											<label class="control-label col-lg-2">Phone No</label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="phone" value="{{$phone}}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('phone') }}</div>
										</div>																									
											

										
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="save" value="submit" >Submit <i class="icon-arrow-right14 position-right"></i></button>
										</div>
										
									</div>
								</div>
							</form>
						</div>
					</div>
					@else
					
									
					
				<!---- Data Table start ----->	
				
					<div class="panel panel-flat">
						

						<div class="panel-body">
							<form class="form-horizontal" action="" method="post" >
							{{ csrf_field() }}
								<fieldset class="content-group">
									
									<div class="col-lg-3 col-md-3">
										<input type="text" class="form-control" name="fname" value="@if(old('fname') != ''){{old('fname')}}@elseif($fname){{ $fname }}@endif" >
									</div>
									<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('fname') }}</div>
									<div class="col-lg-3 col-md-3 text-right">
										<button type="submit" class="btn btn-primary" name="serach" value="serach" >serach <i class="icon-arrow-right14 position-right"></i></button>
									</div>

								</fieldset>
							</form>
						</div>
					</div>
				
				
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">{{ $heading }} table </h5>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Status</th>
										<th>Admin Varfy Status</th>
										<th>Other Detail</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
								@foreach($listdatas as $list)
									<tr>
										<td>{{ $list->{config('constants.db.user').'_fname' } }} </td>
										<td>{{ $list->{config('constants.db.user').'_lname' } }}</td>
										<td>{{ $list->{config('constants.db.user').'_email' } }}</td>
										<td>{{ $list->{config('constants.db.user').'_phone' } }}</td>
										
										<td>
										@if($list->{config('constants.db.user').'_status' } == '1' ) 
										<a href="{{ url('/adviser/status/0/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/adviser/status/1/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

										<td>
										@if($list->{config('constants.db.user').'_adminstatus' } == '1' ) 
										<a href="{{ url('/adviser/adminstatus/0/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/adviser/adminstatus/1/'.$list->{config('constants.db.user').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

										<td class="text-center">
											<a href="{{ url('/academic/'.$list->{config('constants.db.user').'_id' }) }}" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded">Academic</a>
											<br /><br />
											<a href="{{ url('/basicinfo/'.$list->{config('constants.db.user').'_id' }) }}" type="button" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded">Basicinfo</a>
											
											
										</td>


										<td class="text-center">
											
											<a href="{{ url('/adviser/view/'.$list->{config('constants.db.user').'_id' }) }}" class="btn border-warning text-warning-600 btn-flat btn-icon"  ><i class="icon-book"></i></a>

											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('/adviser/edit/'.$list->{config('constants.db.user').'_id' }) }}" type="button" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class=" icon-pencil5"></i></a>

											
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('/adviser/delete/'.$list->{config('constants.db.user').'_id' }) }}" class="btn border-warning text-warning-600 btn-flat btn-icon" onclick="return confirm('Are You Soure Want to delete this ?')" ><i class=" icon-cancel-square2"></i></a>
										</td>
									</tr>
								@endforeach									
								</tbody>

							</table>
						</div>			
						<div style="text-align:center;margin:20px;" >
							{!! $listdatas->render() !!}
						</div>
					</div>
					
						
					<!-- /basic responsive table -->
					@endif
					
					
					
					
					
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
