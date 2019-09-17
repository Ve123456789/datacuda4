<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="javascript:void(0)" class="media-left"><img src="{{ asset('public/assetsadmin')  }}/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">Administrator</span>
									
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="javascript:void(0)"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->
					<style type="text/css">
						.navigation li a > i {font-size: 16px;}
					</style>

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

                                <!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								
								<li class=" @if(Request::segment(1) == 'dashboard') echo active @endif"><a href="{{ url('admin/dashboard') }}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								
								<li class=" @if(Request::segment(1) == 'homebanner') echo active @endif"><a href="{{ url('admin/user') }}"><i class="icon-phone-incoming"></i> <span>User</span></a></li>

								<li class=" @if(Request::segment(1) == 'homebanner') echo active @endif"><a href="{{ url('admin/homebanner') }}"><i class="icon-phone-incoming"></i> <span>Homepage Banner</span></a></li>
								
								<li class=" @if(Request::segment(1) == 'homesecond') echo active @endif"><a href="{{ url('admin/homesecond') }}"><i class="icon-phone-incoming"></i> <span>Homepage Second Section</span></a></li>
								
								<li class=" @if(Request::segment(1) == 'homethird') echo active @endif"><a href="{{ url('admin/homethird') }}"><i class="icon-phone-incoming"></i> <span>Homepage Third Section</span></a></li>
								
								<li class=" @if(Request::segment(1) == 'homereviews') echo active @endif"><a href="{{ url('admin/homereviews') }}"><i class="icon-phone-incoming"></i> <span>Homepage Reviews Section</span></a></li>

								<li class=" @if(Request::segment(1) == 'homeplans') echo active @endif"><a href="{{ url('admin/homeplans') }}"><i class="icon-phone-incoming"></i> <span>Homepage Plans Section</span></a></li>

								<li class="@if(Request::segment(1) == 'subscription-plans') echo active @endif"><a href="{{ url('admin/subscription-plans') }}"><i class="icon-phone-incoming"></i> <span>Subscription Plans</span></a></li>

								<li class=" @if(Request::segment(1) == 'aboutus') echo active @endif"><a href="{{ url('admin/aboutus') }}"><i class="icon-phone-incoming"></i> <span>About us</span></a></li>

								<li class=" @if(Request::segment(1) == 'contact_us') echo active @endif"><a href="{{ url('admin/contact_us') }}"><i class="icon-phone-incoming"></i> <span>Contact us</span></a></li>

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>