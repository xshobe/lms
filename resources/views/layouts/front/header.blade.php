<!-- header -->
<header>
    <div class="row">
        <div class="logo"><a href="{!! url('/') !!}"><img src="{!! asset('public/images/logo.png') !!}" alt="{!! Config::get('constants.app_name') !!}"></a></div>
        <div class="headright">
            <p class="top-info-section">
                <img src="{!! asset('public/images/phone.png') !!}">&nbsp;123-456-7890 / +123 345 567 7890 
                <img src="{!! asset('public/images/email.png') !!}">&nbsp;<a href="mailto:info@sipeu.com">info@sipeu.com</a>
            </p>
            <nav class="mainmenu">
                <div id="smoothmenu" class="ddsmoothmenu">
                    <ul>
                        <li><a href="{!! url('/') !!}">Home</a></li>
                        <li><a href="{!! url('page/about-us') !!}">About Us</a></li>
                        <li><a href="{!! url('page/contact-us') !!}">Contact Us</a></li>
                        @if (empty($user_info = Auth::guard('customer')->user()))
                        <li><a href="{!! url('login') !!}">Login</a></li>
                        @else
                        <li><a href="javascript:void(0);">Welcome {{ substr($user_info->user_name, 0, 15) }}</a>
                            <ul>
                                <li><a href="{!! url('dashboard') !!}">My Dashboard</a></li>
                                <li><a href="{!! url('profile/') !!}">View Profile</a></li>
                                <li><a href="{!! url('change-password') !!}">Change Password</a></li>
                                <li><a href="{!! url('loan-history') !!}">View Loan Histroy</a></li>
                                <li><a href="{!! url('share-balance') !!}">Share Balance</a></li>
                                <li><a href="{!! url('logout') !!}">Logout</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </nav>  
        </div><!-- /.headright -->
    </div><!-- /.row -->
</header><!-- /.header -->