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

				<!-- Content area -->
				<div class="content">

				

					<style type="text/css">
						.panel {
						    min-height: 120px;
						}
					</style>
					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-3">


							<!-- Quick stats boxes -->
							<div class="row">
								<!-- <div class="col-lg-12">

									
									<div class="panel bg-teal-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-teal-800"><h3 style="margin: 0;">  120</h3></span>
											</div>

											<h3 class="no-margin">Total Client</h3>
										</div>

									</div>
									

								</div> -->


								<div class="col-lg-12">

									<!-- Current server load -->
									<div class="panel bg-pink-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-teal-800"><h3 style="margin: 0;">{{ count($share_images) }}</h3></span>
											</div>

											<h3 class="no-margin">Total Share</h3>
										</div>

									</div>
									<!-- /current server load -->

								</div>



								<div class="col-lg-12">

									<!-- Today's revenue -->
									<div class="panel bg-blue-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-teal-800"><h3 style="margin: 0;">{{ count($photographers) }}</h3></span>
											</div>

											<h3 class="no-margin">Total Users</h3>
										</div>
									</div>
									<!-- /today's revenue -->

								</div>



							</div>
							<!-- /quick stats boxes -->


							

						</div>

						<div class="col-lg-8 pull-right">

							<!-- Daily sales -->
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Latest Register Photographer</h6>
									<div class="heading-elements">
										<a href="{{url('/admin/user')}}" class="heading-text">View All: <span class="text-bold text-danger-600 position-right">Photographer</span></a>
										<!-- <ul class="icons-list">
					                		<li class="dropdown text-muted">
					                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
													<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
													<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
													<li class="divider"></li>
													<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
												</ul>
					                		</li>
					                	</ul> -->
									</div>
								</div>

								<div class="panel-body">
									<div id="sales-heatmap"></div>
								</div>

								<div class="table-responsive">
									<table class="table text-nowrap">
										<thead>
											<tr>
												<th>User Name </th>
												<th>Email </th>
												<th>Status</th>
											</tr>
										</thead>
										
										@foreach($photographers as $list)
										<tbody>
											<tr>
												<td>
													<div class="media-left media-middle">
														{{ $list->username }} 
													</div>

												</td>
												<td>
													
													<div class="media-body">
														<div class="media-heading">
															<a href="#" class="letter-icon-title">{{ $list->email }}</a>
														</div>
													</div>
												</td>
												<td>
													@if($list->vstatus == '1' ) 
													<a href="javascript:void(0)" ><span class="label label-success">Active</span></a>
												    @else
														<a href="javascript:void(0)" ><span class="label label-danger">Inctive</span></a>
													@endif
												</td>
											</tr>

										</tbody>
										@endforeach
										
									</table>
								</div>
							</div>
							<!-- /daily sales -->

						</div>

						<!-- <div class="col-lg-5">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Latest Client</h6>
									<div class="heading-elements">
										<a href="javascript:void(0)" class="heading-text">View All: <span class="text-bold text-danger-600 position-right">Client</span></a>
										
									</div>
								</div>

								<div class="panel-body">
									<div id="sales-heatmap"></div>
								</div>

								<div class="table-responsive">
									<table class="table text-nowrap">
										<thead>
											<tr>
												<th>Name </th>
												<th>Email </th>
												<th>Phone</th>
											</tr>
										</thead>
										<?php /* ?>
										@foreach($advicedata as $list)
										<tbody>
											<tr>
												<td>
													<div class="media-left media-middle">
														
														{{ $list->{config('constants.db.user').'_fname' } }} 
														{{ $list->{config('constants.db.user').'_lname' } }} 
													</div>

												</td>
												<td>
													
													<div class="media-body">
														<div class="media-heading">
															<a href="#" class="letter-icon-title">{{ $list->{config('constants.db.user').'_email' } }}</a>
														</div>
													</div>
												</td>
												<td>
													<h6 class="text-semibold no-margin">{{ $list->{config('constants.db.user').'_phone' } }}</h6>
												</td>
											</tr>

										</tbody>
										@endforeach
										<?php */ ?>

									</table>
								</div>
							</div>
						</div> -->



					</div>
					<!-- /dashboard content -->

					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-12">

							<!-- Simple interaction -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Latest Transction</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">

							<div class="chart-container">
								<!-- <div class="chart" id="d3-simple-interaction"></div> -->
								<canvas id="canvas"></canvas>
							</div>
						</div>
					</div>
					<!-- /simple interaction -->


						</div>
					</div>





					<!-- Footer -->
					<div class="footer text-muted">
						&copy; {{ date('Y-m-d') }} . <a href="javascript:void(0)">administrator </a>  <a href="javascript:void(0);" > </a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript">

		var color = Chart.helpers.color;
		var barChartData = {
			labels: <?php echo json_encode($latest_tr_count); ?>,
			datasets: [{
				label: 'Sales',
				backgroundColor: color("red").alpha(0.5).rgbString(),
				borderColor: "red",
				borderWidth: 1,
				data: <?php echo json_encode($latest_transction); ?>
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					
				}
			});

		};

		
	</script>

