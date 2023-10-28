@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card elevation-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-tasks"></i> Create a task</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <form action="{{route('admin.task.store')}}" method="POST">
                                @csrf
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" id="title" name="title" class="form-control"
                                                    value="{{old('title')}}"
                                                    placeholder="Enter ">
                                                @error('title')
                                                <span class="text-danger text-sm pull-right">{{$errors->first('title')}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description"
                                                        placeholder="Enter ">{{old('description')}}</textarea>
                                                @error('description')
                                                <span
                                                    class="text-danger text-sm pull-right">{{$errors->first('description')}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="priority">Priority</label>
                                                <select id="priority" name="priority" class="form-control"
                                                        data-placeholder="Select">
                                                    @foreach($priorities as $priority)
                                                        <option
                                                            value="{{$priority}}" {{old('priority')}}>{{$priority}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('priority')
                                                <span class="text-danger text-sm pull-right">{{$errors->first('priority')}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="due_date">Due Date</label>
                                                <input type="date" id="due_date" name="due_date" class="form-control"
                                                    value="{{old('due_date')}}"
                                                    placeholder="Enter ">
                                                @error('due_date')
                                                <span class="text-danger text-sm pull-right">{{$errors->first('due_date')}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-info"><i class="fas fa-save"></i> Save Task</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

