nnb       @extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" id="app_user">
        <div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            Menu
                        </a>
                    </li>
                    <router-link to="/" tag="li">
                        <p>
                            <a class="nav-items">My Profile</a>
                        </p>
                    </router-link>
                    <hr>
                    <router-link to="/createMessage" tag="li">
                        <p>
                            <a class="nav-items">Create Message</a>
                        </p>
                    </router-link>
                    <router-link to="/inbox" tag="li">
                        <p>
                            <a class="nav-items">Inbox</a>
                        </p>
                    </router-link>
                    <router-link to="/sent" tag="li">
                        <p>
                            <a class="nav-items">Sent</a>
                        </p>
                    </router-link>
                    <hr>
                    <router-link to="/myLinks" tag="li">
                        <p>
                            <a class="nav-items">My Links</a>
                        </p>
                    </router-link>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <transition name="slide-fade">
                        <router-view></router-view>
                    </transition>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app_user.js') }}"></script>
@endsection
