@extends('August::layouts.app')
@section('page-title')
    
@endsection
@section('content')
<div class="row">
    <!-- start chat users-->
    <div class="col-xl-3 col-lg-4">
        <div class="card">
            <div class="card-body">

                <div class="d-flex align-items-start align-items-start mb-3">
                    <img src="/assets-august/images/users/avatar-1.jpg" class="me-2 rounded-circle" height="42" alt="Brandon Smith">
                    <div class="flex-1">
                        <h5 class="mt-0 mb-0 font-15">
                            <a href="contacts-profile.html" class="text-reset">Nik Patel</a>
                        </h5>
                        <p class="mt-1 mb-0 text-muted font-14">
                            <small class="mdi mdi-circle text-success"></small> Online
                        </p>
                    </div>
                    <div>
                        <a href="javascript: void(0);" class="text-reset font-20">
                            <i class="mdi mdi-cog-outline"></i>
                        </a>
                    </div>
                </div>

                <!-- start search box -->
                <form class="search-bar mb-3">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-light" placeholder="People, groups &amp; messages...">
                        <span class="mdi mdi-magnify"></span>
                    </div>
                </form>
                <!-- end search box -->

                <h6 class="font-13 text-muted text-uppercase mb-2">Contacts</h6>

                <!-- users -->
                <div class="row">
                    <div class="col">
                        <div data-simplebar="init" style="max-height: 498px"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status"></span>
                                        <img src="/assets-august/images/users/avatar-2.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">4:30am</span>
                                            Brandon Smith
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-25 float-end text-end"><span class="badge badge-soft-danger">3</span></span>
                                            <span class="w-75">How are you today?</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status online"></span>
                                        <img src="/assets-august/images/users/avatar-5.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">5:30am</span>
                                            James Zavel
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Hey! a reminder for tomorrow's meeting...</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status busy"></span>
                                        <img src="/assets-august/images/users/avatar-7.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Thu</span>
                                            Maria C
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-25 float-end text-end"><span class="badge badge-soft-danger">2</span></span>
                                            <span class="w-75">Are we going to have this week's planning meeting today?</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status online"></span>
                                        <img src="/assets-august/images/users/avatar-8.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Wed</span>
                                            Rhonda D
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Please check these design assets...</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status do-not-disturb"></span>
                                        <img src="/assets-august/images/users/avatar-3.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Tue</span>
                                            Michael H
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Are you free for 15 min? I would like to discuss something...</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status"></span>
                                        <img src="/assets-august/images/users/avatar-6.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Tue</span>
                                            Thomas R
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Let's have meeting today between me, you and Tony...</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status online"></span>
                                        <img src="/assets-august/images/users/avatar-8.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Tue</span>
                                            Thomas J
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Howdy?</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="text-body">
                                <div class="d-flex align-items-start p-2">
                                    <div class="position-relative">
                                        <span class="user-status online"></span>
                                        <img src="/assets-august/images/users/avatar-4.jpg" class="me-2 rounded-circle" height="42" alt="user">
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mt-0 mb-0 font-14">
                                            <span class="float-end text-muted fw-normal font-12">Mon</span>
                                                Ricky J
                                        </h5>
                                        <p class="mt-1 mb-0 text-muted font-14">
                                            <span class="w-75">Are you interested in learning?</span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 615px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 403px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div> <!-- end slimscroll-->
                    </div> <!-- End col -->
                </div>
                <!-- end users -->
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <!-- end chat users-->

    <!-- chat area -->
    <div class="col-xl-9 col-lg-8">

        <div class="card">
            <div class="card-body py-2 px-3 border-bottom border-light">
                <div class="d-flex py-1">
                    <img src="/assets-august/images/users/avatar-5.jpg" class="me-2 rounded-circle" height="36" alt="Brandon Smith">
                    <div class="flex-1">
                        <h5 class="mt-0 mb-0 font-15">
                            <a href="contacts-profile.html" class="text-reset">James Zavel</a>
                        </h5>
                        <p class="mt-1 mb-0 text-muted font-12">
                            <small class="mdi mdi-circle text-success"></small> Online
                        </p>
                    </div>
                    <div id="tooltip-container">
                        <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                            <i class="fe-phone-call" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Voice Call" data-bs-original-title="Voice Call"></i>
                        </a>
                        <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                            <i class="fe-video" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Video Call" data-bs-original-title="Video Call"></i>
                        </a>
                        <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                            <i class="fe-user-plus" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add Users" data-bs-original-title="Add Users"></i>
                        </a>
                        <a href="javascript: void(0);" class="text-reset font-19 py-1 px-2 d-inline-block">
                            <i class="fe-trash-2" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete Chat" data-bs-original-title="Delete Chat"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="conversation-list chat-app-conversation" data-simplebar="init" style="max-height: 460px"><div class="simplebar-wrapper" style="margin: 0px -15px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 15px;">
                    <li class="clearfix">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-5.jpg" class="rounded" alt="James Z">
                            <i>10:00</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>James Zavel</i>
                                <p>
                                    Hello!
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix odd">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-1.jpg" class="rounded" alt="Nik Patel">
                            <i>10:01</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>Nik Patel</i>
                                <p>
                                    Hi, How are you? What about our next meeting?
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-5.jpg" class="rounded" alt="James Z">
                            <i>10:01</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>James Zavel</i>
                                <p>
                                    Yeah everything is fine
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix odd">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-1.jpg" class="rounded" alt="Nik Patel">
                            <i>10:02</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>Nik Patel</i>
                                <p>
                                    Wow that's great
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-5.jpg" alt="James Z" class="rounded">
                            <i>10:02</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>James Zavel</i>
                                <p>
                                    Let's have it today if you are free
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix odd">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-1.jpg" alt="Nik Patel" class="rounded">
                            <i>10:03</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>Nik Patel</i>
                                <p>
                                    Sure thing! let me know if 2pm works for you
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-5.jpg" alt="James Z" class="rounded">
                            <i>10:04</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>James Zavel</i>
                                <p>
                                    Sorry, I have another meeting scheduled at 2pm. Can we have it
                                    at 3pm instead?
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-5.jpg" alt="James Z" class="rounded">
                            <i>10:04</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>James Zavel</i>
                                <p>
                                    We can also discuss about the presentation talk format if you have some extra mins
                                </p>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix odd">
                        <div class="chat-avatar">
                            <img src="/assets-august/images/users/avatar-1.jpg" alt="Nik Patel" class="rounded">
                            <i>10:05</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>Nik Patel</i>
                                <p>
                                    3pm it is. Sure, let's discuss about presentation format, it would be great to finalize today. 
                                    I am attaching the last year format and assets here...
                                </p>
                            </div>
                            <div class="card mt-2 mb-1 shadow-none border text-start">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-primary rounded">
                                                    PDF
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-medium">minton-presentation.pdf</a>
                                            <p class="mb-0">2.3 MB</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted">
                                                <i class="ri-download-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="conversation-actions dropdown">
                            <button class="btn btn-sm btn-link text-reset" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical font-18"></i></button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Copy Message</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </li>
                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 906px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 233px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>

                <div class="row">
                    <div class="col">
                        <div class="mt-2 bg-light p-3 rounded">
                            <form class="needs-validation" novalidate="" name="chat-form" id="chat-form">
                                <div class="row">
                                    <div class="col mb-2 mb-sm-0">
                                        <input type="text" class="form-control border-0" placeholder="Enter your text" required="">
                                        <div class="invalid-feedback mt-2">
                                            Please enter your messsage
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-success chat-send"><i class="fe-send"></i></button>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </form>
                        </div> 
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div>
    <!-- end chat area-->
</div>
@endsection