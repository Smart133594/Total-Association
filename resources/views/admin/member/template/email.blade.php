@extends('admin.layouts.master')
@section('title', 'Bulk Communication')
@section('content')
<style>
    .dropdown-menu {
        right: -99px !important;
        left: auto !important;
    }
</style>
<div class="ms-content-wrapper">
    <div class="ms-panel ms-email-panel">
       <div class="ms-panel-body p-0">
          <div class="ms-email-aside">
             <a onclick="toggleCompose()" href="#" class="btn btn-primary w-100 mt-0 has-icon"> <i class="flaticon-pencil"></i> Compose Email </a>
             <ul class="ms-list ms-email-list">
                <li class="ms-list-item ms-email-label"> Main </li>
                
                <li class="ms-list-item ms-active-email" id="inbox" onclick="boxItemClicked(0, 0)"> <a href="#"> <i class="material-icons ms-has-notification">mail</i> Inbox  <span id="cnt_0">0</span> </a> </li>
                <li class="ms-list-item" id="flagged" onclick="boxItemClicked(1, 0)"> <a href="#"> <i class="material-icons">flag</i> Flagged <span id="cnt_1">0</span> </a> </li>
                <li class="ms-list-item" id="spam" onclick="boxItemClicked(2, 0)"> <a href="#"> <i class="material-icons">chat</i> Spam <span id="cnt_2">0</span> </a> </li>
                <li class="ms-list-item" id="drafts" onclick="boxItemClicked(3, 0)"> <a href="#"> <i class="material-icons">drafts</i> Drafts <span id="cnt_3">0</span> </a> </li>
                <li class="ms-list-item" id="sent" onclick="boxItemClicked(4, 0)"> <a href="#"> <i class="material-icons">send</i> Sent <span id="cnt_4">0</span> </a> </li>
                <li class="ms-list-item" id="trash" onclick="boxItemClicked(5, 0)"> <a href="#"> <i class="material-icons">delete</i> Trash <span id="cnt_5">0</span> </a> </li>
             </ul>

             <ul class="ms-list ms-email-list">
                <li class="ms-list-item ms-email-label">Folders</li>
                
                <li class="ms-list-item" id="application" onclick="boxItemClicked(6, 1)"> <a href="#"><i class="material-icons">folder</i> Application <span id="cnt_6">0</span> </a> </li>
                <li class="ms-list-item" id="incidents" onclick="boxItemClicked(7, 1)"> <a href="#"><i class="material-icons">folder</i> Incidents <span id="cnt_7">0</span> </a> </li>
                <li class="ms-list-item" id="fines" onclick="boxItemClicked(8, 1)"> <a href="#"><i class="material-icons">folder</i> Fines <span id="cnt_8">0</span> </a> </li>
                <li class="ms-list-item" id="purchases" onclick="boxItemClicked(9, 1)"> <a href="#"><i class="material-icons">folder</i> Purchases <span id="cnt_9">0</span> </a> </li>
             </ul>
             <div class="ms-email-config">
                <div class="progress progress-tiny">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0">54.27 GB (25%) of 150 GB used</p>
                <a href="#">Manage Storage</a>
             </div>
          </div>
          <!-- Email Main -->
          <div class="ms-email-main" id="email_main">
             <div class="ms-panel-header">
                <h6 id="header_title">Please select the box</h6>
                <p id="unread_message"></p>
                <ul class="ms-email-pagination">
                   <li id="state_bar"></li>
                   <li class="ms-email-pagination-item"> <a href="#" class="ms-email-pagination-link"> <i class="material-icons">keyboard_arrow_left</i> </a>  </li>
                   <li class="ms-email-pagination-item "> <a href="#" class="ms-email-pagination-link"> <i class="material-icons">keyboard_arrow_right</i> </a> </li>
                </ul>
             </div>
             <div class="ms-email-header">
                <ul class="ms-email-options">
                   <li>
                      <label class="ms-checkbox-wrap">
                      <input type="checkbox" class="ms-email-check-all" value="">
                      <i class="ms-checkbox-check"></i>
                      </label>
                      <div class="dropdown">
                         <a href="#" class="has-chevron" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Select
                         </a>
                         <ul class="dropdown-menu">
                            <li class="ms-dropdown-list">
                               <a class="media p-2" href="#" onclick="setReadItems()">
                                  <div class="media-body">
                                     <span>Mark as read</span>
                                  </div>
                               </a>
                               <a class="media p-2" href="#">
                                  <div class="media-body">
                                     <span>Flag</span>
                                  </div>
                               </a>
                               <a class="media p-2" href="#" onclick="deleteEmail()">
                                  <div class="media-body">
                                     <span>Delete</span>
                                  </div>
                               </a>
                               <a class="media p-2" href="#" onclick="setMoveFolder()">
                                  <div class="media-body">
                                     <span>To Folder</span>
                                  </div>
                               </a>
                            </li>
                         </ul>
                      </div>
                   </li>
                </ul>
                <ul class="ms-email-options">
                   <li><a href="#" class="text-disabled"> <i class="material-icons">refresh</i> Refresh </a></li>
                   <li><a href="#" onclick="setReadItems()" class="text-disabled"> <i class="material-icons">local_offer</i> Read </a></li>
                   <li><a href="#" onclick="setMoveFolder()" class="text-disabled"> <i class="material-icons">folder</i> To Folder </a></li>
                </ul>
             </div>
             <!-- Email Content -->
             <div class="ms-email-content">
                <ul class="ms-scrollable" id="email_list">
                   
                </ul>
             </div>
          </div>

          <!-- Email Compose -->
          <div class="ms-email-main" id="email_compose" style="display: none">
                <div class="ms-panel-header">
                    <h6 id="header_title">Compose Email</h6>
                </div>
                <div class="ms-email-header">
                    <ul class="ms-email-options">
                        <li>
                            <ul class="ms-email-options">
                                <li><a href="#" class="text-disabled"><i class="material-icons">refresh</i> Check Emails </a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="ms-email-options">
                        <li><a href="#" onclick="sendMail()" class="text-disabled"> <i class="material-icons">local_offer</i> Send Email </a></li>
                    </ul>
                </div>
                <!-- Email Content -->
                <div class="ms-email-content">
                    <div class="row" style="padding: 3%;">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleEmail">Send to (Coma separated)</label>
                                <div class="row">
                                    <div class="col-10"><input type="text" id="addr_1" value="" class="form-control" /></div>
                                    <div class="col-2"><button class="btn btn-primary" onclick="inputAddr(1)" style="width: 45px; min-width: 45px; margin-top: -3px; margin-left: -20px;">+</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleEmail">CC (Coma separated)</label>
                                <div class="row">
                                    <div class="col-10"><input type="text" id="addr_2" value="" class="form-control" /></div>
                                    <div class="col-2"><button class="btn btn-primary" onclick="inputAddr(2)" style="width: 45px; min-width: 45px; margin-top: -3px; margin-left: -20px;">+</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleEmail">BCC (Coma separated)</label>
                                <div class="row">
                                    <div class="col-10"><input type="text" id="addr_3" value="" class="form-control" /></div>
                                    <div class="col-2"><button class="btn btn-primary" onclick="inputAddr(3)" style="width: 45px; min-width: 45px; margin-top: -3px; margin-left: -20px;">+</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ms-email-header" style="margin-top: -50px"></div>
                    <div class="row" style="padding: 3%">
                        <div class="col-12">
                            @include('admin.includes.msg')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control editor" id="mytemplate" name="template">@if($data ?? ''){{$data->template}}@endif</textarea>
                                    </div>
                                    @foreach($template_variable as $t)
                                        <button class="btn btn-secondary" type="button" onclick="setto('{{$t->variable}}')">{{$t->variable}}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModal">
    <div class="modal-dialog modal-dialog-centered modal-min" role="document">
      <div class="modal-content">

        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="flaticon-email d-block"></i>
          <h1>Subscribe</h1>
          <p> Subscribe and get our latest updates </p>
          <div class="ms-form-group has-icon">
            <input type="text" placeholder="Email Address" class="form-control" name="news-letter" value="">
            <i class="material-icons">email</i>
          </div>
        <button onclick="selectAddr()" class="btn btn-primary shadow-none">Get Started</button>
        </div>

      </div>
    </div>
  </div>

