    <div class="app-header header-shadow  bg-white header-text-dark">
            <div class="app-header__logo ">
                @if ($company)
                <div class="mr-3 pr-2" > <img class="logo" src="{{asset('storage/images/'. $company->image)}}" width="100%" alt=""></div>
                @else
                <div class="m-5" > <h2><strong>truevalue.</strong></h2></div>

                @endif

                <div class="header__pane ">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                    
                      </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            @if (Auth::user()->image)
                                            <img width="42" class="rounded-circle" src="{{asset('storage/user_images/'. Auth::user()->image)}}" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            @else
                                            <img width="42" class="rounded-circle" src="{{asset('storage/images/user_100px.png')}}" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            @endif

                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                                 {{ __('Logout') }}
                                              </a>
                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                              </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{auth()->user()->name}}
                                    </div>
                                    <div class="widget-subheading">
                                        {{ucwords(auth()->user()->role)}}

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div> 