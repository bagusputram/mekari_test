<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar skin-white">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="text-center image">
                    <img src="{{asset('img/wonderful-indonesia.png')}}" height="100px" class="logo-login" alt=""/>
                </div>
            </div>
            <div class="user-panel">
                <div class="text-center image">
                    @if ( App\Models\Setting\UserProfile::where('user_id', Auth::user()->id)->first()->profile_picture_id )
                        @php
                            $image = App\Models\Setting\UserProfile::where('user_id', Auth::user()->id)->first()->profilePicture->getURL('thumb');
                        @endphp
                    @else
                        @php
                            $image = asset('/img/user-profile.png');
                        @endphp
                    @endif
                    <img src="{{ $image }}" class="img-circle" alt="User Image" style="width:100px; height:100px;"/>
                </div>
            </div>
            <div class="user-panel">
                <div class="text-center image">
                    <p>{{ Auth::user()->name }}</p>
                    <p class="user-role">{{ Auth::user()->userRole->user_role_name }}</p>
                </div>
            </div>
        @endif


        {{--  <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->  --}}

        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="nav-devider"></li>
			@foreach( \App\Models\Setting\Menu::onlyRole()->base()->orderBy('menu_position','asc')->get() as $menu )
				<li{!! $menu->childs()->count() > 0 ? in_array($menu->menu_controller, explode("/", Request::path())) ? ' class="treeview"' : ' class="treeview"' : ($menu->menu_controller == Request::path() ? ' class="active"' : '') !!}>
					@if( $menu->childs()->count() > 0 )
						<a href='#'>
							<i class="{{ $menu->menu_icon }}"></i>
							<span class="sidebar-font">{{ trans('sidebar-menu.'.$menu->menu_language) }}</span>
							@if( $menu->childs()->count() > 0 )
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
							@endif
						</a>
					@else
						<a href="{{ $menu->menu_controller != '#' ? url($menu->menu_controller) : '#' }}">
							<i class="{{ $menu->menu_icon }}"></i>
							<span class="sidebar-font">{{ trans('sidebar-menu.'.$menu->menu_language) }}</span>
							@if( $menu->childs()->count() > 0 )
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
							@endif
						</a>
					@endif
					@if( $menu->childs()->count() > 0 )
					<ul class="treeview-menu">
                        @foreach( $menu->childs()->get() as $child )
                            <li {!! $child->menu_controller == Request::path() || explode("/", Request::path())[0] == $child->menu_controller ? " class='active'" : "" !!}>
                                <a href="{{ url($child->menu_controller) }}">{{ trans('sidebar-menu.'.$child->menu_language) }}</a>
                            </li>
                        @endforeach
					</ul>
					@endif
				</li>
			@endforeach
			</ul>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>
