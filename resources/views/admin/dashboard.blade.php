@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
      <div class="row">
        <!-- Notifications Widgets -->

        <div class="col-xl-3 col-md-6 col-sm-6">
          <a href="#">
            <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
              <div class="ms-card-body media">
                <div class="media-body">
                  <h6>Doctors</h6>
                  <p class="ms-card-change"> 4567</p>
                </div>
              </div>
              <i class="fas fa-stethoscope ms-icon-mr"></i>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
          <a href="#">
            <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
              <div class="ms-card-body media">
                <div class="media-body">
                  <h6>Nurses</h6>
                  <p class="ms-card-change"> 4567</p>
                </div>
              </div>
              <i class="fas fa-user-plus ms-icon-mr"></i>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
          <a href="#">
            <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
              <div class="ms-card-body media">
                <div class="media-body">
                  <h6 class="bold">Patients</h6>
                  <p class="ms-card-change"> 4567</p>
                </div>
              </div>
              <i class="fa fa-wheelchair ms-icon-mr"></i>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
          <a href="#">
            <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
              <div class="ms-card-body media">
                <div class="media-body">
                  <h6 class="bold">Pharmacists</h6>
                  <p class="ms-card-change"> 4567</p>
                </div>
              </div>
              <i class="fas fa-briefcase-medical ms-icon-mr"></i>
            </div>
          </a>
        </div>


        <div class="col-xl-4 col-lg-6 col-md-12">
          <div class="ms-card ms-widget has-graph-full-width ms-infographics-widget">
            <div class="ms-card-body media">
              <div class="media-body">
                <h6 class="bold">Appointments</h6>
                <h3><strong>3,973</strong></h3>
              </div>
            </div>
            <canvas id="line-chart-2"></canvas>
          </div>

          <div class="ms-card ms-widget has-graph-full-width ms-infographics-widget">
            <div class="ms-card-body media">
              <div class="media-body">
                <h6>New Patients</h6>
                <h3><strong>593</strong></h3>
              </div>
            </div>
            <canvas id="line-chart-3"></canvas>
          </div>

          <div class="ms-card ms-widget has-graph-full-width ms-infographics-widget">
            <div class="ms-card-body media">
              <div class="media-body">
                <h6 class="bold">Hospital Earning</h6>
                <h3><strong>3,973</strong></h3>
              </div>
            </div>
            <canvas id="line-chart-4"></canvas>
          </div>

        </div>

        <div class="col-xl-4 col-lg-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-body calendar-wedgit">
              <div id="calendar"></div>
            </div>

          </div>
        </div>

        <div class="col-xl-4 col-md-12">

          <div class="ms-card ms-widget ms-profile-widget ms-card-fh br-0">
            <div class="ms-card-img">
              <img src="/assets/img/portfolio/gallery-4-760x260.jpg" alt="card_img">
            </div>
            <img src="/assets/img/dashboard/doctor-1.jpg" class="ms-img-large ms-img-round ms-user-img" alt="people">
            <div class="ms-card-body">
              <h2>Anny Farisha</h2>
              <span>Doctor</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in arcu turpis. Nunc</p>
              <button type="button" class="btn btn-primary btn-sm" name="button"><i class="material-icons">person_add</i> Assign</button>
              <ul class="ms-profile-stats">
                <li>
                  <h3 class="ms-count">5790</h3>
                  <span>Operations</span>
                </li>
                <li>
                  <h3 class="ms-count">4.8</h3>
                  <span>Medical Rating</span>
                </li>
              </ul>
            </div>
          </div>

        </div>

        <div class="col-xl-6 col-lg-12">
          <div class="ms-panel ms-device-sessions ms-quick-mic">
            <div class="ms-panel-header">
              <h6>Hospital Birth & Death Analytics</h6>
            </div>
            <div class="ms-panel-body">
              <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-4 col-6 ms-device">
                  <i class="material-icons">airline_seat_flat</i>
                  <h4>Birth</h4>
                  <p class="ms-text-primary">45.07%</p>
                  <span class="ms-text-primary">201,434</span>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-6 ms-device">
                  <i class="material-icons">airline_seat_individual_suite</i>
                  <h4>Death</h4>
                  <p class="ms-text-danger">29.05%</p>
                  <span class="ms-text-danger">134,693</span>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-6 ms-device">
                  <i class="material-icons">accessible</i>
                  <h4>Accidents</h4>
                  <p class="ms-text-warning">18.43%</p>
                  <span class="ms-text-warning">81,525</span>
                </div>
              </div>
              <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 45.07%" aria-valuenow="45.07" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 29.05%" aria-valuenow="29.05" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25.48%" aria-valuenow="25.48" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-12">
          <div class="ms-panel">
            <div class="ms-panel-header d-flex justify-content-between">
              <h6>Hospital Staff</h6>
              <div class="ms-slider-arrow">
                <a href="#" class="prev-item">
                  <i class="far fa-caret-square-left"></i>
                </a>
                <a href="#" class="next-item">
                  <i class="far fa-caret-square-right"></i>
                </a>
              </div>
            </div>
            <div class="ms-panel-body p-0 ms-medical-overview-slider">
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-1.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Anny</h5>
                    <span>Doctor</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-2.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Jude</h5>
                    <span>Surgeon</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-3.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Jordan</h5>
                    <span>Doctor</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-4.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Micheal</h5>
                    <span>Nurse</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-2.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Rouge</h5>
                    <span>Doctor</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-1.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Lilly</h5>
                    <span>Surgeon</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-3.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Sameul</h5>
                    <span>Surgeon</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="assets/img/dashboard/doctor-4.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Ricky</h5>
                    <span>Doctor</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-1.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Venus</h5>
                    <span>Doctor</span>
                  </div>
                </a>
              </div>
              <div class="ms-crypto-overview">
                <a href="#" class="ms-profile">
                  <img src="/assets/img/dashboard/doctor-3.jpg" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                  <div class="ms-card-body">
                    <h5>Johan</h5>
                    <span>Nurse</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-6 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Patient Total</h6>
            </div>
            <div class="ms-panel-body">
              <canvas id="line-chart"></canvas>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Patient In</h6>
            </div>
            <div class="ms-panel-body">
              <canvas id="bar-chart-grouped"></canvas>
            </div>
          </div>
        </div>


        <div class="col-xl-8 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Upcoming Appointments</h6>
            </div>
            <div class="ms-panel-body">
              <div class="table-responsive">
                <table class="table table-hover thead-primary">
                  <thead>
                    <tr>
                      <th scope="col">Patient</th>
                      <th scope="col">Doctor</th>
                      <th scope="col">Date</th>
                      <th scope="col">Timing</th>
                      <th scope="col">Contact</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-1.jpg" alt="people"> Bernardo Galaviz </td>
                      <td>Dr. Cristina Groves</td>
                      <td>01 Dec 2020</td>
                      <td>5:00 PM</td>
                      <td>+01-789-654-123</td>
                      <td><label class="ms-switch">
                          <input type="checkbox" checked="">
                          <span class="ms-switch-slider ms-switch-success round"></span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-5.jpg" alt="people"> Jenni </td>
                      <td>Dr. Richard Miles</td>
                      <td>01 Dec 2020</td>
                      <td>8:00 AM</td>
                      <td>+10-654-654-991</td>
                      <td><label class="ms-switch">
                          <input type="checkbox" checked="">
                          <span class="ms-switch-slider ms-switch-success round"></span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-6.jpg" alt="people"> John Doe </td>
                      <td>Dr. Andrew </td>
                      <td>01 Dec 2020</td>
                      <td>10:00 AM</td>
                      <td>+10-709-254-445</td>
                      <td><label class="ms-switch">
                          <input type="checkbox">
                          <span class="ms-switch-slider ms-switch-success round"></span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-8.jpg" alt="people"> Alesdro Guitto </td>
                      <td>Dr. Robert </td>
                      <td>01 Dec 2020</td>
                      <td>2:00 PM</td>
                      <td>+10-102-225-333</td>
                      <td><label class="ms-switch">
                          <input type="checkbox" checked="">
                          <span class="ms-switch-slider ms-switch-success round"></span>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-1.jpg" alt="people"> Richard </td>
                      <td>Dr. Adwerd</td>
                      <td>07 Dec 2020</td>
                      <td>5:00 PM</td>
                      <td>+01-222-111-356</td>
                      <td><label class="ms-switch">
                          <input type="checkbox">
                          <span class="ms-switch-slider ms-switch-success round"></span>
                        </label>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-4 col-md-12">
          <div class="ms-panel ms-panel-fh ms-widget">
            <div class="ms-panel-header ms-panel-custome">
              <h6>Doctors List</h6>
            </div>
            <div class="ms-panel-body p-0">
              <ul class="ms-followers ms-list ms-scrollable">
                <li class="ms-list-item media">
                  <img src="/assets/img/dashboard/doctor-1.jpg" class="ms-img-small ms-img-round" alt="people">
                  <div class="media-body mt-1">
                    <h4>Micheal</h4>
                    <span class="fs-12">MBBS, MD</span>
                  </div>
                  <button type="button" class="ms-btn-icon btn-success" name="button"><i class="material-icons">check</i> </button>
                </li>
                <li class="ms-list-item media">
                  <img src="/assets/img/dashboard/doctor-2.jpg" class="ms-img-small ms-img-round" alt="people">
                  <div class="media-body mt-1">
                    <h4>Jennifer</h4>
                    <span class="fs-12">MD</span>
                  </div>
                  <button type="button" class="ms-btn-icon btn-info" name="button"><i class="material-icons">person_add</i> </button>
                </li>
                <li class="ms-list-item media">
                  <img src="/assets/img/dashboard/doctor-3.jpg" class="ms-img-small ms-img-round" alt="people">
                  <div class="media-body mt-1">
                    <h4>Adwerd </h4>
                    <span class="fs-12">BMBS</span>
                  </div>
                  <button type="button" class="ms-btn-icon btn-info" name="button"><i class="material-icons">person_add</i> </button>
                </li>
                <li class="ms-list-item media">
                  <img src="/assets/img/dashboard/doctor-4.jpg" class="ms-img-small ms-img-round" alt="people">
                  <div class="media-body mt-1">
                    <h4>John Doe</h4>
                    <span class="fs-12">MS, MD</span>
                  </div>
                  <button type="button" class="ms-btn-icon btn-success" name="button"><i class="material-icons">check</i> </button>
                </li>
                <li class="ms-list-item media">
                  <img src="/assets/img/dashboard/doctor-5.jpg" class="ms-img-small ms-img-round" alt="people">
                  <div class="media-body mt-1">
                    <h4>Jordan</h4>
                    <span class="fs-12">MBBS</span>
                  </div>
                  <button type="button" class="ms-btn-icon btn-info" name="button"><i class="material-icons">person_add</i> </button>
                </li>
              </ul>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-lg-12">
          <div class="ms-panel ms-panel-fh ms-facebook-engagements">
            <div class="ms-panel-header">
              <h6>Doctor Engagements</h6>
            </div>
            <div class="ms-panel-body p-0">
              <div class="ms-facebook-page-selection">
                <p class="ms-text-dark">Jan 25, 2020 to Feb 02, 2020</p>
                <p>Jan 18, 2020 to Feb 24, 2020 (Prev)</p>

                <div class="dropdown">
                  <a href="#" class="has-chevron" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Doctor Name here</a>
                  <ul class="dropdown-menu">
                    <li class="ms-dropdown-list">
                      <a class="media p-2" href="#">
                        <div class="media-body">
                          <span>Doctor 1</span>
                        </div>
                      </a>
                      <a class="media p-2" href="#">
                        <div class="media-body">
                          <span>Doctor 2</span>
                        </div>
                      </a>
                      <a class="media p-2" href="#">
                        <div class="media-body">
                          <span>Doctor 3</span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <ul class="ms-list clearfix">
                <li class="ms-list-item">
                  <div class="d-flex justify-content-between align-items-end">
                    <div class="ms-graph-meta">
                      <h2>Weekday Engagement</h2>
                      <p class="ms-text-dark">45.07%</p>
                      <p class="ms-text-success">+28.44%</p>
                      <p>VS 66.68% (Prev)</p>
                    </div>
                    <div class="ms-graph-canvas">
                      <canvas id="engaged-users"></canvas>
                    </div>
                  </div>
                </li>
                <li class="ms-list-item">
                  <div class="d-flex justify-content-between align-items-end">
                    <div class="ms-graph-meta">
                      <h2>Weekend Engagement</h2>
                      <p class="ms-text-dark">45.07%</p>
                      <p class="ms-text-success">+28.44%</p>
                      <p>VS 66.68% (Prev)</p>
                    </div>
                    <div class="ms-graph-canvas">
                      <canvas id="page-impressions"></canvas>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-lg-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Patient Timeline</h6>
            </div>
            <div class="ms-panel-body">
              <ul class="ms-activity-log">
                <li>
                  <div class="ms-btn-icon btn-pill icon btn-info">
                    <i class="fa fa-wheelchair"></i>
                  </div>
                  <h6>Patient Admission</h6>
                  <span> <i class="material-icons">event</i>1 January, 2020</span>
                  <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
                </li>
                <li>
                  <div class="ms-btn-icon btn-pill icon btn-primary">
                    <i class="fa fa-user-md"></i>
                  </div>
                  <h6>Treatment Starts</h6>
                  <span> <i class="material-icons">event</i>5 January, 2020</span>
                  <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
                </li>
                <li>
                  <div class="ms-btn-icon btn-pill icon btn-success">
                    <i class="fa fa-check"></i>
                  </div>
                  <h6>Patient Discharge</h6>
                  <span> <i class="material-icons">event</i>15 March, 2020</span>
                  <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
                </li>
              </ul>
            </div>
          </div>
        </div>


        <div class="col-xl-8 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>New Patients</h6>
            </div>
            <div class="ms-panel-body">
              <div class="table-responsive">
                <table class="table table-hover  thead-primary">
                  <thead>
                    <tr>
                      <th scope="col">Patient</th>
                      <th scope="col">E-mail Id</th>
                      <th scope="col">Contact</th>
                      <th scope="col">Disease</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-3.jpg" alt="people"> Richard </td>
                      <td>Richard288@gmail.com</td>
                      <td>+1-202-555-0875</td>
                      <td>Fever</td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-2.jpg" alt="people"> William </td>
                      <td>William434@gmail.com</td>
                      <td>+1-202-534-0112</td>
                      <td>Eye</td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-4.jpg" alt="people"> John Doe </td>
                      <td>johndeo652@gmail.com</td>
                      <td>+1-202-182-0132</td>
                      <td>Typhoid</td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-5.jpg" alt="people"> Martin </td>
                      <td>Martin876@gmail.com</td>
                      <td>+1-202-998-2341</td>
                      <td>Cancer</td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="/assets/img/dashboard/patient-1.jpg" alt="people"> Robert </td>
                      <td>Robert082@gmail.com</td>
                      <td>+1-202-455-1431</td>
                      <td>Diabetes</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-4 col-md-12">
          <div class="ms-panel ms-panel-fh ms-widget">
            <div class="ms-panel-header ms-panel-custome">
              <h6>Latest Reports</h6>
            </div>
            <div class="ms-panel-body p-0">
              <ul class="ms-followers ms-list ms-scrollable">
                <li class="ms-list-item media">

                  <div class="media-body mt-1">
                    <h4>Ultrasound-2.pdf</h4>
                    <a href="#"><span class="fs-12">View Report</span></a>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" name="button">Download </button>
                </li>
                <li class="ms-list-item media">

                  <div class="media-body mt-1">
                    <h4>Hypothermia.pdf</h4>
                    <a href="#"><span class="fs-12">View Report</span></a>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" name="button">On Hold </button>
                </li>
                <li class="ms-list-item media">

                  <div class="media-body mt-1">
                    <h4>Ultrasound.pdf</h4>
                    <a href="#"><span class="fs-12">View Report</span></a>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" name="button">Download </button>
                </li>
                <li class="ms-list-item media">

                  <div class="media-body mt-1">
                    <h4>Heart-ECG.pdf</h4>
                    <a href="#"><span class="fs-12">View Report</span></a>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" name="button">Download</button>
                </li>
                <li class="ms-list-item media">

                  <div class="media-body mt-1">
                    <h4>X-ray.pdf</h4>
                    <a href="#"><span class="fs-12">View Report</span></a>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" name="button">On Hold </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- MODALS -->
  <!-- Reminder Modal -->
  <div class="modal fade" id="reminder-modal" tabindex="-1" role="dialog" aria-labelledby="reminder-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title has-icon text-white"> New Reminder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form>
          <div class="modal-body">
            <div class="ms-form-group">
              <label>Remind me about</label>
              <textarea class="form-control" name="reminder"></textarea>
            </div>
            <div class="ms-form-group">
              <span class="ms-option-name fs-14">Repeat Daily</span>
              <label class="ms-switch float-right">
                <input type="checkbox">
                <span class="ms-switch-slider round"></span>
              </label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="ms-form-group">
                  <input type="text" class="form-control datepicker" name="reminder-date" value="" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="ms-form-group">
                  <select class="form-control" name="reminder-time">
                    <option value="">12:00 pm</option>
                    <option value="">1:00 pm</option>
                    <option value="">2:00 pm</option>
                    <option value="">3:00 pm</option>
                    <option value="">4:00 pm</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Reminder</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Notes Modal -->
  <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="notes-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title has-icon text-white" id="NoteModal">New Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form>
          <div class="modal-body">
            <div class="ms-form-group">
              <label>Note Title</label>
              <input type="text" class="form-control" name="note-title" value="">
            </div>
            <div class="ms-form-group">
              <label>Note Description</label>
              <textarea class="form-control" name="note-description"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Note</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Make An Appointment</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom01">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom02">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom02" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom03">Disease</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom03" placeholder="Disease" required>

                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom04">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom04" placeholder="Add Address" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom05">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom05" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom06">Department Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom06" placeholder="Enter Department Name" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom07">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom07" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom08">Appointment Date</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom08" placeholder="Enter Appointment Date" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>Sex</label>
                      <ul class="ms-list d-flex">
                        <li class="ms-list-item pl-0">
                          <label class="ms-checkbox-wrap">
                            <input type="radio" name="radioExample" value="">
                            <i class="ms-checkbox-check"></i>
                          </label>
                          <span> Male </span>
                        </li>
                        <li class="ms-list-item">
                          <label class="ms-checkbox-wrap">
                            <input type="radio" name="radioExample" value="" checked="">
                            <i class="ms-checkbox-check"></i>
                          </label>
                          <span> Female </span>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Reset</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Add Appointment</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="prescription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Make a prescription</h4>
          <button type="button" class="close  text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom09">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom09" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom10">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom10" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom11">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom11" placeholder="Add Address" required>

                      </div>
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom12">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom12" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom13">Medication</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom13" placeholder="Acetaminophen" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom14">Period Of medication</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom14" placeholder="" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom15">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom15" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>

                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Save Prescription</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Save & Print</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="report1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Generate report</h4>
          <button type="button" class="close  text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom16">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom16" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom17">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom17" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom22">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom22" placeholder="Add Address" required>

                      </div>
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom18">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom18" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom19">Report Type</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom19" placeholder="Diseases Report" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom23">Report Period</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom23" placeholder="" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom20">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom20" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>

                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Generate Report</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Generate & Print</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>


  <!-- Global Required Scripts End -->
  <script src="/assets/js/d3.v3.min.js"> </script>
  <script src="/assets/js/topojson.v1.min.js"> </script>
  <script src="/assets/js/datamaps.all.min.js"> </script>
  <!-- Page Specific Scripts Start -->
  <script src="/assets/js/slick.min.js"> </script>
  <script src="/assets/js/moment.js"> </script>
  <script src="/assets/js/jquery.webticker.min.js"> </script>
  <script src="/assets/js/Chart.bundle.min.js"> </script>
  <script src="/assets/js/index-chart.js"> </script>
@endsection
