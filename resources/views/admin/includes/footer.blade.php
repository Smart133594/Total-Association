</main>
<!-- SCRIPTS -->
<!-- Global Required Scripts Start -->

<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/perfect-scrollbar.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>
<!-- Global Required Scripts End -->
<!-- Page Specific Scripts Start -->
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/moment.js"></script>
<script src="/assets/js/jquery.webticker.min.js"></script>
<script src="/assets/js/Chart.bundle.min.js"></script>
<script src="/assets/js/Chart.Financial.js"></script>
<!-- Page Specific Scripts Finish -->
<!-- Page Specific Scripts Start -->
<script src="/assets/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/datatables/datatables.min.js"></script>
<!-- Page Specific Scripts End -->
<!-- Medboard core JavaScript -->
<script src="/assets/js/framework.js"></script>
<!-- Settings -->
<script src="/assets/js/settings.js"></script>


<script>
    function delimg(table, field, id) {
        var path = '/delimg/' + table + '/' + field + '/' + id;
        $.get(path, function (res) {
            $("." + field).remove();
        });
    }

    function statuschange(table, field, id) {
        var path = '/statuschange/' + table + '/' + field + '/' + id;
        $.get(path, function (res) {

        });
    }


</script>

<script>
    function generateurl(url) {
        // make the url lowercase
        var encodedUrl = url.toString().toLowerCase();
        // replace & with and
        encodedUrl = encodedUrl.split(/\&+/).join("-and-")
        // remove invalid characters
        encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-");
        // remove duplicates
        encodedUrl = encodedUrl.split(/-+/).join("-");
        // trim leading & trailing characters
        encodedUrl = encodedUrl.trim('-');
        $("#seoUrl").val(encodedUrl);
    }
</script>

    <link rel="stylesheet" href="https://euphoriaproperties.com/assets/lib/bootstrap-select-1.13.2/bootstrap-select.min.css">
    <script src="https://euphoriaproperties.com/assets/lib/bootstrap-select-1.13.2/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
            var options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('desc', options);
            $('#name').keyup(function () {
                $('#slug').val((($(this).val()).replace(/[^A-Z0-9]/ig, "_")).toLowerCase());
            })
        })
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.filter-search').select2();
        });
    </script>

<script>
    $(document).ready(function () {
        var href = window.location.pathname;
        $(".menu-item .active").parents('.collapse').removeClass('show');
        $(".menu-item .active").removeClass('active');

        href = href.split("/");
        href = href[1];
        $("." + href).addClass('active');
        $(".menu-item .active").parents('.collapse').addClass('show');
    });


    let phoneNo = document.getElementById('phoneNo');
    phoneNo?.addEventListener('keydown', (event) => {
        var regex = new RegExp("^[0-9-a-z!@#$%*?]");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        //  console.log("|"+key+"|");
        if (!regex.test(key) && key != " " && key != "\t" && key != '`' && key != '\b' && key != '.') {
            event.preventDefault();
            return false;
        }
    });

    let whatsapp = document.getElementById('whatsapp');
    whatsapp?.addEventListener('keydown', (event) => {
        var regex = new RegExp("^[0-9-a-z!@#$%*?]");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key) && key != " " && key != "\t" && key != '`' && key != '\b' && key != '.') {
            event.preventDefault();
            return false;
        }
    });

    let fax = document.getElementById('fax');
    fax?.addEventListener('keydown', (event) => {
        var regex = new RegExp("^[0-9-a-z!@#$%*?]");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key) && key != " " && key != "\t" && key != '`' && key != '\b' && key != '.') {
            event.preventDefault();
            return false;
        }
    });


    $(document).ready(function () {
        $("#website").blur(function () {
            var url = $("#website").val();
            var pattern = /^(http(s)?:\/\/)?(www\.)?[A-Z-a-z0-9]+([\-\.]{1}[A-Z-a-z0-9]+)*\.[A-Z-a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            args = pattern.test(url);
            if (args) {
                $("#website").addClass('valid');
            } else {
                $("#website").addClass('error');
                html = '<label for="website" generated="true" class="webiste-error error">Please enter a valid website.</label>';
                $("#website").after(html);
            }
        })
        $("#website").focus(function () {
            $(".webiste-error").remove();
            $("#website").removeClass('error');
        })
    })


</script>
<script>
    tinymce.init({
        selector: 'textarea.editor',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        height: "480"
    });
</script>

</body>

</html>
