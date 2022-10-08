@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Example</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Example    </div>

    <div class="panel-body">
                
        <form action="{{ url('/examples'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif


                                                                                                                                                                                                <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="title" class="form-control" value="{{$model['title'] or ''}}">
                </div>
            </div>
                                                                                                                                                                                    <div class="form-group">
                <label for="amount" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-2">
                    <input type="number" name="amount" id="amount" class="form-control" value="{{$model['amount'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="date" class="col-sm-3 control-label">Date</label>
                <div class="col-sm-3">
                    <input type="date" name="date" id="date" class="form-control" value="{{$model['date'] or ''}}">
                </div>
            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/examples') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection