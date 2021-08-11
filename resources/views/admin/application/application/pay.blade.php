
<form action='{{$paypal_url}}' method='post' id="method2" name='frmPayPal1'>
    <input type='hidden' name='currency_code' value='USD'>
    <input type='hidden' name='business' value='{{ $setting["paypal_id"] }}'>
    <!--<input type='text' name='cmd' value='_xclick'>-->
    <input type='hidden' name='cmd' value='_xclick'>
    <input type="hidden" name="rm" value="2">
    <input type='hidden' name='item_name' value='{{$paymnet_id}}'>
    <input type='hidden' name='item_number' value=''>
    <input type='hidden' name='amount' value='{{ $setting["application_amount"] }}'>
    <input type='hidden' name='handling' value='0'>
    <input type='hidden' name='no_shipping' value='1'>
    <input type='hidden' name='cancel_return' value='{{$path}}cancel'>
    <input type='hidden' name='return' value='{{$path}}success'>

</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
    $( document ).ready(function() {
         $("#method2").submit();
    });
</script>
