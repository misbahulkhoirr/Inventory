<nav class="pcoded-navbar menu-light ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="{{asset('assets/images/user/avatar-2.jpg')}}" alt="User-Profile-Image">
						<div class="user-details">
							<div id="more-details">{{auth()->user()->username}} <i class="fa fa-caret-down"></i></div>
						</div>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-inline">
							<li class="list-inline-item"><a href="{{route('viewProfile.index')}}" data-toggle="tooltip" title="View Profile"><i class="feather icon-user"></i></a></li>
							<!-- <li class="list-inline-item"><a href="#"><i class="feather icon-mail" data-toggle="tooltip" title="Messages"></i><small class="badge badge-pill badge-primary">5</small></a></li> -->
							<li class="list-inline-item"><a href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Logout" class="text-danger"><i class="feather icon-power"></i></a></li>
						</ul>
					</div>
				</div>
				@if(auth()->check())
				<hr>
				<ul class="nav pcoded-inner-navbar mt-2">
					@if(auth()->user()->role_id == 1)
					<li class="nav-item pcoded-menu-caption">
						<label>Menu</label>
					</li>
					@endif
                    <li class="nav-item {{setActive(['home'])}}"><a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>
					<li class="nav-item {{setActive(['product-in.index','product-in.create'])}}"><a href="{{route('product-in.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-log-in"></i></span><span class="pcoded-mtext">Product In</span></a></li>
                    <li class="nav-item {{setActive(['product-out.index','product-out.create'])}}"><a href="{{route('product-out.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-log-out"></i></span><span class="pcoded-mtext">Product Out</span></a></li>
					<!-- <li class="nav-item {{setActive(['mutasi.index'])}}"><a href="{{route('mutasi.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-repeat"></i></span><span class="pcoded-mtext">Mutasi Product</span></a></li> -->
					<li class="nav-item {{setActive(['transfer.index','transfer.create'])}}"><a href="{{route('transfer.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-share"></i></span><span class="pcoded-mtext">Transfer Stok</span></a></li>
					<li class="nav-item {{setActive(['stok.index'])}}"><a href="{{route('stok.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-package"></i></span><span class="pcoded-mtext">Stok Product</span></a></li>
					<li class="nav-item {{setActive(['opname.index','opname.create','opname.view','opname.edit'])}}"><a href="{{route('opname.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Stok Opname</span></a></li>
					@if(auth()->user()->role_id == 1)
					<li class="nav-item pcoded-menu-caption">
						<label>Data Master</label>
					</li>
					<li class="nav-item pcoded-hasmenu  {{setActive(['users.index','products.index','supplier.index','gudang.index'])}}">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Data Master</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{route('users.index')}}">User</a></li>
							<li><a href="{{route('products.index')}}">Products</a></li>
							<li><a href="{{route('supplier.index')}}">Supplier</a></li>
							<li><a href="{{route('gudang.index')}}">Gudang</a></li>
							<!-- <li><a href="{{route('storage.index')}}">Storage</a></li> -->
							<li><a href="{{route('category-product.index')}}">Category Product</a></li>
							<li><a href="{{route('satuan.index')}}">Satuan Product</a></li>
						</ul>
					</li>
					@endif
				</ul>
				@endif
			</div>
		</div>
	</nav>