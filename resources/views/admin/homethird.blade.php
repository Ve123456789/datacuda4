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
							<h5><a href="{{ url('admin/homethird') }}" ><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$title_heading}}</span></a></h5>
						<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="javascript:void(0)" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span></span></a>
							</div>
						</div>
					</div>
					<div class="breadcrumb-line breadcrumb-line-component"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
						<ul class="breadcrumb">
							<li><a href="{{ url('admin/dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="{{ url('admin/homethird') }}">{{$title_heading}}</a></li>
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
										<h5 class="panel-title">{{$section_heading}}</h5>
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
											<label class="control-label col-lg-2">Heading<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="heading" value="{{ $heading }}" >
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('heading') }}</div>
										</div>
                                        
                                        <div class="form-group">
											<label class="control-label col-lg-2">Content<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="content" value="{{ $content }}" >
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('content') }}</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2">Image<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-8">
											<input type="file" class="form-control" name="image" >
											
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('image') }}</div>
                                        </div>

										@if(isset($imageold))
										<div style="width: 100%; text-align: center;">
											<img src="{{url('/')}}/public/images/{{ $imageold }}" width="100" >
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
										<input type="text" placeholder="Search a heading" class="form-control" name="search_heading" value="@if(old('search_heading') != ''){{old('search_heading')}}@elseif($search_heading){{ $search_heading }}@endif" >
									</div>
									<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('heading') }}</div>
                                    
                                    <div class="col-lg-3 col-md-3 text-right">
										<button type="submit" class="btn btn-primary" name="search" value="search" >Search <i class="icon-arrow-right14 position-right"></i></button>
									</div>

                                </fieldset>
							</form>
						</div>
					</div>
				
				
					<div class="panel panel-flat">
						<div class="panel-heading">
                            <h5 class="panel-title">{{ $title_heading }} table </h5> 
                            <div cass = "float-right"><a href="{{ url('admin/homethird/add') }}" class="btn btn-primary btn-icon btn-rounded">Add New Record</a></div>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Title</th>
										<th>Content</th>
										<th>Image</th>
										<th>Status</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
                                
                                @foreach($getSectionData as $list)

									<tr>
										<td>{{ $list->{config('constants.db.homethird').'_heading'} }} </td>
										<td>{{ $list->{config('constants.db.homethird').'_content'} }} </td>
										<td><img src="{{url('/')}}/public/images/{{ $list->{config('constants.db.homethird').'_image' } }}" width="100" ></td>
                                                                                
										<td>
										@if($list->{config('constants.db.homethird').'_status' } == '1' ) 
										<a href="{{ url('admin/homethird/status/2/'.$list->{config('constants.db.homethird').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('admin/homethird/status/1/'.$list->{config('constants.db.homethird').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

										<td class="text-center">
											
											<!-- <a href="{{ url('admin/homethird/view/'.$list->{config('constants.db.homethird').'_id' }) }}" class="btn border-warning text-warning-600 btn-flat btn-icon"  ><i class="icon-book"></i></a> -->

											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('admin/homethird/edit/'.$list->{config('constants.db.homethird').'_id' }) }}" type="button" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class=" icon-pencil5"></i></a>

											
											<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('admin/homethird/delete/'.$list->{config('constants.db.homethird').'_id' }) }}" class="btn border-warning text-warning-600 btn-flat btn-icon" onclick="return confirm('Are you sure you want to delete this ?')" ><i class=" icon-cancel-square2"></i></a> -->
										</td>
                                    </tr>
								@endforeach									
								</tbody>
                            </table>  
                            @php 
                                if(!$getSectionData->toArray()['total']){
                                    echo '<h4>No records are found. Please add one.</h4>';
                                }        
                            @endphp
						</div>			
						<div style="text-align:center;margin:20px;" >
							{!! $getSectionData->render() !!}
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
