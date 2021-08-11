@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has("error"))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session()->has("message"))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<style>
    .alert ul{
        margin-bottom: 0px;
    }
</style>
