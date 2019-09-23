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
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Query</th>
										<th>Organizaion</th>
										<th>Company Size</th>
										<th>Date</th>
										<th class="text-center" ><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								
								<tbody>
                                
                                @foreach($getSectionData as $list)

									<tr>
										<td>{{ $list->{'first'} }} {{ $list->{'last'} }} </td>
										<td>{{ $list->{'email'} }} </td>
										<td>{{ $list->{'phone'} }} </td>
										<td>{{ $list->{'description'} }} </td>
										<td>{{ $list->{'organization'} }} </td>
										<td>{{ $list->{'companysize'} }} </td>
										<td>{{ date('m-F, Y h:i:s', strtotime($list->{'created_at'})) }} </td>
	                                </tr>
								@endforeach									
								</tbody>
                            </table>  
                            @php 
                                if(!$getSectionData->toArray()['total']){
                                    echo '<h4>No user queries are found.</h4>';
                                }        
                            @endphp
						</div>			
						<div style="text-align:center;margin:20px;" >
							{!! $getSectionData->render() !!}
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
