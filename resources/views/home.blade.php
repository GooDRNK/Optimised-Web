@extends('layouts.app')

@section('content')
<div id="reacthome"></div>
<script>
window.config = {
    ID: "{!! $idcont !!}",
    Email: "{!! $email !!}",
    csrfToken: "{!! csrf_token() !!}"
};
</script>
@endsection