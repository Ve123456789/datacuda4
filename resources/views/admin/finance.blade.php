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
							<li><a href="{{ url('/admin/finance') }}">{{$heading}}</a></li>
						</ul>
					</div>
				</div>
			
			
			
			

				<!-- Content area -->
				<div class="content">
					<!--  Page content -->
				
					
									
					
				<!---- Data Table start ----->	
				<?php /* ?>
					<div class="panel panel-flat">
						

						<div class="panel-body">
							<form class="form-horizontal" action="" method="post" >
							{{ csrf_field() }}
								<fieldset class="content-group">
									
									<div class="col-lg-3 col-md-3">
										<input type="text" class="form-control" name="fname" value="" >
									</div>
									<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('fname') }}</div>
									<div class="col-lg-3 col-md-3 text-right">
										<button type="submit" class="btn btn-primary" name="serach" value="serach" >serach <i class="icon-arrow-right14 position-right"></i></button>
									</div>

								</fieldset>
							</form>
						</div>
					</div>
				<?php */ ?>
				
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">{{ $heading }} finance table </h5>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Customer</th>
										<th>Project name</th>
										<th>Created</th>
										<th>Total Purchased</th>
										<th>Amount</th>
										<th>Status</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
								@foreach($listdatas as $list)
									<tr>
										<td>{{ $list->user_detail->username }} </td>
										<td>{{ $list->project_name }}</td>
										<td>{{ date("m/d/Y",strtotime($list->created_at)) }}</td>
										<td>{{ $list->purchase_details }}</td>
										<td>{{ $list['purchase_price'] }}</td>
																				
										<td>
										@if($list->purchase_details >= '1' ) 
										<a href="javascript:void(0)" ><span class="label label-success">Payed</span></a>
									    @else
											<a href="javascript:void(0)" ><span class="label label-danger">Awaiting Payment </span></a>
										@endif
										</td>

										<td class="text-center">
											
										</td>
									</tr>
								@endforeach									
								</tbody>

							</table>
						</div>			
						<div style="text-align:center;margin:20px;" >
							
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
