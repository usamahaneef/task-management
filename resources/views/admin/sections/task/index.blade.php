@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card elevation-0">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tasks"></i> Tasks</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.task.create')}}" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Create a new task</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex justify-content-end py-3">
                            <form action="{{ route('admin.task.filter') }}" method="get">
                                <div class="d-flex align-items-center">
                                    <label for="status" class="mr-2">Filter by Status:</label>
                                    <div class="form-group mb-0">
                                        <select id="status" name="status" class="form-control py-2" data-placeholder="Select">
                                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All</option>
                                            <option value="Complete" {{ request('status') === 'Complete' ? 'selected' : '' }}>Complete</option>
                                            <option value="Incomplete" {{ request('status') === 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                                        </select>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-info ml-2">Apply</button>
                                </div>
                                
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-borderless">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>  
                                        <th>Date</th> 
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tasks as $key => $task)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td><span class="badge badge-info">{{$task->title}}</span></td>
                                            <td>
                                                <span class="badge badge-secondary">{{($task->description)}}</span>
                                            </td>
                                            <td>{{$task->due_date}}</td>
                                            <td>
                                                @if($task->priority == 'Urgent')
                                                    <span class="badge badge-danger">{{$task->priority}}</span>
                                                @else
                                                    {{$task->priority}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($task->status == 'Complete')
                                                    <span class="badge badge-success">Complete</span>
                                                @else
                                                    <span class="badge badge-warning">Incomplete</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('admin.task.edit' , $task)}}"
                                                class="btn btn-outline-info btn-xs"><i class="fas fa-edit"></i></a>

                                                <button type="button" data-target="#modal-{{ $task->id }}"
                                                    data-toggle="modal" class="btn btn-xs btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <div id="modal-{{ $task->id }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete Task</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Do you really wish to delete this task?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{route('admin.task.delete' , $task)}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="button" class="btn btn-sm btn-default"
                                                                        data-dismiss="modal">No</button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger">Yes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No records found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

