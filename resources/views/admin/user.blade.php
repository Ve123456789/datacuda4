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
							<h5><a href="{{ url('/admin/user') }}" ><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$heading}}</span></a></h5>
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
							<li><a href="{{ url('/admin/user') }}">{{$heading}}</a></li>
							<li><a href="{{ url('/admin/user/add') }}" class="btn btn-primary btn-icon btn-rounded"><i class=" icon-plus3"></i></a></li>
						</ul>
					</div>
				</div>
			
			
			
			

				<!-- Content area -->
				<div class="content">
				<!--  Page content -->
				


				@if(Request::segment(3) == 'add' || Request::segment(3) == 'edit')
					<div class="row" > 
						<div class="col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-2">
							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">Add Banner</h5>
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
											<label class="control-label col-lg-2">User Name <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="name" value="{{ $name }}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('name') }}</div>
										</div>

										<div class="form-group">
											<label class="control-label col-lg-2">First Name <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="fname" value="{{ $fname }}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('fname') }}</div>
										</div>

										<div class="form-group">
											<label class="control-label col-lg-2">Last Name <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="lname" value="{{ $lname }}" >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('lname') }}</div>
										</div>


										<div class="form-group">
											<label class="control-label col-lg-2">Email <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="email" value="{{ $email }}" disabled="disabled">
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('email') }}</div>
										</div>

										<div class="form-group">
											<label class="control-label col-lg-2">Password <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="password" class="form-control" name="password"  >
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('password') }}</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2">Image <span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-8">
											<input type="file" class="form-control" name="image" >
											
											</div>
										<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('image') }}</div>
										
										</div>

										@if(isset($imageold))
										<div style="width: 100%; text-align: center;">
											<img src="{{url('/')}}/public/database/{{ $email }}/{{ $imageold }}" width="100" >
										</div>
										@endif
										
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
										<!-- <th>First Name</th>
										<th>Last Name</th> -->
										<th>User Name</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Image</th>
										<th>Status</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
								@foreach($listdatas as $list)
									<tr>
										<!-- <td>{{ $list->name }} </td>
										<td>{{ $list->lastname }}</td> -->
										<td>{{ $list->username }}</td>
										<td>{{ $list->name }}</td>
										<td>{{ $list->lastname }}</td>
										<td>{{ $list->email }}</td>
										<td>
											@if(isset($list->picture))
											<img width="100" src="{{url('/public/database') }}/{{ $list->email }}/{{ $list->picture }}" >
											@endif
										</td>
										
										<td>
										@if($list->vstatus == '1' ) 
										<a href="{{ url('/admin/user/status/0/'.$list->id) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/admin/user/status/1/'.$list->id) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

										


										<td class="text-center">
											<a href="{{ url('/admin/finance/'.$list->id) }}" class="btn border-warning text-warning-600 btn-flat btn-icon"  >Finance</a>

											<!-- <a href="{{ url('/user/view/'.$list->id) }}" class="btn border-warning text-warning-600 btn-flat btn-icon"  ><i class="icon-book"></i></a> -->

											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('/admin/user/edit/'.$list->id) }}" type="button" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class=" icon-pencil5"></i></a>

											
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											 <a href="{{ url('/admin/user/delete/'.$list->id) }}" class="btn border-warning text-warning-600 btn-flat btn-icon" onclick="return confirm('Are You Soure Want to delete this ?')" ><i class=" icon-cancel-square2"></i></a> 
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
