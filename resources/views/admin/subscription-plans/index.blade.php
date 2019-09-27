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
							<h5>
                                <a href="{{ url('admin/homeplans') }}" >
                                    <i class="icon-arrow-left52 position-left"></i> 
                                    <span class="text-semibold">Subscription Plans</span>
                                </a>
                            </h5>
						    <a class="heading-elements-toggle">
                                <i class="icon-more"></i>
                            </a>
                        </div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="javascript:void(0)" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span></span></a>
							</div>
						</div>
					</div>
					<div class="breadcrumb-line breadcrumb-line-component"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
						<ul class="breadcrumb">
							<li><a href="{{ url('admin/dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="{{ url('admin/subscription-plans') }}">Subscription Plans</a></li>
						</ul>
					</div>
                    
                </div>

                <div class="content">
                    <!---- Data Table start ----->
                    <div class="panel panel-flat">
						@include('shared.errors')
						@include('shared.success')
                        <div class="panel-heading">
                        	<h5 class="panel-title">Subscription Plans table </h5>
                            <div class="float-right">
                                <a href="{{ url('admin/subscription-plans/create') }}" class="btn btn-primary btn-icon btn-rounded">Create Subacription Plan</a>
                            </div>							
                        </div>
                        <div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Amount</th>
										<th>Storage</th>
										<th>Validity</th>
										<th>Commission</th>
										<th>Is Active?</th>
										<th class="text-center"><i class="icon-menu-open2"></i></th>
									</tr>
								</thead>
								<tbody>
								@foreach($list as $plan)
									<tr>
										<td>{{ ucwords ($plan->name) }}</td>
										<td>$ {{ $plan->amount }}</td>
										<td>{{ $plan->storage_quantity }} {{ strtoupper ($plan->storage_unit) }}</td>
										<td>{{ $plan->vailidity_quantity ?? 0 }} {{ strtoupper ($plan->validity_unit) }}</td>
										<td>{{ $plan->commission }}%</td>
										<td>{{ $plan->active ? 'Yes' : 'No' }}</td>
										<td class="text-center">
											<a href="{{ route('subscriptionPlanView', ['planId' => $plan->id]) }}" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded">
												<i class=" icon-pencil5"></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
                        </div>

						{{ $list->links() }}
                    </div>
                </div>
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->
</body>
</html>
