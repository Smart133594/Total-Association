<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
         <!-- Logo -->
         <div class="logo-sn ms-d-block-lg">
            <a class="pl-0 ml-0 text-center" href="#"> <img src="/assets/img/TAS-Logo.png" alt="logo"> </a>
            <h5 class="text-center text-white mt-2">Dr.Samuel</h5>
            <h6 class="text-center text-white mb-3">Admin</h6>
         </div>
         <!-- Navigation -->
         <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
             @if(Auth::user()->role==1)
            <!-- Dashboard -->
            <li class="menu-item">
               <a href="{{route('manager.index')}}" >
               <span><i class="material-icons fs-16">dashboard</i>Dashboard </span>
               </a>
            </li>
            <!-- /Dashboard -->

            <!-- Member/ Residents/Guests -->
            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#MemberResidents" aria-expanded="false" aria-controls="pages">
               <span><i class="fas fa-id-badge"></i>Properties and Residents</span>
               </a>
               <ul id="MemberResidents" class="collapse" aria-labelledby="pages" data-parent="#side-nav-accordion">
                  <li> <a href="/owner-properties" class="owner-properties showproperties">Properties</a> </li>
                  <li> <a href="/member-owner" class="member-owner">Owners</a> </li>
                  <li> <a href="/member-resident"  class="member-resident">Residents</a> </li>
                  <li> <a href="{{route('guest.index')}}"  class="guest">Guests</a> </li>
                  <li> <a href="{{route('pet.index')}}" class="pet">Pets</a> </li>
               </ul>
            </li>
            <li class="menu-item">
              <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Applications" aria-expanded="false" aria-controls="report">
                <span><i class="fas fa-id-badge"></i>Applications</span>
                </a>
                <ul id="Applications" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                  <li> <a href="{{route('application.index')}}" class="application">Background Checks</a> </li>
                  <li> <a href="#">ESESTOPPEL letter</a> </li>
                </ul>
           </li>
              <li class="menu-item">
                  <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Communications" aria-expanded="false" aria-controls="report">
                      <span><i class="fas fa-envelope"></i>Communications</span>
                  </a>
                  <ul id="Communications" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                      <li> <a href="/bulk-communication" class="bulk-communication" >Emails</a> </li>
                      <li> <a href="{{ route('letter.generator') }}" class="letter-generator">Letters</a> </li>
                      <li> <a href="{{route('template.index')}}" class="template">Templates</a> </li>
                  </ul>
              </li>


            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#DigitalSignage" aria-expanded="false" aria-controls="report">
               <span><i class="fas fa-laptop"></i>Digital Signage</span>
               </a>
               <ul id="DigitalSignage" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                  <li> <a href="{{route('digital-signage-group.index')}}"  class="digital-signage-group">Groups</a> </li>
               </ul>
            </li>
            <li class="menu-item">
              <a href="#" class="has-chevron" data-toggle="collapse" data-target="#employers" aria-expanded="false" aria-controls="report">
              <span><i class="fas fa-laptop"></i>Employers</span>
              </a>
              <ul id="employers" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                 <li> <a href="{{route('work-force.index')}}"  class="work-force">Work Force</a> </li>
                 <li> <a href="{{route('punch-clock.index')}}"  class="punch-clock ">Punch Clock </a> </li>
                 <li> <a href="{{route('department.index')}}"  class="department">To Do List (Per Department)</a> </li>
                 <li> <a href="{{route('work-log.index')}}"  class="work-log">Work Log</a> </li>
              </ul>
            </li>
            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FinesAndViolations" aria-expanded="false" aria-controls="report">
               <span><i class="material-icons fs-16">assignment_late</i>Fines and Violations</span>
               </a>
               <ul id="FinesAndViolations" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                  <li> <a href="{{ route('incident.index') }}" class="incident">Incidents Log</a></li>
                  <li> <a href="{{ route('fines.index') }}" class="fines">Fines</a></li>
               </ul>
            </li>
                <li class="menu-item">
                    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FacilitiesRental" aria-expanded="false" aria-controls="report">
                        <span><i class="fas fa-building"></i>Facilities Rental</span>
                    </a>
                    <ul id="FacilitiesRental" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                        <li> <a href="#" class="facilities-rental-dashboard">Dashbaord</a></li>
                        <li> <a href="{{ route('facilities-rental') }}" class="facilities-rental rent-facilities facilities-rental-event record-note edit_rent paymentinfo facilities-status">Facilities</a></li>
                        <li> <a href="{{ route('rentfacilities') }}" class="rentfacilities rent-a-facilities checkavailability">Rent the Facility</a></li>
                    </ul>
                </li>

            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#SettingsLast" aria-expanded="false" aria-controls="pages">
               <span><i class="fas fa-wrench"></i>Settings</span>
               </a>
               <ul id="SettingsLast" class="collapse" aria-labelledby="pages" data-parent="#side-nav-accordion">
                   <li class="menu-item">
                       <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Condominium" aria-expanded="false" aria-controls="authentication">Condominium</a>
                       <ul id="Condominium" class="collapse" aria-labelledby="pages" data-parent="#SettingsLast">
                           {{-- <li> <a href="{{ route('property_setting') }}" class="property-setting">Setting</a> </li> --}}
                           <li> <a href="{{ route('master-association.index') }}" class="master-association">Master Association</a> </li>
                           @if($setting['is_subassociations']=="1")
                           <li> <a href="{{ route('sub-association.index') }}" class="sub-association">Sub Associations</a> </li>
                           @endif
                           <li> <a href="{{ route('buildings.index') }}" class="buildings">Buildings</a> </li>
                           <li> <a href="{{ route('payment-bracket.index') }}" class="payment-bracket">Payment Bracket</a> </li>
                           <li> <a href="{{ route('property-type.index') }}" class="property-type">Property Type</a></li>
                           <li> <a href="{{ route('properties.index') }}" class="properties ">Properties</a> </li>
                           <li> <a href="{{ route('owner.index') }}" class="owner">Owners</a></li>
                           <li> <a href="{{ route('resident.index') }}" class="resident">Residents</a></li>
                       </ul>
                   </li>

                  <li> <a href="{{route('application_setting')}}" class="application-setting">Application</a> </li>
                  <li class="menu-item">
                    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Facilities" aria-expanded="false" aria-controls="authentication">Facilities</a>
                    <ul id="Facilities" class="collapse" aria-labelledby="authentication" data-parent="#SettingsLast">
                        <li> <a href="{{ route('facilities.index')}}" class="facilities record-note facilities-rental-event rent-facilities paymentinfo facilities-status edit_the_rent">Facilities</a> </li>
                        <li> <a href="{{ route('facilities-type.index')}}" class="facilities-type">Facilities Type</a> </li>
                    </ul>
                  </li>
                  @if($setting['is_pat_allowd']=="1")
                    <li class="menu-item">
                        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#pets" aria-expanded="false" aria-controls="authentication">Pets</a>
                        <ul id="pets" class="collapse" aria-labelledby="authentication" data-parent="#MemberResidents">
                            <li> <a href="{{route('pettype.index')}}" class="pettype">Pet Type</a> </li>
                            <li> <a href="{{route('pet-setting')}}" class="pet-setting">Setting</a> </li>
                        </ul>
                    </li>
                  @endif
                  <li> <a href="{{route('fine-setting')}}" class="fine-setting">Fine</a></li>
                </ul>
            </li>



            @endif

                 @if(Auth::user()->role==4)

                     <!-- Security -->
                         <li class="menu-item">
                             <a href="#" class="has-chevron" data-toggle="collapse" data-target="#digital-signage" aria-expanded="false" aria-controls="report">
                                 <span><i class="fas fa-tv"></i>Digital Signage</span>
                             </a>
                             <ul id="digital-signage" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                                 <li><a href="{{route('digital-signage-group.index')}}">Group</a></li>
                             </ul>
                         </li>
                         <!-- /Security -->
                     @endif
            <!-- /Settings -->
         </ul>
      </aside>
      <!-- Sidebar Right -->
