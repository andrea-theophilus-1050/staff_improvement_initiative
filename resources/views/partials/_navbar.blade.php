<!-- partial:../../partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5"><img src="{{ asset('images/logo-greenwich.png') }}" class="mr-2"
                alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini"><img src="{{ asset('images/short-icon.jpg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        {{-- NOTE: get notifications from DB --}}
        @php
            $notifications = Auth::user()
                ->notifications()
                ->latest('created_at')
                ->get();
        @endphp
        {{-- NOTE: get notifications from DB --}}

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    {{-- NOTE: count --}}
                    @if ($notifications->count() > 0)
                        <span class="count"></span>
                    @endif
                    {{-- NOTE: count --}}
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications
                            ({{ $notifications->count() }})</p>
                            
                        @if ($notifications->count() > 0)
                            <a href="{{ route('clear.all.notify', auth()->user()->user_id) }}"
                                class="mb-0 font-weight-normal float-right dropdown-header"
                                onclick="return confirm('Are you sure to delete all notifications?')">Clear all</a>
                        @endif
                    </div>

                    {{-- NOTE: notification part NOTE: --}}
                    @foreach ($notifications as $notification)
                        @if ($notification->user->role_id == 4)
                            {{-- NOTE: Role staff --}}
                            @if ($notification->type_notification == 'topicNew')
                                <a href="{{ route('notification.handler', ['topicNew', $notification->url, $notification->id]) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-facebook">
                                            <i class="mdi mdi-bookmark-plus mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->notify_content }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>

                                    </div>
                                </a>
                            @elseif ($notification->type_notification == 'comment')
                                <a href="{{ route('notification.handler', ['comment', $notification->url, $notification->id]) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-secondary">
                                            <i class="mdi mdi-comment-alert mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->notify_content }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>

                                    </div>
                                </a>
                            @elseif ($notification->type_notification == 'QACoordinator-newTopic')
                                <a href="{{ route('notification.handler', ['QACoordinator-newTopic', $notification->url, $notification->id]) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark">
                                            <i class="mdi mdi-comment-alert mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->notify_content }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>

                                    </div>
                                </a>
                            @endif
                        @elseif($notification->user->role_id == 3)
                            @if ($notification->type_notification == 'postIdeas')
                                {{-- NOTE: Role QA Coordinators --}}
                                <a href="{{ route('notification.handler', ['postIdeas', $notification->url, $notification->id]) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-facebook">
                                            <i class="mdi mdi-bookmark-plus mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->notify_content }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>

                                    </div>
                                </a>
                            @elseif ($notification->type_notification == 'NewTopicFromQALeaders')
                                <a href="{{ route('notification.handler', ['NewTopicFromQALeaders', $notification->url, $notification->id]) }}"
                                    class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-facebook">
                                            <i class="mdi mdi-bookmark-plus mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->notify_content }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>

                                    </div>
                                </a>
                            @endif
                        @endif
                    @endforeach
                    {{-- NOTE: notification part NOTE: --}}


                </div>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    @if (auth()->user()->avatar == null)
                        <img src="{{ asset('img/default-avt.jpg') }}" alt="profile" />
                    @else
                        <img src="{{ asset('img/avatar/' . auth()->user()->avatar) }}" alt="profile" />
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="mdi mdi-account-circle text-primary"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