<script type="text/javascript">
	

	/* ------------------------------------------------------------------------------
 *
 *  # D3.js - bars with simple interaction
 *
 *  Demo d3.js bar chart setup with animated data source change
 *
 *  Version: 1.0
 *  Latest update: August 1, 2015
 *
 * ---------------------------------------------------------------------------- */
/*
$(function () {

    // Create Uniform checkbox
    $(".toggle-dataset").uniform();


    // Initialize chart
    interaction('#d3-simple-interaction', 400);

    // Chart setup
    function interaction(element, height){


        // Basic setup
        // ------------------------------

        // Define main variables
        var d3Container = d3.select(element),
            margin = {top: 5, right: 20, bottom: 20, left: 10},
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
            height = height - margin.top - margin.bottom - 5;

        // Demo data set
        var dataset = <?php //echo json_encode($latest_transction); ?>;

        console.log(dataset); 

        // Construct scales
        // ------------------------------

        // Horizontal
        var x = d3.scale.ordinal()
            .domain(d3.range(dataset.length))
            .rangeRoundBands([0, width], 0.05);

        // Vertical
        var y = d3.scale.linear()
            .domain([0, d3.max(dataset)])
            .range([0, height]);

        // Colors
        var colors = d3.scale.category20();



        // Create axes
        // ------------------------------

        // Horizontal
        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");



        // Create chart
        // ------------------------------

        // Add SVG element
        var container = d3Container.append("svg");

        // Add SVG group
        var svg = container
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



        // Add tooltip
        // ------------------------------

        // Create tooltip
        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0])
            .html(function(d) { return d })

        // Initialize tooltip
        svg.call(tip);


        //
        // Append chart elements
        //

        // Append bars
        // ------------------------------

        // Add bars
        var drawBars = svg.selectAll(".d3-bar")
            .data(dataset)
            .enter()
            .append("rect")
                .attr("class", "d3-bar")
                .attr("x", function(d, i) { return x(i) })
                .attr("width", x.rangeBand())
                .attr("height", 0)
                .attr("y", height)
                .attr("fill", function(d, i) { return colors(i); })
                .style("cursor", "pointer")
                .on('mouseover', tip.show)
                .on('mouseout', tip.hide)

        // Add bar transition
        drawBars.transition()
            .delay(200)
            .duration(1000)
            .attr("height", function(d) { return y(d) })
            .attr("y", function(d) { return height - y(d) })


        // Add text labels
        var drawLabels = svg.selectAll(".value-label")
            .data(dataset)
            .enter()
           // .append("text")
                .attr("class", "value-label")
                .attr("x", function(d, i) { return x(i) + x.rangeBand() / 2 })
                .attr("y", function(d) { return height - y(d) + 25; })
                .style('opacity', 0)
                .style("text-anchor", "middle")
                .style("fill", "white")
                .text(function(d) {return d;});

        // Add text label transition
        drawLabels.transition()
            .delay(1000)
            .duration(500)
            .style('opacity', 1);



        // Create axes
        // ------------------------------

        // Horizontal
        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");





        // Resize chart
        // ------------------------------

        // Call function on window resize
        $(window).on('resize', resize);

        // Call function on sidebar width change
        $('.sidebar-control').on('click', resize);

        // Resize function
        // 
        // Since D3 doesn't support SVG resize by default,
        // we need to manually specify parts of the graph that need to 
        // be updated on window resize
        function resize() {

            // Layout variables
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


            // Layout
            // -------------------------

            // Main svg width
            container.attr("width", width + margin.left + margin.right);

            // Width of appended group
            svg.attr("width", width + margin.left + margin.right);


            // Axes
            // -------------------------

            // Horizontal range
            x.rangeRoundBands([0, width], 0.05);

            // Horizontal axis
            svg.selectAll('.d3-axis-horizontal').call(xAxis);


            // Chart elements
            // -------------------------

            // Bars
            svg.selectAll('.d3-bar').attr("x", function(d, i) { return x(i) }).attr("width", x.rangeBand());

            // Text label
            svg.selectAll(".value-label").attr("x", function(d, i) { return x(i) + x.rangeBand() / 2 });
        }
    }
});*/
</script>

</body>
</html>
