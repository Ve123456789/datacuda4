<div class="navbar navbar-default header-highlight">
		<div class="navbar-header">
			<!--<a class="navbar-brand" href=""><img src="{{ asset('public/assetsadmin')  }}/images/logo_light.png" alt=""></a>-->
			<a class="navbar-brand" href="" style="font-weight: 900; font-size: 18px;color:#FFF" >DataCuda</a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="javascript:void(0)navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
		
		<!-- nav left side icon strat -->
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				<li class="dropdown">
					<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-git-compare"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="badge bg-warning-400">9</span>
					</a>
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Git updates
							<ul class="icons-list">
								<li><a href="javascript:void(0)"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="javascript:void(0)" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>

								<div class="media-body">
									Drop the IE <a href="javascript:void(0)">specific hacks</a> for temporal inputs
									<div class="media-annotation">4 minutes ago</div>
								</div>
							</li>

						</ul>

						<div class="dropdown-content-footer">
							<a href="javascript:void(0)" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
			</ul>
			
			<p class="navbar-text"><span class="label bg-success">Online</span></p>
			
			<!-- // nav left side icon end-->
			

			
			
			<!--  nav Right side icon Start-->

			<ul class="nav navbar-nav navbar-right">
			
			<!--  Language section Start-->
				<li class="dropdown language-switch">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('public/assetsadmin')  }}/images/flags/gb.png" class="position-left" alt="">
						English
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="deutsch"><img src="{{ asset('public/assetsadmin')  }}/images/flags/de.png" alt=""> Deutsch</a></li>
						<li><a class="ukrainian"><img src="{{ asset('public/assetsadmin')  }}/images/flags/ua.png" alt=""> Українська</a></li>
						<li><a class="english"><img src="{{ asset('public/assetsadmin')  }}/images/flags/gb.png" alt=""> English</a></li>
						<li><a class="espana"><img src="{{ asset('public/assetsadmin')  }}/images/flags/es.png" alt=""> España</a></li>
						<li><a class="russian"><img src="{{ asset('public/assetsadmin')  }}/images/flags/ru.png" alt=""> Русский</a></li>
					</ul>
				</li>
				<!--  Language section End-->
				
				<!--  Message section Start-->
				<li class="dropdown">
				
					<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="visible-xs-inline-block position-right">Messages</span>
						<span class="badge bg-warning-400">2</span>
					</a>
					
					<div class="dropdown-menu dropdown-content width-350">
						<div class="dropdown-content-heading">
							Messages
							<ul class="icons-list">
								<li><a href="javascript:void(0)"><i class="icon-compose"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body">
							<li class="media">
								<div class="media-left">
									<img src="{{ asset('public/assetsadmin')  }}/images/placeholder.jpg" class="img-circle img-sm" alt="">
									<span class="badge bg-danger-400 media-badge">5</span>
								</div>

								<div class="media-body">
									<a href="javascript:void(0)" class="media-heading">
										<span class="text-semibold">James Alexander</span>
										<span class="media-annotation pull-right">04:58</span>
									</a>

									<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
								</div>
							</li>

							
						</ul>

						<div class="dropdown-content-footer">
							<a href="javascript:void(0)" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
				<!--  Message section End-->
				
				
				<!--  Profile section Start-->
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('public/assetsadmin')  }}/images/placeholder.jpg" alt="">
						<span>Victoria</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="javascript:void(0)"><i class="icon-user-plus"></i> My profile</a></li>
						
						<li><a href="javascript:void(0)"><i class="icon-coins"></i> My balance</a></li>
						
						<li class="divider"></li>
						<li><a href="{{ url('admin/changepassword') }}"><i class="icon-cog5"></i> Change Password</a></li>
						
						<li><a href="{{ url('admin/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
				<!--  Profile section End-->
				
				
			</ul>
		</div>
	</div>