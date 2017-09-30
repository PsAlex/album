
@if(Session('success'))
<div class="alert alert-success alert-dismissible"  role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    {{Session('success')}}
</div>
@endif

@if(Session('info'))
<div class="alert alert-info alert-dismissible"  role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    {!!Session('info')!!}
</div>
@endif
@if(Session('warning'))
<div class="alert alert-warning alert-dismissible"  role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    {{Session('warning')}}
</div>
@endif


@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible"  role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

     
   有一些错误.
    <br>
    <br>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
