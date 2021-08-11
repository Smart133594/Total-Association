<!--FOOTER-->
<footer>
    <div id="csi-footer" class="csi-footer">
        <div class="csi-inner-bg">
            <div class="csi-inner">
                <div class="csi-footer-middle">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="csi-footer-logo" align="center">
                                    <a class="logo" href="{{route('index')}}"><img
                                            src="/assets/img/images/footer_logo.png" style="height: 100px;" alt="Logo"></a>

                                    <ul class="list-inline csi-social" style="padding: 20px 0;">
                                        <li><a href="{{$setting->fbLink}}"><i class="fa fa-facebook"
                                                                              aria-hidden="true"></i></a></li>
                                        <li><a href="{{$setting->twitterLink}}"><i class="fa fa-twitter"
                                                                                   aria-hidden="true"></i></a></li>
                                        <li><a href="{{$setting->instaLink}}"><i class="fa fa-instagram"
                                                                                 aria-hidden="true"></i></a></li>
                                        <li><a href="{{$setting->vimeoLink}}"><i class="fa fa-vimeo"
                                                                                 aria-hidden="true"></i></a></li>
                                        <li><a href="{{$setting->behanceLink}}"><i class="fa fa-behance"
                                                                                   aria-hidden="true"></i></a></li>
                                        <li><a href="{{$setting->dribbleLink}}"><i class="fa fa-dribbble"
                                                                                   aria-hidden="true"></i></a></li>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="csi-footer-single-area">
                                    <div class="row">
                                        <div class=" col-md-4">
                                            <h3 class="footer-title">Quick Link</h3>

                                            <ul style="list-style:none; padding:0;">
                                                <li><a href="{{route('amenities')}}" style="color:#fff;">Amenities</a>
                                                </li>
                                                @foreach($bottompage as $t)
                                                    <li><a href="{{ url("page/".$t->seoUrl)}}"
                                                           style="color:#fff;">{{ $t->pageName}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class=" col-md-8">
                                            <h3 class="footer-title"> Location </h3>
                                            <address>
                                                {!! $setting->address !!}
                                            </address>
                                            <a class="map-link" href="{{$setting->mapLink}}"><i class="fa fa-map-marker"
                                                                                                aria-hidden="true"></i>
                                                View Map location</a>
                                            <h3 class="footer-title" style="    font-size: 15px; margin: 0;"> Contact
                                                No </h3>
                                            <address>
                                                {{$setting->phone1}}<br>
                                                {{$setting->phone2}}

                                            </address>

                                        </div>
                                    </div>

                                </div>
                                <!--//.SUBSCRIBE-->

                            </div>
                            <div class="col-xs-12  " align="center"
                                 style="border-top: 1px solid #3e4e6f !important;    padding-top: 15px;">
                                <div class="csi-copyright">
                                    <p class="text">© 2020 Crystal Crown is proudly powered by <a
                                            href="http://www.softnet.co.in/" style="color:#F8080C;">Softnet</a></p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- //.CONTAINER -->
                </div>
            </div>
        </div>
        <!-- //.footer Middle -->
    </div>
</footer>
<!--FOOTER END-->


</div> <!--//.csi SITE CONTAINER-->
<!-- *** ADD YOUR SITE SCRIPT HERE *** -->


<!-- JQUERY  -->
<script src="/assets/js/vendor/jquery-1.12.4.min.js"></script>

<!-- BOOTSTRAP JS  -->
<script src="/assets/libs/bootstrap/js/bootstrap.min.js"></script>


<!-- SKILLS SCRIPT  -->
<script src="/assets/libs/jquery.validate.js"></script>

<!-- if load google maps then load this api, change api key as it may expire for limit cross as this is provided with any theme -->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzfNvH2kifJQ0PhBIyuuG-swdkW1NPQVE"></script>

<!-- CUSTOM GOOGLE MAP -->
<script type="text/javascript" src="/assets/libs/gmap/jquery.googlemap.js"></script>

<!-- Owl Carousel  -->
<script src="/assets/libs/owlcarousel/owl.carousel.min.js"></script>


<!-- type js -->
<script src="/assets/libs/typed/typed.min.js"></script>


<!-- COUNTDOWN   -->
<script src="/assets/libs/countdown.js"></script>


<!-- SMOTH SCROLL -->
<script src="/assets/libs/jquery.smooth-scroll.min.js"></script>
<script src="/assets/libs/jquery.easing.min.js"></script>


<!-- adding magnific popup js library -->
<script type="text/javascript" src="/assets/libs/maginificpopup/jquery.magnific-popup.min.js"></script>

<!-- SMOTH SCROLL -->
<script src="/assets/libs/jquery.smooth-scroll.min.js"></script>
<script src="/assets/libs/jquery.easing.min.js"></script>


<!-- CUSTOM SCRIPT  -->
<script src="/assets/js/custom.script.js"></script>


<div class="csi-switcher-loader"></div><!-- For Demo Purpose Only// Remove From Live -->

<link rel="stylesheet" href="/assets/js/calender/style.css">

<script src="../../cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<!-- partial -->

<script src="/assets/js/calender/script.js"></script>


<div>
    <div class="btn-box">


        <a class="csi-btn csi-btn-brand book_botton slide-toggle book_botton" href="#">BOOK NOW</a>
    </div>

    <div class="box" id="hide">
        <div class="box-inner">


            <div class="csi-heading" style="margin:10px 0;">
                <h2 class="heading" style="font-size:25px; "> BOOK NOW </h2>

            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <form method="POST" action="{{ route('bookingsave') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control height " id="csiname"
                                   placeholder="Enter Your Name ..." required="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control height" id="csiemail"
                                   placeholder="Enter Email address ..." required="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <input type="number" name="phoneNo" class="form-control height" id="csisubject"
                                   placeholder="Phone No" required="" aria-required="true">
                        </div>
                        <div class="form-group">
                            <select class="form-control height" name="ceremony" required>
                                <option value="">Occasion Type</option>
                                <option value="Wedding Ceremony">Wedding Ceremony</option>
                                <option value="Conference Meeting">Conference Meeting</option>
                                <option value="Thread Ceremony"> Thread Ceremony</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Ring Ceremony">Ring Ceremony</option>
                                <option value="Sangeet">Sangeet</option>
                                <option value="Anniversarys">Anniversarys</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" name="datee" class="form-control height " id="all_datepicker"
                                   placeholder="Choose Date" required="" aria-required="true" onchange="allgetarea()">
                        </div>


                        <div class="row">
                            <div class="col-md-6" style="padding-right:5px;">
                                <div class="form-group">
                                    <select class="form-control height" name="time" id="all_time" required onchange="allgetarea()">
                                        <option value="">Choose Time</option>
                                        <option value="All day">All Day</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Evening">Evening</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-left:5px;">
                                <div class="form-group">
                                    <select class="form-control height" name="areasId" id="all_area" required>
                                        <option value="">Choose Place</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div align="center">
                            <button type="submit" class="csi-btn hvr-glow hvr-radial-out csisend csi-send">Book Now
                            </button>

                            <div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<div>
    <div class="btn-box2">
        <a href="#" class="csi-btn csi-btn-brand   slide-toggle2 book_botton2">Find our Other Venue </a>
    </div>


    <div class="box2" id="hide2">
        <div class="box-inner2">
            <h3 style="padding-top:1px; text-align:center; color:#000;">Find our Other Venue</h3>
            <div class="row">

                <div class="col-md-12">

                </div>
                <div class="col-md-6">

                    <img src="/assets/img/images/crystal_logo.png">

                    <div class="btn-box">


                        <a class="csi-btn csi-btn-brand" href="https://courtyard.flexzyn.xyz/page/about-us"
                           style="padding: 10px 5px; width:100%;text-align:center;     font-size: 11px;"
                           targate="_blank">Crystal Courtyard</a>
                    </div>


                </div>

                <div class="col-md-6">
                    <img src="/assets/img/images/crystal_logo.png">
                    <div class="btn-box">
                        <a class="csi-btn csi-btn-brand" href="https://crown.flexzyn.xyz/page/crystal-savannah"
                           style="padding: 10px 5px; width:100%;text-align:center;     font-size: 11px;"
                           targate="_blank"> Crystal Savannah </a>
                    </div>


                </div>


                <div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function allgetarea() {
        var time = $("#all_time").val();
        var date = $("#all_datepicker").val();
        if (date && time) {
            $.get("getarea/" + date + "/" + time, function (res) {
                $("#all_area").html(res);
            })
        }
    }
</script>


<div id="myModal" class="modal">

    <div class="modal-content">
        <span id="span1" class="close">×</span>

        <div class="row">
            <div class="col-md-12">
                <div class="menu_open">Menu</div>
            </div>

            <div class="col-md-6" style="padding:0 5px;">

                <div class="col-md-12">

                    <div class="menu_heading">
                        Welcome Drinks, Starter & Accompaniments
                    </div>

                    <ul class="features2" style="list-style:none; padding:0;">
                        <li> Welcome Drinks <strong> - 2</strong></li>

                        <li> Veg Starter <strong> - 1</strong></li>
                        <li> Non-Veg Starter (Chicken with bone-1, Prawn-1) <strong> - 2</strong></li>

                        <li> Soup (Veg/Non-Veg)<strong> - 2</strong></li>
                        <li> Salads(Veg)<strong> - 1</strong></li>
                        <li> Accompaniments (Curd/Raita/Papad)<strong> - 1</strong></li>
                    </ul>


                </div>

            </div>
            <div class="col-md-6" style="padding:0 5px;">
                <div class="col-md-12">
                    <div class="menu_heading"> Main Course
                    </div>

                    <ul class="features2" style="list-style:none; padding:0;">
                        <li> Rice <strong> - 1</strong></li>
                        <li> Pulses <strong> - 1</strong></li>
                        <li> Indian Breads <strong> - 1</strong></li>
                        <li> Paneer / Mushroom <strong> - 1</strong></li>
                        <li> Seasonal Vegetables(Indian)<strong> - 1</strong></li>
                        <li> Mutton <strong> - 1</strong></li>
                        <li> Fish (Rohu)<strong> - 1</strong></li>
                        <li> Desserts,(Indian dessert)<strong> - 2</strong></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $(".hidden").click(function () {
            $("p").toggle();
        });
        //-----------------
        $("#hide").hide();
        $(".slide-toggle").click(function () {
            $(".box").animate({
                width: "toggle"
            });
            noScroll();
        });
        //---------------------------
        $("#hide2").hide();
        $(".slide-toggle2").click(function () {
            $(".box2").animate({
                width: "toggle"
            });
            noScroll();
        });

        //------------------------------------
    });

    function noScroll() {
        window.scrollTo(0, 0);
    }


    $(window).scroll(function () {

        if ($(this).scrollTop() > 0) {
            $('.box').fadeOut();
        } else {

        }

        if ($(this).scrollTop() > 0) {
            $('.box2').fadeOut();
        } else {

        }
    });


    var modal = document.getElementById('myModal');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var my_btn = document.getElementById('my_btn');

    var span = document.getElementById("span1");
    my_btn.onclick = function () {
        modal.style.display = 'block';
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {

        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";

        }
    }


</script>

<link rel="stylesheet" href="/assets/js/calender/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="/assets/js/calender/script.js"></script>
</html>
