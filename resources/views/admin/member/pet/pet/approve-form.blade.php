<form action="{{ route('pet.store') }}" method="post">
    <input type="hidden" name="id" value="{{$data->id}}">
    <input type="hidden" name="status" value="1">
    @csrf
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleEmail">Approve Date <span>*</span></label>
            <input type="text" class="form-control customdate" id="approveDate" name="approveDate" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleEmail">Approve By <span>*</span></label>
            <input type="text" class="form-control" id="approveBy" name="approveBy" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleEmail">Approval Document <span>*</span></label><br>
            <input type="file" id="approvalDocument" name="approvalDocument" required>
        </div>
    </div>
    <div class="col-md-12">
        <input type="submit"  value="Save" class="btn btn-success">
    </div>
</form>
<script>
    $(document).ready(function () {
        $('.customdate').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
