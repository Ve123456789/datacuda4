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
							<h5><a href="{{ url('admin/aboutus') }}" ><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$title_heading}}</span></a></h5>
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
							<li><a href="{{ url('admin/aboutus') }}">{{$title_heading}}</a></li>
							<li><a href="{{ url('admin/aboutus/add') }}" class="btn btn-primary btn-icon btn-rounded"><i class="icon-plus3 position-left"></i></a></li>
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
										@php 
											$top_section = 'selected="selected"';
											$bottom_section = $left_grid = $right_grid = '';
											
										@endphp
										@if('bottom' == $section)
											{{$bottom_section = 'selected="selected"'}}
											{{$top_section = $left_grid = $right_grid = ''}}
										@endif
										@if('left_grid' == $section)
											{{$left_grid = 'selected="selected"'}}
											{{$top_section = $bottom_section = $right_grid = ''}}
										@endif
										@if('right_grid' == $section)
											{{$right_grid = 'selected="selected"'}}
											{{$top_section = $bottom_section = $left_grid = ''}}
										@endif

										<div class="form-group">
											<label class="control-label col-lg-2">Heading<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="heading" maxlength="50" placeholder="Please enter the heading" value="{{ $heading }}" >
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('heading') }}</div>
										</div>
                                        
                                        <div class="form-group">
											<label class="control-label col-lg-2">About Us Text<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<div class="col-lg-8">
											<textarea id="messageArea" name="content" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ $content }}</textarea>
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('content') }}</div>
										</div>
                                        
										<div class="form-group" id = "image_section">
											<label class="control-label col-lg-2">Image<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span></label>
											<div class="col-lg-8">
											<input type="file" class="form-control" name="image" >
											</div>
										    <div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" >{{ $errors->first('image') }}</div>
                                        </div>

										<div class="form-group"> 
											<label class="control-label col-lg-2">Choose About Us Section<span style="color:red; text-align:center; padding-5px; font:size:20px; font-weight:900;" >*</span> </label>
											<select name="section" id = "section_dropdown" class="form-control" style="width:160px;">
												<option value="top" {{$top_section}}>Top Section</option>
												<option value="bottom" {{$bottom_section}}>Bottom Section</option>
												<option value="left_grid" {{$left_grid}}>Left Grid Section</option>
												<option value="right_grid" {{$right_grid}}>Right Grid Section</option>
											</select>
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
										<input type="text" class="form-control" name="fname" value="" >
									</div>
									<div style="color:red;text-align:center;padding-5px;font:size:18px;font-weight:900;" ></div>
									<div class="col-lg-3 col-md-3 text-right">
										<button type="submit" class="btn btn-primary" name="serach" value="serach" >serach <i class="icon-arrow-right14 position-right"></i></button>
									</div>

								</fieldset>
							</form>
						</div>
					</div>
				
				
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">About us table </h5>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Heading</th>
										<th>Content</th>
										<th>Image</th>
										<th>Section</th>
										<th>Status</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
								@foreach($getAboutUsData as $list)
								@php
									$image_link = $list[config('constants.db.aboutus').'_image'];
								@endphp	
									<tr>
										<td>{{ $list->{config('constants.db.aboutus').'_heading' } }} </td>
										<td>{{ $list->{config('constants.db.aboutus').'_content' } }}</td>
										<td><img src="{{url('/')}}/public/images/{{ $image_link }}" width="100" ></td>
										<td><span style="font-size:15px;" class="label label-info">{{$list[config('constants.db.aboutus').'_section'].' Section'}}</span></td>
										
										<td>
										@if($list->{config('constants.db.aboutus').'_status' } == '1' ) 
										<a href="{{ url('/admin/aboutus/status/0/'.$list->{config('constants.db.aboutus').'_id' }) }}" ><span class="label label-success">Active</span></a>
									    @else
											<a href="{{ url('/admin/aboutus/status/1/'.$list->{config('constants.db.aboutus').'_id' }) }}" ><span class="label label-danger">Inctive</span></a>
										@endif
										</td>

									

										<td class="text-center">
											<a href="{{ url('/admin/aboutus/edit/'.$list->{config('constants.db.aboutus').'_id' }) }}" type="button" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class=" icon-pencil5"></i></a>

											
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="{{ url('/admin/aboutus/delete/'.$list->{config('constants.db.aboutus').'_id' }) }}" class="btn border-warning text-warning-600 btn-flat btn-icon" onclick="return confirm('Are You Soure Want to delete this ?')" ><i class=" icon-cancel-square2"></i></a>
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


<script type="text/javascript">
	CKEDITOR.replace( 'content',
         {
          customConfig : 'config.js',
          toolbar : 'simple'
          })

	$(document).change('#section_dropdown',function(){
		
		$('#image_section').show();
		var section = $( "#section_dropdown option:selected" ).val();
		if(section === 'left_grid' || section === 'right_grid'){
			$('#image_section').hide();
		}
	});
</script>