@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Example</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Example    </div>

    <div class="panel-body">
                

        <form action="{{ url('/examples') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="parent_id" class="col-sm-3 control-label">Parent </label>
            <div class="col-sm-6">
                <input type="text" name="parent_id" id="parent_id" class="form-control" value="{{$model['parent_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="users_id" class="col-sm-3 control-label">Users </label>
            <div class="col-sm-6">
                <input type="text" name="users_id" id="users_id" class="form-control" value="{{$model['users_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-6">
                <input type="text" name="title" id="title" class="form-control" value="{{$model['title'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="body" class="col-sm-3 control-label">Body</label>
            <div class="col-sm-6">
                <input type="text" name="body" id="body" class="form-control" value="{{$model['body'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="amount" class="col-sm-3 control-label">Amount</label>
            <div class="col-sm-6">
                <input type="text" name="amount" id="amount" class="form-control" value="{{$model['amount'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="date" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-6">
                <input type="text" name="date" id="date" class="form-control" value="{{$model['date'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="time" class="col-sm-3 control-label">Time</label>
            <div class="col-sm-6">
                <input type="text" name="time" id="time" class="form-control" value="{{$model['time'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="datetime" class="col-sm-3 control-label">Datetime</label>
            <div class="col-sm-6">
                <input type="text" name="datetime" id="datetime" class="form-control" value="{{$model['datetime'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-6">
                <input type="text" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="active" class="col-sm-3 control-label">Active</label>
            <div class="col-sm-6">
                <input type="text" name="active" id="active" class="form-control" value="{{$model['active'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_at" class="col-sm-3 control-label">Created At</label>
            <div class="col-sm-6">
                <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_uid" class="col-sm-3 control-label">Created U</label>
            <div class="col-sm-6">
                <input type="text" name="created_uid" id="created_uid" class="form-control" value="{{$model['created_uid'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
            <div class="col-sm-6">
                <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_uid" class="col-sm-3 control-label">Updated U</label>
            <div class="col-sm-6">
                <input type="text" name="updated_uid" id="updated_uid" class="form-control" value="{{$model['updated_uid'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/examples') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection