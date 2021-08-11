@extends('admin.layouts.master')
@section('title', 'Master Association')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#"> Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Master Association</li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Patient List</h6>
                        <a href="#" class="ms-text-primary">Add Master Association </a>
                    </div>
                    <div class="ms-panel-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-sort="ascending"
                                        aria-label="S.No.: activate to sort column descending" style="width: 101px;">S.No.
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Pic: activate to sort column ascending" style="width: 75px;">Pic
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 106px;">
                                        Name
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 264px;">
                                        Email
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending" style="width: 167px;">
                                        Address
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 176px;">
                                        Mobile
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending"
                                        style="width: 191px;">Joining Date
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="data-table11" rowspan="1" colspan="1" aria-label="Update: activate to sort column ascending" style="width: 124px;">
                                        Update
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="odd">
                                    <td class="sorting_1">1</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Denise</td>
                                    <td>denise176@gmail.com</td>
                                    <td>New York</td>
                                    <td> (836) 257 1340</td>
                                    <td>10 Nov 2012</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="sorting_1">2</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Jennifer</td>
                                    <td>jennifer@gmail.com</td>
                                    <td>Los Angeles</td>
                                    <td> (836) 257 1379</td>
                                    <td>16 Nov 2014</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1">3</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Kyle</td>
                                    <td>kyle698@gmail.com</td>
                                    <td>Atlanta</td>
                                    <td> (836) 257 1372</td>
                                    <td>12 Nov 2015</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="sorting_1">4</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Joshua</td>
                                    <td>joshua@gmail.com</td>
                                    <td>Chicago</td>
                                    <td> (836) 257 1374</td>
                                    <td>16 Nov 2009</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1">5</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Adwerd</td>
                                    <td>adwerd@gmail.com</td>
                                    <td>California</td>
                                    <td> (836) 257 1371</td>
                                    <td>8 Nov 2015</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="sorting_1">6</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Daniel</td>
                                    <td>daniel983@gmail.com</td>
                                    <td>New York</td>
                                    <td> (836) 257 1375</td>
                                    <td>10 Nov 2009</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1">7</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Jennifer</td>
                                    <td>jennifer@gmail.com</td>
                                    <td>San Francisco</td>
                                    <td> (836) 257 1373</td>
                                    <td>16 Nov 2020</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="sorting_1">8</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Kyle</td>
                                    <td>kyle698@gmail.com</td>
                                    <td>Los Angeles</td>
                                    <td> (836) 257 1312</td>
                                    <td>12 Nov 2014</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1">9</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Joshua</td>
                                    <td>joshua@gmail.com</td>
                                    <td>Atlanta</td>
                                    <td> (836) 257 1332</td>
                                    <td>8 Nov 2009</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="sorting_1">10</td>
                                    <td><img src="/assets/img/user.jpg"></td>
                                    <td>Adwerd</td>
                                    <td>adwerd@gmail.com</td>
                                    <td>California</td>
                                    <td> (836) 257 1324</td>
                                    <td>15 Nov 2015</td>
                                    <td class="action"><a href="#"><i class="fas fa-pencil-alt ms-text-primary"></i></a> <a href="#"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable();
        });
    </script>
<style>
    .action{
        display: flex;
    }
    .dropdown-toggle::after {
        vertical-align: 0.155em;
        left: 0px;
        position: absolute;
        color: #fff;
        left: 20px;
        display: none;
        margin-right: 0px !important;
        top: 7px;
    }
    .cust-btn{
        padding: 4px 4px 3px 4px;
        border-radius: 2px;
        color: #009efb;
    }
    .cust-btn .fas{

        margin-right: 0px !important;
    }
</style>
@endsection

