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
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#dashboard" aria-expanded="false" aria-controls="dashboard">
               <span><i class="material-icons fs-16">dashboard</i>Dashboard </span>
               </a>
               <ul id="dashboard" class="collapse" aria-labelledby="dashboard" data-parent="#side-nav-accordion">
                  <li> <a href="{{route('manager.index')}}" class="manager">Manager</a> </li>
                  <li> <a href="#">Accountant</a> </li>
               </ul>
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
                  <li class="menu-item">
                     <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Applications" aria-expanded="false" aria-controls="authentication">Applications</a>
                     <ul id="Applications" class="collapse" aria-labelledby="authentication" data-parent="#MemberResidents">

                        <li> <a href="{{route('application.index')}}" class="application">Background Checks</a> </li>
                        <li> <a href="#">ESESTOPPEL letter</a> </li>
                     </ul>
                  </li>
{{--                  <li> <a href="#">Termination</a> </li>--}}






                   @if($setting['is_pat_allowd']=="1")
                   <li class="menu-item">
                       <a href="#" class="has-chevron" data-toggle="collapse" data-target="#pets" aria-expanded="false" aria-controls="authentication">Pets</a>
                       <ul id="pets" class="collapse" aria-labelledby="authentication" data-parent="#MemberResidents">

                           <li> <a href="{{route('pettype.index')}}" class="pettype">Pet Type</a> </li>
                           <li> <a href="{{route('pet.index')}}" class="pet">Pets</a> </li>
                           <li> <a href="{{route('pet-setting')}}" class="pet-setting">Setting</a> </li>
                       </ul>
                   </li>
                   @endif
{{--                  <li class="menu-item">--}}
{{--                     <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Settings" aria-expanded="false" aria-controls="authentication">Settings</a>--}}
{{--                     <ul id="Settings" class="collapse" aria-labelledby="authentication" data-parent="#MemberResidents">--}}
{{--                        <li> <a href="#">Guest Limitation</a> </li>--}}
{{--                        <li> <a href="#">Residents Credit/records requirements</a> </li>--}}
{{--                        <li> <a href="#">Pets Requirements</a> </li>--}}
{{--                     </ul>--}}
{{--                  </li>--}}





               </ul>
            </li>
            <!-- /Member/ Residents/Guests -->

{{--            <!-- Board of Directors -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#board_of_directors" aria-expanded="false" aria-controls="patient">--}}
{{--               <span><i class="fas fa-window-maximize"></i>Board of Directors</span>--}}
{{--               </a>--}}
{{--               <ul id="board_of_directors" class="collapse" aria-labelledby="patient" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Directors List</a> </li>--}}
{{--                  <li> <a href="#">Signatures</a> </li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Board of Directors -->--}}
{{--            <!-- Office Appointments -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#OfficeAppointments" aria-expanded="false" aria-controls="department">--}}
{{--               <span><i class="fas fa-check-circle"></i>Office Appointments</span>--}}
{{--               </a>--}}
{{--               <ul id="OfficeAppointments" class="collapse" aria-labelledby="department" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Calendar</a> </li>--}}
{{--                  <li> <a href="#">Appointments </a> </li>--}}
{{--                  <li> <a href="#">Set Appointments Window</a> </li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Office Appointments -->--}}
{{--            <!-- Renovation and Moving -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#RenovationandMoving" aria-expanded="false" aria-controls="schedule">--}}
{{--               <span><i class="fas fa-share-square"></i>Renovation and Moving</span>--}}
{{--               </a>--}}
{{--               <ul id="RenovationandMoving" class="collapse" aria-labelledby="schedule" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Renovation Application</a> </li>--}}
{{--                  <li> <a href="#">Elevator pass</a> </li>--}}
{{--                  <li> <a href="#">Pending</a> </li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Renovation and Moving -->--}}
{{--            <!-- Filing Cabinet (Google Drive?) -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FilingCabinet" aria-expanded="false" aria-controls="appointment">--}}
{{--               <span><i class="far fa-hdd"></i>Filing Cabinet (Google Drive?)</span>--}}
{{--               </a>--}}
{{--               <ul id="FilingCabinet" class="collapse" aria-labelledby="appointment" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Filing Categories</a> </li>--}}
{{--                  <li> <a href="#">Files</a> </li>--}}
{{--                  <li> <a href="#">Search</a> </li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Filing Cabinet (Google Drive?) -->--}}
{{--            <!-- Access Control -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#AccessControl" aria-expanded="false" aria-controls="payment">--}}
{{--               <span><i class="fas fa-thumbs-up"></i>Access Control</span>--}}
{{--               </a>--}}
{{--               <ul id="AccessControl" class="collapse" aria-labelledby="payment" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">RFID Station</a> </li>--}}
{{--                  <li> <a href="#">Access Groups and Sub Groups</a> </li>--}}
{{--                  <li> <a href="#">Door Locks</a> </li>--}}
{{--                  <li> <a href="#">Intercoms</a> </li>--}}
{{--                  <li> <a href="#">Chips/phones</a> </li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Access Control -->--}}
            <!-- Digital Signage -->

                <li class="menu-item">
                    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Communications" aria-expanded="false" aria-controls="report">
                        <span><i class="fas fa-envelope"></i>Communications</span>
                    </a>
                    <ul id="Communications" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                        <li> <a href="/bulk-communication" class="bulk-communication" >Emails</a> </li>
                        <li> <a href="{{ route('letter.generator') }}" class="letter-generator">Letter</a> </li>
                        <li> <a href="{{route('template.index')}}" class="template">Template</a> </li>
                    </ul>
                </li>


            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#DigitalSignage" aria-expanded="false" aria-controls="report">
               <span><i class="fas fa-laptop"></i>Digital Signage</span>
               </a>
               <ul id="DigitalSignage" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                  <li> <a href="{{route('digital-signage-group.index')}}"  class="digital-signage-group">Info Group</a> </li>
{{--                  <li> <a href="#">Signs</a></li>--}}
               </ul>
            </li>
            <!-- /Digital Signage -->

{{--            <!-- Front Desk -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#front-desk" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-laptop"></i>Front Desk</span>--}}
{{--               </a>--}}
{{--               <ul id="front-desk" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Guest Log Book</a> </li>--}}
{{--                  <li> <a href="#">Delivery Log Book</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Front Desk -->--}}
{{--            <!-- Contractors/Vendors -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Contractors" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="far fa-handshake"></i>Contractors/Vendors</span>--}}
{{--               </a>--}}
{{--               <ul id="Contractors" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Companies</a> </li>--}}
{{--                  <li> <a href="#">Employees</a></li>--}}
{{--                  <li> <a href="#">Daily Log</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Contractors/Vendors -->--}}
{{--            <!-- Employees -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Employees" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-users"></i>Employees</span>--}}
{{--               </a>--}}
{{--               <ul id="Employees" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Employees</a> </li>--}}
{{--                  <li> <a href="#">Time Clock</a></li>--}}
{{--                  <li> <a href="#">Work Schedule</a></li>--}}
{{--                  <li> <a href="#">Payroll</a></li>--}}
{{--                  <li> <a href="#">To Do List</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Employees -->--}}
{{--            <!-- Building Monitoring -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#BuildingMonitoring" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-building"></i>Building Monitoring</span>--}}
{{--               </a>--}}
{{--               <ul id="BuildingMonitoring" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">All Info</a> </li>--}}
{{--                  <li> <a href="#">Water Detectors</a></li>--}}
{{--                  <li> <a href="#">AC Thermostats</a></li>--}}
{{--                  <li> <a href="#">Error Log</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Building Monitoring -->--}}
{{--            <!-- Facilities Rental -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FacilitiesRental" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-tasks"></i>Facilities Rental</span>--}}
{{--               </a>--}}
{{--               <ul id="FacilitiesRental" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Facilities</a></li>--}}
{{--                  <li> <a href="#">Calendar </a></li>--}}
{{--                  <li> <a href="#">New rental</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Facilities Rental -->--}}

{{--            <!-- BOD Meetings -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#BODMeetings" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-users"></i>BOD Meetings</span>--}}
{{--               </a>--}}
{{--               <ul id="BODMeetings" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Meetings</a></li>--}}
{{--                  <li> <a href="#">Minutes & Notices </a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /BOD Meetings -->--}}
{{--            <!-- Concierge -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Concierge" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-headphones"></i>Concierge</span>--}}
{{--               </a>--}}
{{--               <ul id="Concierge" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Request List</a></li>--}}
{{--                  <li> <a href="#">Complaints </a></li>--}}
{{--                  <li> <a href="#">Reports</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Concierge -->--}}
{{--            <!-- Community Calendar -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#CommunityCalendar" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-calendar"></i>Community Calendar</span>--}}
{{--               </a>--}}
{{--               <ul id="CommunityCalendar" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Calendar</a></li>--}}
{{--                  <li> <a href="#">Reoccurring Events</a></li>--}}
{{--                  <li> <a href="#">Manually enter events</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Community Calendar -->--}}

            <!-- Fines and Violations -->
            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FinesAndViolations" aria-expanded="false" aria-controls="report">
               <span><i class="material-icons fs-16">assignment_late</i>Fines and Violations</span>
               </a>
               <ul id="FinesAndViolations" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
{{--                  <li> <a href="#">Violations</a></li>--}}
                  <li> <a href="{{ route('fines.index') }}" class="fines">Fines</a></li>
{{--                  <li> <a href="#">New Violation</a></li>--}}
                  <li> <a href="{{route('fine-setting')}}" class="fine-setting">Setting</a></li>
               </ul>
            </li>
            <!-- /Fines and Violations -->

            <!-- Incidents -->
            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Incidents" aria-expanded="false" aria-controls="report">
               <span><i class="fas fa-exclamation-triangle"></i>Incidents</span>
               </a>
               <ul id="Incidents" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                  <li> <a href="{{ route('incident.index') }}" class="incident">Incidents Log</a></li>
               </ul>
            </li>
                <li class="menu-item">
                    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#FacilitiesRental" aria-expanded="false" aria-controls="report">
                        <span><i class="fas fa-building"></i>Facilities Rental</span>
                    </a>
                    <ul id="FacilitiesRental" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">
                        <li> <a href="#" class="incident">Dashbaord</a></li>
                        <li> <a href="{{ route('facilities-rental') }}" class="facilities-rental rent-the-facilities facilities-rental-event record-a-note edit_rent paymentinfo facilities-status">Facilities</a></li>
                        <li> <a href="#" class="incident">Reports</a></li>
                        <li> <a href="{{ route('rentfacilities') }}" class="rentfacilities rent-a-facilities checkavailability">Rent the Facility</a></li>
                    </ul>
                </li>



            <!-- /Incidents -->


{{--            <!-- Security -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Security" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-lock"></i>Security</span>--}}
{{--               </a>--}}
{{--               <ul id="Security" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Incidents</a></li>--}}
{{--                  <li> <a href="#">CCTV DVRs </a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Security -->--}}

{{--            <!-- Elections -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Elections" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-university"></i>Elections</span>--}}
{{--               </a>--}}
{{--               <ul id="Elections" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Elections</a></li>--}}
{{--                  <li> <a href="#">Reports</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Elections -->--}}

{{--            <!-- Sales -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Sales" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-clipboard"></i>Sales</span>--}}
{{--               </a>--}}
{{--               <ul id="Sales" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Sales</a></li>--}}
{{--                  <li> <a href="#">Sale Items</a></li>--}}
{{--                  <li> <a href="#">Record Sale in Person</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Sales -->--}}

{{--            <!-- Budget -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Budget" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa-signal"></i>Budget</span>--}}
{{--               </a>--}}
{{--               <ul id="Budget" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Master items</a></li>--}}
{{--                  <li> <a href="#">Sub Items </a></li>--}}
{{--                  <li> <a href="#">Budgets</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Budget -->--}}

{{--            <!-- Accounting -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Accounting" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="material-icons fs-16">account_balance</i>Accounting</span>--}}
{{--               </a>--}}
{{--               <ul id="Accounting" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Vendors</a></li>--}}
{{--                  <li> <a href="#">Work Orders</a></li>--}}
{{--                  <li> <a href="#">Transactions</a></li>--}}
{{--                  <li> <a href="#">Reoccurring Billing</a></li>--}}
{{--                  <li> <a href="#">Automatic Payments</a></li>--}}
{{--                  <li> <a href="#">Record payments</a></li>--}}
{{--                  <li> <a href="#">Record Bills</a></li>--}}
{{--                  <li> <a href="#">Write Checks </a></li>--}}
{{--                  <li> <a href="#">Automated Notification</a></li>--}}
{{--                  <li> <a href="#">Debt Collection</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Accounting -->--}}

{{--            <!-- Accounting Reports  -->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#AccountingReports" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="material-icons fs-16">assignment</i>Accounting Reports</span>--}}
{{--               </a>--}}
{{--               <ul id="AccountingReports" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Property Transaction/Balance Report</a></li>--}}
{{--                  <li> <a href="#">Expense Report</a></li>--}}
{{--                  <li> <a href="#">Income Report</a></li>--}}
{{--                  <li> <a href="#">Budget Report</a></li>--}}
{{--                  <li> <a href="#">Delinquency Report</a></li>--}}
{{--                  <li> <a href="#">Automatic Reports Share</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Accounting Reports  -->--}}

{{--            <!-- Supply and Inventory-->--}}
{{--            <li class="menu-item">--}}
{{--               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#SupplyandInventory" aria-expanded="false" aria-controls="report">--}}
{{--               <span><i class="fas fa fa-user-circle"></i>Supply and Inventory</span>--}}
{{--               </a>--}}
{{--               <ul id="SupplyandInventory" class="collapse" aria-labelledby="report" data-parent="#side-nav-accordion">--}}
{{--                  <li> <a href="#">Inventory Types</a></li>--}}
{{--                  <li> <a href="#">Inventory List</a></li>--}}
{{--                  <li> <a href="#">Use of Items</a></li>--}}
{{--               </ul>--}}
{{--            </li>--}}
{{--            <!-- /Supply and Inventory -->--}}

            <!-- Settings -->
            <li class="menu-item">
               <a href="#" class="has-chevron" data-toggle="collapse" data-target="#SettingsLast" aria-expanded="false" aria-controls="pages">
               <span><i class="fas fa-wrench"></i>Settings</span>
               </a>
               <ul id="SettingsLast" class="collapse" aria-labelledby="pages" data-parent="#side-nav-accordion">
                   <li class="menu-item">
                       <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Condominium" aria-expanded="false" aria-controls="authentication">Condominium</a>
                       <ul id="Condominium" class="collapse" aria-labelledby="pages" data-parent="#SettingsLast">
                           <li> <a href="{{ route('property_setting') }}" class="property-setting">Setting</a> </li>
                           <li> <a href="{{ route('master-association.index') }}" class="master-association">Master Association</a> </li>
                           @if($setting['is_subassociations']=="1")
                           <li> <a href="{{ route('sub-association.index') }}" class="sub-association">Sub Associations</a> </li>
                           @endif
                           <li> <a href="{{ route('properties.index') }}" class="properties ">Properties</a> </li>
                           <li> <a href="{{ route('buildings.index') }}" class="buildings">Buildings</a> </li>
                           <li> <a href="{{ route('payment-bracket.index') }}" class="payment-bracket">Payment Bracket</a> </li>
                           <li> <a href="{{ route('property-type.index') }}" class="property-type">Property Type</a></li>
                           <li> <a href="{{ route('owner.index') }}" class="owner">Owners</a></li>
                           <li> <a href="{{ route('resident.index') }}" class="resident">Residents</a></li>
                       </ul>
                   </li>

                  <li> <a href="{{route('application_setting')}}" class="application-setting">Application</a> </li>
                  <li> <a href="#">Associationse</a> </li>
                  <li> <a href="#">Management</a> </li>
                   <li class="menu-item">
                       <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Facilities" aria-expanded="false" aria-controls="authentication">Facilities</a>
                       <ul id="Facilities" class="collapse" aria-labelledby="authentication" data-parent="#SettingsLast">
                           <li> <a href="{{ route('facilities.index')}}" class="facilities record-note facilities-event rent-facilities payment-info facilities-suspend edit_the_rent">Facilities</a> </li>
                           <li> <a href="{{ route('facilities-type.index')}}" class="facilities-type">Facilities Type</a> </li>
                       </ul>
                   </li>


                  <li class="menu-item">
                     <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Apps2" aria-expanded="false" aria-controls="authentication">Apps</a>
                     <ul id="Apps2" class="collapse" aria-labelledby="authentication" data-parent="#SettingsLast">
                        <li> <a href="#">End User</a> </li>
                        <li> <a href="#">Security</a> </li>
                        <li> <a href="#">Front Desk</a> </li>
                     </ul>
                  </li>
                  <li> <a href="#">System Maintenance</a> </li>
                  <li> <a href="#">Error Log</a> </li>

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
               <a href="#mymodal" class="text-white" data-toggle="modal"><i class="flaticon-spreadsheet mr-2"></i> Work Order</a>
             </li>

             <li class="ms-nav-item ms-d-none">
               <a href="#prescription" class="text-white" data-toggle="modal"><i class="flaticon-pencil mr-2"></i> Access Card</a>
             </li>

             <li class="ms-nav-item ms-d-none">
               <a href="#report1" class="text-white" data-toggle="modal"><i class="flaticon-list mr-2"></i> Make Appointment</a>
             </li>

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
