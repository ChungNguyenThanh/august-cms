@extends('August::layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Download</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <img src="/assets-august/images/users/avatar-7.jpg" alt="image" class="img-fluid avatar-md rounded-circle">
                    
                    <div class="w-100">

                        <div class="height-35 d-flex justify-content-center flex-column mb-3">
                            <div>
                                <a href="#"><strong>Thủy Nguyễn Thị Ngọc</strong></a> <i class="fe-chevron-right"></i> Thảo Lê, Linh Nguyễn Thùy, Trang Nguyễn và 3 người nhận khác
                            </div>
                            <div><small>Tháng 6 11 15:28</small></div>
                        </div>

                        <div class="">
                            <p>Hi Coderthemes!</p>
                            <p>Clicking ‘Order Service’ on the right-hand side of the above page will present you with an order page. This service has the following Briefing Guidelines that will need to be filled before placing your order:</p>
                            <ol>
                                <li>Your design preferences (Color, style, shapes, Fonts, others) </li>
                                <li>Tell me, why is your item different? </li>
                                <li>Do you want to bring up a specific feature of your item? If yes, please tell me </li>
                                <li>Do you have any preference or specific thing you would like to change or improve on your item page? </li>
                                <li>Do you want to include your item's or your provider's logo on the page? if yes, please send it to me in vector format (Ai or EPS) </li>
                                <li>Please provide me with the copy or text to display</li>
                            </ol>

                            <p>Filling in this form with the above information will ensure that they will be able to start work quickly.</p>
                            <p>You can complete your order by putting your coupon code into the Promotional code box and clicking ‘Apply Coupon’.</p>
                            <p><b>Best,</b> <br> Graphic Studio</p>
                            <hr>
                            <div class="rounded">
                                <form class="needs-validation" novalidate="" name="chat-form" id="chat-form">
                                    <div class="row">
                                        <div class="col-sm-auto">
                                            <img src="/assets-august/images/users/avatar-5.jpg" alt="image" class="img-fluid avatar-sm rounded-circle">
                                        </div>
                                        <div class="col mb-sm-0">
                                            <input type="text" class="form-control" placeholder="Enter your text" required="">
                                            <div class="invalid-feedback mt-2">
                                                Please enter your messsage
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="btn-group gap-1">
                                                <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success chat-send"><i class="fe-send"></i></button>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card-->

        <div class="card mb-3">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Download</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <img src="/assets-august/images/users/avatar-7.jpg" alt="image" class="img-fluid avatar-md rounded-circle">
                    
                    <div class="w-100">

                        <div class="height-35 d-flex justify-content-center flex-column mb-3">
                            <div>
                                <a href="#"><strong>Thủy Nguyễn Thị Ngọc</strong></a> <i class="fe-chevron-right"></i> Thảo Lê, Linh Nguyễn Thùy, Trang Nguyễn và 3 người nhận khác
                            </div>
                            <div><small>Tháng 6 11 15:28</small></div>
                        </div>

                        <div class="">
                            <p>Hi Coderthemes!</p>
                            <p>Clicking ‘Order Service’ on the right-hand side of the above page will present you with an order page. This service has the following Briefing Guidelines that will need to be filled before placing your order:</p>
                            <ol>
                                <li>Your design preferences (Color, style, shapes, Fonts, others) </li>
                                <li>Tell me, why is your item different? </li>
                                <li>Do you want to bring up a specific feature of your item? If yes, please tell me </li>
                                <li>Do you have any preference or specific thing you would like to change or improve on your item page? </li>
                                <li>Do you want to include your item's or your provider's logo on the page? if yes, please send it to me in vector format (Ai or EPS) </li>
                                <li>Please provide me with the copy or text to display</li>
                            </ol>

                            <p>Filling in this form with the above information will ensure that they will be able to start work quickly.</p>
                            <p>You can complete your order by putting your coupon code into the Promotional code box and clicking ‘Apply Coupon’.</p>
                            <p><b>Best,</b> <br> Graphic Studio</p>
                            <hr>
                            <div class="rounded">
                                <form class="needs-validation" novalidate="" name="chat-form" id="chat-form">
                                    <div class="row">
                                        <div class="col-sm-auto">
                                            <img src="/assets-august/images/users/avatar-5.jpg" alt="image" class="img-fluid avatar-sm rounded-circle">
                                        </div>
                                        <div class="col mb-sm-0">
                                            <input type="text" class="form-control" placeholder="Enter your text" required="">
                                            <div class="invalid-feedback mt-2">
                                                Please enter your messsage
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="btn-group gap-1">
                                                <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success chat-send"><i class="fe-send"></i></button>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection
