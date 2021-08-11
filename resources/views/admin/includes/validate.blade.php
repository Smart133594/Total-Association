@if($validate)
    <style>.error {
            color: #FF0000
        }

        label span {
            color: #FF0000
        }
    </style>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>


    <script>
        $("#admin-form").validate();
    </script>

    <script>
        $(document).ready(function () {
                @foreach($validate as $va)
            var name = $("input[name*='{{$va}}']").siblings('label').text();
            $("input[name*='{{$va}}']").siblings('label').html(name + " <span>*</span>");

            name = $("select[name*='{{$va}}']").siblings('label').text();
            $("select[name*='{{$va}}']").siblings('label').html(name + " <span>*</span>");

            name = $("textarea[name*='{{$va}}']").siblings('label').text();
            $("textarea[name*='{{$va}}']").siblings('label').html(name + " <span>*</span>");
            @endforeach
        });
    </script>


@endif
