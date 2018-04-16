@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\HomeController; ?>
<div class="container">
    <div class="row">
        <div class="col NewUser">
            @if(Session::has('fail'))
            <div class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                <h4>{{Session::get('fail')}}</h4>
            </div>
            @endif
            @if(Session::has('succes'))
            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                <h4>{{Session::get('succes')}}</h4>
            </div>
            @endif
            <button class="btn" data-toggle="modal" data-target=".bd-example-modal-lg">Add Users</button>
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="/add" method="POST">
                                @csrf
                                <center><h1>Adaugati un nou cont.</h1></center>
                                <center><p>Completati toate casutele.</p></center>
                                <hr>
                                <label for="nume"><b>Numele</b></label>
                                <input type="text"  class="form-control" placeholder="Introduceti Numele" name="nume" required>

                                <label for="pass"><b>Parola</b></label>
                                <input type="text"  class="form-control" placeholder="Introduceti Parola" name="pass" required>
                                <br>
                                <center><button type="submit" class="btn btn-success">Apply</button></center>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>       
        </div>
        <div class="col SendActionForAllOnline">
            <button class="btn " data-toggle="modal" data-target=".1bd-example-modal-lg">Tools For All Online</button>
            <div class="modal fade 1bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <center><h1>Send to all users online</h1></center>
                            <div class="row">
                                <div class="col">
                                        {!! Form::open(['route'=>'send.form', 'method' => 'post']) !!}
                                        <center>{!! Form::label('action', 'Send Action') !!}</center>
                                        <div class="input-group">
                                        <select class="selectpicker form-control" name="action">
                                            <option value="R">Restart</option>
                                            <option value="S">Shutdown</option>
                                        </select>
                                        {!! Form::hidden('status', '1') !!}
                                        <button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                                <div class="col">
                                    {!! Form::open(['route'=>'open.form', 'method' => 'post']) !!}
                                    <center>{!! Form::label('action', 'Open Website') !!}</center>
                                    <div class="input-group">
                                    <input type="text"  class="form-control" placeholder="Introduceti un site" name="web" required>        
                                    {!! Form::hidden('status', '1') !!}
                                    <button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <br>
                            {!! Form::open(['route'=>'data.form', 'method' => 'post']) !!}
                            {!! Form::hidden('status', '1') !!}  
                            <center>{!! Form::label('action', 'Clean System Cached') !!}</center>
                            <div class="row">
                                        <div class="col-md-6">
                                            <div class="funkyradio">
                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="muic" value="1" id="checkbox1"/>
                                                    <label for="checkbox1">MUI Cache</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="rfile" value="1" id="checkbox2"/>
                                                    <label for="checkbox2">Recent Files</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="wlogs" value="1" id="checkbox3" checked/>
                                                    <label for="checkbox3">Windows Logs</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="rstart" value="1" id="checkbox4" checked/>
                                                    <label for="checkbox4">Run At Startup</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="rapp" value="1" id="checkbox5" checked/>
                                                    <label for="checkbox5">Recent Apps</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="temp" value="1" id="checkbox6" checked/>
                                                    <label for="checkbox6">Temporary Files</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="funkyradio">
                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="pref" value="1" id="checkbox7" checked/>
                                                    <label for="checkbox7">Prefetch</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="trac" value="1" id="checkbox8" checked/>
                                                    <label for="checkbox8">Tracing</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="useras" value="1" id="checkbox9" checked/>
                                                    <label for="checkbox9">UserAssist</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="compstore" value="1" id="checkbox10" checked/>
                                                    <label for="checkbox10">Compatibility Store</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="rebin" value="1" id="checkbox11" checked/>
                                                    <label for="checkbox11">Empty Recycle Bin</label>
                                                </div>

                                                <div class="funkyradio-success">
                                                    <input type="checkbox" name="mpoint" value="1" id="checkbox12" checked/>
                                                    <label for="checkbox12">MountPoints</label>
                                                </div>

                                            </div>
                                        </div>
                           
                            </div>
                            <center> <button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button></center>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <table id="table_id" class="table table-striped table-responsive">
        <thead>
            <tr>
                <th style="width: 15%">Nume PC</th>
                <th style="width: 20%">Last Login</th>
                <th style="width: 20%">Last Logout</th>
                <th style="width: 25%">Date Add</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Tools</th>
            </tr>
        </thead>                    
        <tbody>
            @foreach ($users as $user)   
                <tr>
                    <td><h5>{{ $user->statie }}</h5></td>
                    <td>
                                @if ($user->last_login === NULL)
                                <h5 style="color:red;">Neutilizat</h5>
                                @else
                                <h5>{{ $user->last_login }}</h5>
                                @endif
                    </td>
                    <td>
                                @if($user->last_logout===NULL)
                                @if($user->last_login===NULL)
                                
                                <h5 style="color:red;">Neutilizat</h5>
                                @else
                                <h5>{!!HomeController::checklastlog(strtotime($user->last_online),$user->id)!!}</h5>       
                                @endif     
                                @else
                                <h5>{!!HomeController::checklastlog(strtotime($user->last_online),$user->id)!!}</h5>
                                @endif
                    </td>
                    <td><h5>{{ $user->date_add }}</h5></td>
                    <td>
                                @if($user->last_login===NULL)
                                <h5 style="color:red;">Offline</h5>
                                @else
                                @if((time()-strtotime($user->last_online) < 10)) <h5 style="color:green;">Online</h5> @else <h5 style="color:red;">Offline</h5> @endif @endif
                    </td>
                    <td>             
                    <div class="input-group" style="text-align:center">
                        {!! Form::open(['route'=>'del.form', 'method' => 'post']) !!}
                        {!! Form::hidden('delete', $user->id) !!}
                        {!! Form::hidden('nume', $user->statie) !!}
                        <button type="submit" class="btn  btn-danger"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                        <button class="btn" data-toggle="modal" data-target=".{{$user->id}}"><i class="fa fa-home"></i></button>
                        <div class="modal fade {{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <center><h5 class="modal-title">Tools for {{$user->statie}} </h5></center>
                                            <div class="row">
                                                <div class="col">
                                                        {!! Form::open(['route'=>'sendonly.form', 'method' => 'post']) !!}
                                                        <center>{!! Form::label('action', 'Send Action') !!}</center>
                                                        <div class="input-group">
                                                        <select class="selectpicker form-control" name="action">
                                                            <option value="R">Restart</option>
                                                            <option value="S">Shutdown</option>
                                                        </select>
                                                                {!! Form::hidden('status', '1') !!}
                                                                {!! Form::hidden('id', $user->id) !!}
                                                                {!! Form::hidden('nume', $user->statie) !!}
                                                        <button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                </div>
                                                <div class="col">
                                                    {!! Form::open(['route'=>'openonly.form', 'method' => 'post']) !!}
                                                    <center>{!! Form::label('action', 'Open Website') !!}</center>
                                                    <div class="input-group">
                                                    <input type="text"  class="form-control" placeholder="Introduceti un site" name="web" required>        
                                                    {!! Form::hidden('status', '1') !!}
                                                    {!! Form::hidden('id', $user->id) !!}
                                                    {!! Form::hidden('nume', $user->statie) !!}
                                                    <button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                            <br>
                                                    {!! Form::open(['route'=>'dataonly.form', 'method' => 'post']) !!}
                                                    {!! Form::hidden('id', $user->id) !!}
                                                    <center>{!! Form::label('action', 'Clean System Cached') !!}</center>
                                                    {!! Form::hidden('statie', $user->statie) !!}
                                                    {!! Form::hidden('email', $user->email) !!}
                                                    {!! Form::hidden('idcont', $user->idcont) !!}
                                                    {!! Form::hidden('status', '1') !!}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="funkyradio">
                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="muic" value="1" id="checkbox1{{$user->id}}"/>
                                                                    <label for="checkbox1{{$user->id}}">MUI Cache</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="rfile" value="1" id="checkbox2{{$user->id}}"/>
                                                                    <label for="checkbox2{{$user->id}}">Recent Files</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="wlogs" value="1" id="checkbox3{{$user->id}}" checked/>
                                                                    <label for="checkbox3{{$user->id}}">Windows Logs</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="rstart" value="1" id="checkbox4{{$user->id}}" checked/>
                                                                    <label for="checkbox4{{$user->id}}">Run At Startup</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="rapp" value="1" id="checkbox5{{$user->id}}" checked/>
                                                                    <label for="checkbox5{{$user->id}}">Recent Apps</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="temp" value="1" id="checkbox6{{$user->id}}" checked/>
                                                                    <label for="checkbox6{{$user->id}}">Temporary Files</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="funkyradio">
                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="pref" value="1" id="checkbox7{{$user->id}}" checked/>
                                                                    <label for="checkbox7{{$user->id}}">Prefetch</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="trac" value="1" id="checkbox8{{$user->id}}" checked/>
                                                                    <label for="checkbox8{{$user->id}}">Tracing</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="useras" value="1" id="checkbox9{{$user->id}}" checked/>
                                                                    <label for="checkbox9{{$user->id}}">UserAssist</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="compstore" value="1" id="checkbox10{{$user->id}}" checked/>
                                                                    <label for="checkbox10{{$user->id}}">Compatibility Store</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="rebin" value="1" id="checkbox11{{$user->id}}" checked/>
                                                                    <label for="checkbox11{{$user->id}}">Empty Recycle Bin</label>
                                                                </div>

                                                                <div class="funkyradio-success">
                                                                    <input type="checkbox" name="mpoint" value="1" id="checkbox12{{$user->id}}" checked/>
                                                                    <label for="checkbox12{{$user->id}}">MountPoints</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <center><button type="submit" class="btn  btn-success"><i class="fa fa-send"></i></button></center>
                                                    {!! Form::close() !!}
                                            </br>
                                    </div>
                                </div>
                            </div>
                         </div>     
                    
                    </div>
                    </td>
                                    
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 15%">Nume PC</th>
                <th style="width: 20%">Last Login</th>
                <th style="width: 20%">Last Logout</th>
                <th style="width: 25%">Date Add</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Tools</th>
            </tr>
        </tfoot>    
    </table> 
</div>


<script>
    window.setTimeout(function () {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
    window.setTimeout(function () {
        $(".alert-warning").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);

    
</script>
<script>
  $(document).ready(function(){
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                
                className: 'btn btn-info',
                        exportOptions: {
                    columns: [ 0, 1, 2,3,4]
            }   
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-info',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
            }   
            },
            {
                extend: 'pdfHtml5',
                messageTop: 'All customer from database.',
                className: 'btn btn-info',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
            }   
            },
            {
                extend: 'print',
                className: 'btn btn-info',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
            }   
            }
        ],
        "deferRender": true, 
        "scrollY": 500,
        "scrollX": true,
        "paging":   true,
        "ordering": true,
        "info":     true,
    });
  });
</script>
@endsection