<!-- Main Content -->
      <main class="body-content">
         <!-- Navigation Bar -->
         <nav class="navbar ms-navbar">
           <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
             <span class="ms-toggler-bar bg-white"></span>
             <span class="ms-toggler-bar bg-white"></span>
             <span class="ms-toggler-bar bg-white"></span>
           </div>
           <div class="logo-sn logo-sm ms-d-block-sm">
             <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="index-2.html"><img src="/assets/img/medboard-logo-84x41.png" alt="logo"> </a>
           </div>
           <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
              <li class="ms-nav-item  ms-d-none">
                <ul class="ms-list d-flex m-0 p-0">
                  <li class="ms-list-item m-0 p-0">
                    <span style="font-size: 18px; color:#fff">Sub-Associations &nbsp;&nbsp;</span>
                  </li>
                  <li class="ms-list-item m-0 p-0">
                    <label class="ms-switch" style="margin-top: -10px">
                      <input type="checkbox" id="sub_associations" @if($setting['is_subassociations'] == "1") checked @endif>
                      <span class="ms-switch-slider round"></span>
                    </label>
                  </li>
                </ul>
              </li>
              {{-- <li class="ms-nav-item ms-d-none">
               <a href="#mymodal" class="text-white" data-toggle="modal"><i class="flaticon-spreadsheet mr-2"></i> Work Order</a>
              </li>
              <li class="ms-nav-item ms-d-none">
               <a href="#prescription" class="text-white" data-toggle="modal"><i class="flaticon-pencil mr-2"></i> Access Card</a>
             </li>

             <li class="ms-nav-item ms-d-none">
               <a href="#report1" class="text-white" data-toggle="modal"><i class="flaticon-list mr-2"></i> Make Appointment</a>
             </li> --}}

             <li class="ms-nav-item dropdown">
               <a href="#" class="text-disabled ms-has-notification" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-bell"></i></a>
               <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                 <li class="dropdown-menu-header">
                   <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Notifications</span></h6>
                   <span class="badge badge-pill badge-info">4 New</span>
                 </li>
                 <li class="dropdown-divider"></li>
                 <li class="ms-scrollable ms-dropdown-list">
                   <a class="media p-2" href="#">
                     <div class="media-body">
                       <span>12 ways to improve your crypto dashboard</span>
                       <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 30 seconds ago</p>
                     </div>
                   </a>
                   <a class="media p-2" href="#">
                     <div class="media-body">
                       <span>You have newly registered users</span>
                       <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 45 minutes ago</p>
                     </div>
                   </a>
                   <a class="media p-2" href="#">
                     <div class="media-body">
                       <span>Your account was logged in from an unauthorized IP</span>
                       <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 2 hours ago</p>
                     </div>
                   </a>
                   <a class="media p-2" href="#">
                     <div class="media-body">
                       <span>An application form has been submitted</span>
                       <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 1 day ago</p>
                     </div>
                   </a>
                 </li>
                 <li class="dropdown-divider"></li>
                 <li class="dropdown-menu-footer text-center">
                   <a href="#">View all Notifications</a>
                 </li>
               </ul>
             </li>
             <li class="ms-nav-item ms-nav-user dropdown">
               <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img class="ms-user-img ms-img-round float-right" src="/assets/img/dashboard/doctor-3.jpg" alt="people"> </a>
               <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
                 <li class="dropdown-menu-header">
                   <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Welcome, Dr Samuel Deo</span></h6>
                 </li>
                 <li class="dropdown-divider"></li>
                 <li class="ms-dropdown-list">
                   <a class="media fs-14 p-2" href="#"> <span><i class="flaticon-user mr-2"></i> Profile</span> </a>
                   <a class="media fs-14 p-2" href="#"> <span><i class="flaticon-mail mr-2"></i> Inbox</span> <span class="badge badge-pill badge-info">3</span> </a>
                   <a class="media fs-14 p-2" href="#"> <span><i class="flaticon-gear mr-2"></i> Account Settings</span> </a>
                 </li>
                 <li class="dropdown-divider"></li>

                 <li class="dropdown-menu-footer">
                   <a class="media fs-14 p-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <span><i class="flaticon-shut-down mr-2"></i> Logout</span> </a>
                 </li>

				 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
					</form>
               </ul>
             </li>
           </ul>
           <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
             <span class="ms-toggler-bar bg-white"></span>
             <span class="ms-toggler-bar bg-white"></span>
             <span class="ms-toggler-bar bg-white"></span>
           </div>
         </nav>

  <script>
    $("#sub_associations").on("change", e=> {
      const is_subassociations = e.target.checked ? 1 : 0;
    var formData = new FormData();
    formData.append('is_subassociations', is_subassociations);
    formData.append('_token', "{{csrf_token()}}");
    $.ajax({
        url: "{{ route('save-setting') }}",
        type: 'POST',
        data: formData,
        processData: false, 
        contentType: false, 
        complete: function () {
          location.reload();
        }
    });
    })
  </script>