<script>
    let selected_itemId = -1, selected_sectionId = -1, selected_addr = -1;

    $(document).ready(function() {
        initCounter();
    });

    const toggleCompose = () => {
        $("#email_main").attr("style", "display: none");
        $("#email_compose").attr("style", "display: initial");
    }

    const initCounter = () => {
        $.get("/email-boxcount", function(data, status) {
            for(var i = 0; i < data.length; i++) {
                if(selected_itemId == i) {
                    if(data[i] != 0) $("#state_bar").html(`1-${data[i]} of ${data[i]}`);
                    else $("#state_bar").html(`Empty`);
                }
                $("#cnt_" + i).html(data[i]);
            }
        });
    }

    const deleteEmail = () => {
        var selected_msg = document.getElementsByName("selected_msg[]");
        var id = [], data = [], index = 0;
        selected_msg.forEach(element => {
            id[index] = element.value;
            data[index++] = element.checked;
        });

        var formData = new FormData();
        formData.append('id', id);
        formData.append('value', data);
        formData.append('_token', "{{csrf_token()}}");

        $.ajax({
            url: '/email-delete',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {
                boxItemClicked(selected_itemId, selected_sectionId);
            }
        });

        $.get("/email-boxcount" + id, function(res) {
            for(var i = 0; i < data.length; i++) {
                $("#cnt_" + i).html(data[i]);
            }
        });
    }

    const getFlagClass = (flag) => {
        let flagClass = "media ms-email pinned clearfix";
        flag == 0 ? flagClass = "media ms-email clearfix" : "";
        return flagClass;
    }

    const getDateString = (str) => {
        var date = new Date(str);
        var str_date = date.toDateString().slice(4, 15);
        var str_time = date.toTimeString().slice(0, 8);
        return str_date + ' ' + str_time;
    }

    const getReadClass = (read) => {
        let readClass = "";
        read == 0 ? readClass = '<i class="material-icons">attachment</i></a>' : '';
        return readClass;
    }

    const setFlaggedItem = (id) => {
        $.get("/email-flagged/" + id, function(res) {
            boxItemClicked(selected_itemId, selected_sectionId);
        });
    }

    const setReadItems = () => {
        var selected_msg = document.getElementsByName("selected_msg[]");
        var id = [], data = [], index = 0;
        selected_msg.forEach(element => {
            id[index] = element.value;
            data[index++] = element.checked;
        });

        var formData = new FormData();
        formData.append('id', id);
        formData.append('value', data);
        formData.append('_token', "{{csrf_token()}}");

        $.ajax({
            url: '/email-read',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {
                boxItemClicked(selected_itemId, selected_sectionId);
            }
        });
    }

    const setMoveFolder = () => {
        var selected_msg = document.getElementsByName("selected_msg[]");
        var id = [], data = [], index = 0;
        selected_msg.forEach(element => {
            id[index] = element.value;
            data[index++] = element.checked;
        });

        var formData = new FormData();
        formData.append('id', id);
        formData.append('value', data);
        formData.append('_token', "{{csrf_token()}}");

        $.ajax({
            url: '/email-movetofolder',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {
                boxItemClicked(selected_itemId, selected_sectionId);
            }
        });
    }

    const boxItemClicked = (itemId, sectionId) => {
        initCounter();

        $("#email_main").attr("style", "display: initial");
        $("#email_compose").attr("style", "display: none");

        selected_itemId = itemId;
        selected_sectionId = sectionId;

        const itemTitle = ['inbox', 'flagged', 'spam', 'drafts', 'sent', 'trash', 'application', 'incidents', 'fines', 'purchases'];
        itemTitle.forEach(element => {
            if(itemTitle[itemId] == element) {
                $(`#${element}`).addClass("ms-active-email");

                var formData = new FormData();
                formData.append('itemId', itemId);
                formData.append('sectionId', sectionId);
                formData.append('_token', "{{csrf_token()}}");

                $("#header_title").html(element);

                if(itemId == 1) {
                    formData.append('isFlagged', 1);
                } else {
                    formData.append('isFlagged', 0);
                }

                $.ajax({
                    url: '/email-getitems',
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (data) {
                        var html = '';
                        var unread_count = 0;

                        data.forEach(item => {
                            if(item['read'] == 0) unread_count++;
                            html += `
                                <li class="`+getFlagClass(item['flag'])+`">
                                    <div class="ms-email-controls">
                                        <label class="ms-checkbox-wrap">
                                        <input type="checkbox" value="${item['id']}" name="selected_msg[]">
                                        <i class="ms-checkbox-check"></i>
                                        </label>
                                        <i class="material-icons ms-pin-email" onclick="setFlaggedItem(${item['id']})">flag</i>
                                    </div>
                                    <div class="ms-email-img mr-3 ">
                                        <img src="https://via.placeholder.com/270x270" class="ms-img-round" alt="people">
                                    </div>
                                    <div class="media-body ms-email-details">
                                        <span class="ms-email-sender">${item['from']}-${item['to']}</span>
                                        <h6 class="ms-email-subject">${item['title']}</h6>
                                        <span class="ms-email-time"> <a href="#">`+getReadClass(item['read'])+' '+getDateString(item['created_at'])+`</span>
                                        <p class="ms-email-msg">${item['email']}</p>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="ms-hoverable-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="ms-dropdown-list">
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>View</span>
                                                </div>
                                            </a>
                                            <a class="media p-2 ms-pin-email" href="#">
                                                <div class="media-body">
                                                    <span>Reply</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>Reply All</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>Forward</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>Mark as Read</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>Flag</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>Delete</span>
                                                </div>
                                            </a>
                                            <a class="media p-2" href="#">
                                                <div class="media-body">
                                                    <span>To Folder</span>
                                                </div>
                                            </a>
                                        </li>
                                        </ul>
                                    </div>
                                </li>`;
                        });
                        $("#unread_message").html(`You have ${unread_count} Unread Messages`);
                        $("#email_list").html(html);
                    }
                });
            } else {
                $(`#${element}`).removeClass("ms-active-email");
            }
        });
    }

    const inputAddr = (id) => {
        selected_addr = id;
        $("#inputModal").modal('show');
    }

    const selectAddr = () => {
        $(`#addr_${selected_addr}`).val("haha");
        $("#inputModal").modal('hide');
    }

    const setto = (mark) => {
        tinymce.activeEditor.execCommand('mceInsertContent', false, mark);
    }

    const sendMail = () => {
        var formData = new FormData();
        formData.append('itemId', itemId);
        formData.append('sectionId', sectionId);
        formData.append('_token', "{{csrf_token()}}");

        $.ajax({
            url: '/send-bulkmail',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {

            }
        });
    }
 </script>

@endsection