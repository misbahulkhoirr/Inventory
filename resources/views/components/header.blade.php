<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
		
			
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
                        <h4 for="" class="text-white mt-2">INVENTORY</h4>
						<!-- <img src="assets/images/inventory-logo.png" alt="" class="logo"> -->
						
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav ml-auto">
						<li>
							<div class="dropdown drp-user">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="feather icon-user"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-notification">
									<div class="pro-head">
										<img src="{{asset('assets/images/user/avatar-2.jpg')}}" class="img-radius" alt="User-Profile-Image">
										<span>{{auth()->user()->username}}</span>
										<!-- <a href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dud-logout" title="Logout">
											<i class="feather icon-power"></i>
										</a> -->
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    	</form>
									</div>
									<ul class="pro-body">
										<li><a href="{{route('viewProfile.index')}}" class="dropdown-item"><i class="feather icon-user"></i> Change Password</a></li>
										<!-- <li><a href="#" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li> -->
										<li><a href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item"><i class="feather icon-power"></i> Logout</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
				
			
	</header>