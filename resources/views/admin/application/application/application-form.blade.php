<!DOCTYPE html>
<html lang="en">
<head>
    <title>Applicant Information</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<style>

    .total {
        width: 100%;
        display: flex;
        background: #f8f9fa;
    }

    .contact_form {
        width: 50%;
        padding: 30px 15px;
        background: #fff;
    }

    .contact_form_left {
        width: 25%;
    }

    .contact_form label {
    }

    .contact_form .form-control {
        border-radius: 0;
        outline: 0px;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #ced4da;
        outline: 0;
        box-shadow: 0 0 0 0.0rem rgb(0 123 255 / 25%);
    }

    .bg_color {
        background: #f8f9fa;
        width: 100%;
        height: 120px;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bg_color:before {
        content: "";
        background-image: url('/assets/img/bg_img.png');
        position: absolute;
        z-index: 9;
        width: 48%;
        height: 120px;
        background-size: cover;
        overflow: hidden;
        background-repeat: no-repeat;
    }

    .bg_color img {
        width: 105px;
        height: auto;
    }

    .btn-success {
        margin-top: 10px
    }

    @media only screen and (max-width: 480px) {

        .contact_form {
            width: 100%;
            padding: 0;
        }

        .contact_form_left {
            width: 0%;
        }

        .bg_color:before {
            width: 100%;
        }


    }

</style>


<div class="total">
    <div class="contact_form_left"></div>
    @if($expire==0)
    <div class="contact_form">
        <div class="container">
            <div class="bg_color">
                <img src="/assets/img/logo.png" alt="logo">
            </div>


            <h4>Contact Form</h4>
            <form action="{{route('application-store')}}" method="post" id="admin-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Application Type <span>*</span></label>
                    <select class="form-control" id="exampleFormControlSelect1" name="applicationType" required>
                        <option value="">--choose--</option>
                        <option value="Buyer" @if($data->applicationType=="Buyer") selected @endif>Buyer</option>
                        <option value="Renter" @if($data->applicationType=="Renter") selected @endif>Renter</option>
                        <option value="Family Member" @if($data->applicationType=="Family Member") selected @endif>Family Member</option>
                        <option value="Room Mate" @if($data->applicationType=="Room Mate") selected @endif>Room Mate</option>
                    </select>
                </div>

                <div class="form_section">
                    <h5>Information</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="address">First Name <span>*</span></label>
                            <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" value="{{$data->firstName}}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" placeholder="Middle Name" name="middleName" value="{{$data->middleName}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address">Last Name <span>*</span></label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName" value="{{$data->lastName}}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Phone Number <span>*</span></label>
                            <input type="text" class="form-control" id="phoneNo" placeholder="Phone Number" name="phoneNo" value="{{$data->phoneNo}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Email Address <span>*</span></label>
                            <input type="email" class="form-control" id="email" placeholder="Email Address" name="email" value="{{$data->email}}" required>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleEmail">Address Line 1</label>
                                <input type="text" class="form-control" id="address1" name="address1" value="@if($data ?? ''){{$data->address1}}@endif" required >
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleEmail">Address Line 2</label>
                                <input type="text" class="form-control" id="address2" name="address2" value="@if($data ?? ''){{$data->address2}}@endif" required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="examplePassword">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="@if($data ?? ''){{$data->city}}@endif" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="examplePassword">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="@if($data ?? ''){{$data->state}}@endif" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="examplePassword">Country</label>
                                <input type="text" class="form-control" id="country" name="country"value=" @if($data ?? ''){{$data->country}}@endif" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="examplePassword">Zip</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="@if($data ?? ''){{$data->pincode}}@endif" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Social Security Number <span>*</span></label>
                            <input type="text" class="form-control" id="socialSecurityNo" placeholder="Social Security Number" name="socialSecurityNo" value="{{$data->socialSecurityNo}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Driving License Number <span>*</span></label>
                            <input type="text" class="form-control" id="drivingLicenseNo" placeholder="Driving License Number" name="drivingLicenseNo" value="{{$data->drivingLicenseNo}}" required>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Place Of Work <span>*</span></label>
                            <input type="text" class="form-control" id="placeOfWork" placeholder="Place Of Work" name="placeOfWork" value="{{$data->placeOfWork}}" required>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="address">Current Income <span>*</span></label>
                            <input type="text" class="form-control" id="currentIncome" placeholder="Current Income" name="currentIncome" value="{{$data->currentIncome}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Driving License Image @if(empty($data->drivingLicenseImage))<span>*</span> @endif</label><br>
                            <input type="file" id="drivingLicenseImage" name="drivingLicenseImage" @if(empty($data->drivingLicenseImage)) required @endif>
                            @if(!empty($data->drivingLicenseImage)) <a href="/upload/{{$data->drivingLicenseImage}}"  target="_blank">{{$data->drivingLicenseImage}}</a> @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Text Return (PDF)  @if(empty($data->textReturn))<span>*</span>@endif</label><br>
                            <input type="file" id="textReturn" placeholder="Text Return" name="textReturn" @if(empty($data->textReturn)) required @endif>
                            @if(!empty($data->textReturn)) <a href="/upload/{{$data->textReturn}}" target="_blank">{{$data->textReturn}}</a> @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-check-label" for="isAgent">Real Estate ?</label>
                            <input type="checkbox" id="isAgent" name="isAgent" value="1" @if($data ?? '') @if($data->isAgent==1) checked @endif @endif onclick="getagent()">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 agent">
                            <label for="address">Agent First Name</label>
                            <input type="text" class="form-control" id="agentFirstName" placeholder="First Name" name="agentFirstName" value="{{$data->agentFirstName}}">
                        </div>
                        <div class="form-group col-md-4 agent">
                            <label for="address">Agent Middle Name</label>
                            <input type="text" class="form-control" id="agentMiddleName" placeholder="Middle Name" name="agentMiddleName" value="{{$data->agentMiddleName}}">
                        </div>
                        <div class="form-group col-md-4 agent">
                            <label for="address">Agent Last Name</label>
                            <input type="text" class="form-control" id="agentLastName" placeholder="Last Name" name="agentLastName" value="{{$data->agentLastName}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 agent">
                            <label for="address">Agent Phone Number</label>
                            <input type="text" class="form-control" id="agentPhoneNo" placeholder="Phone Number" name="agentPhoneNo" value="{{$data->agentPhoneNo}}">
                        </div>
                        <div class="form-group col-md-6 agent">
                            <label for="address">Agent Email Address</label>
                            <input type="text" class="form-control" id="agentEmailId" placeholder="Email Address" name="agentEmailId" value="{{$data->agentEmailId}}">
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Start Application</button>
            </form>

        </div>

    </div>

    @else
        <center><img src="/assets/img/expirelink.png" style="width:100%"></center>
    @endif
    <div class="contact_form_left"></div>

</div>

<style>.error {
        color: #FF0000
    }
.agent{
    display:none
}
    label span {
        color: #FF0000
    }
</style>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>


<script>
    function getagent(){
        $(".agent").toggle();
    }
    $("#admin-form").validate();
</script>

</body>
</html>

