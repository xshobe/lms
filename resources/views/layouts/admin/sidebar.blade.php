<script type="text/javascript">
    $(document).ready(function() {
        $('.hidem').parent().hide();
    });
</script>
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <h3 class="header main-head">MAIN NAVIGATION</h3>
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            @if (!empty(Auth::user()->Role->privileges->actions))
                @php
                    $menuList = unserialize(Auth::user()->Role->privileges->actions);
                @endphp
                @foreach ($menuList as $key => $menu_id)
                    @if (!empty($menu_links[$menu_id]['controller']))
                        <li class="{{ Request::is($menu_links[$menu_id]['url'] . '*') ? 'active' : '' }}">
                            <a href="{{ URL::to($menu_links[$menu_id]['url']) }}">
                                <i class="fa {{ $menu_links[$menu_id]['class'] }}"></i>
                                <span>
                                    {{ $menu_links[$menu_id]['title'] }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
