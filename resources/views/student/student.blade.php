@extends('layouts.frontend.app')
@section('body')
  <div class="container-fluid">
    <h4 class="page-title">Dashboard</h4>
    <div class="row">
      <div class="col-12">
        <div class="row d-flex justify-content-between">
            @can('student.create',Student::class)
                <a href="{{route('student.create')}}"><i class="material-icons ml-5" style="margin-top:-5px; font-size:50px">add_circle</i></a>
            @endcan
            <p style="margin-right:30px" class="ml-3"><span class="badge badge-primary">Male</span>&nbsp;<span class="badge badge-danger">Female</span></p>
        </div>
        <div class="col-12 text-center">
          <h5 class="card-category">Student Information<span class="badge badge-primary"></span></h5>
        </div>
      </div>
    </div>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">FollowUp</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Achieve</a>
      </div>
    </nav>
    <br>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th class="th-sm">Profile</th>
                  <th class="th-sm">Name</th>
                  <th class="th-sm">Class</th>
                  @can('student.view', Student::class)
                  <th class="th-sm">Status</th> 
                  @endcan
                  <th class="th-sm">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($students as $student)
                @if ($student->status == 1)
                <tr>
                  <td><img src="{{asset('img_student/'.$student->picture)}}" width="40" style="border-radius: 25px;" height="40" alt="User" /></td>
                  <td>{{$student->first_name}}.{{$student->last_name}}</td>
                  <td>{{$student->class}}</td>
                  @can('student.view', Student::class)
                  <td>
                   <div class="dropdown">
                    <a class="text-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">Follow Up</a>
                    <ul class="dropdown-menu">
                      <form id="submit" method="POST" action="{{route('outOfFollowUP',$student->id)}}">
                        @csrf
                        @method('PUT')
                        <span><button class="btn" style="cursor:pointer">Out of FollowUp</button></span>
                      </form>
                    </ul>
                  </div>
                </td>
                @endcan
                  <td>
                    @can('student.update', Student::class)
                      <a href="{{route('editStudent.edit',$student->id)}}"><span class="material-icons">edit</span></a>
                    @endcan
                    {{-- delete student --}}
                    @can('student.delete', Student::class)
                    <a class="text-primary" tabindex="-1" type="button" data-toggle="modal" data-backdrop="false" aria-hidden="true" data-target="#exampleModal{{$student->id}}" href="#"><i class="material-icons">delete</i></a>
                    <!-- Modal Delete Student    -->
                    <div class="modal fade modal-open" id="exampleModal{{$student->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure want to delelte?
                          </div>
                          <div class="modal-footer">
                            <form method="POST" action="{{route('student.destroy',$student->id)}}">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endcan
                    <a href="{{route('student.show',$student->id)}}"><span class="material-icons">details</span></a>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th class="th-sm">Profile</th>
                  <th class="th-sm">Name</th>
                  <th class="th-sm">Class</th>
                  @can('student.view', Student::class)
                  <th class="th-sm">Status</th> 
                  @endcan
                  <th class="th-sm">Action</th>
                </tr>
              </tfoot>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="table-responsive">
          <table id="achieve" class="table table-striped text-center" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">Profile</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">Class</th>
                @can('student.view', Student::class)
                <th class="th-sm">Status</th> 
                @endcan
                <th class="th-sm">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                @if ($student->status == 0)
                <tr>
                  <td><img src="{{asset('img_student/'.$student->picture)}}" width="40" style="border-radius: 25px;" height="40" alt="User" /></td>
                  <td>{{$student->first_name}}.{{$student->last_name}}</td>
                  <td>{{$student->class}}</td>
                  @can('student.view', Student::class)
                  <td>
                    <div class="dropdown">
                      <a class="text-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">Achive</a>
                      <ul class="dropdown-menu">
                        <form type="submit" method="POST" action="{{route('addToFollowUp',$student->id)}}">
                          @csrf
                          @method('PUT')
                          <span><button class="btn" style="cursor:pointer">add to follow up</button></span>
                        </form>
                      </ul>
                    </div>
                  </td>
                  @endcan
                  <td>
                      @can('student.update', Student::class)
                      <a href="{{route('editStudent.edit',$student->id)}}"><span class="material-icons">edit</span></a>
                      @endcan
                     {{-- delete student --}}
                    @can('student.delete', Student::class)
                    <a class="text-primary" tabindex="-1" type="button" data-toggle="modal" data-backdrop="false" aria-hidden="true" data-target="#exampleModal{{$student->id}}" href="#"><i class="material-icons">delete</i></a>
                    <!-- Modal Delete Student    -->
                    <div class="modal fade modal-open" id="exampleModal{{$student->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure want to delelte?
                          </div>
                          <div class="modal-footer">
                            <form method="POST" action="{{route('student.destroy',$student->id)}}">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endcan
                    <a href="{{route('student.show',$student->id)}}"><span class="material-icons">details</span></a>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            <tfoot>
              <tr>
                <th class="th-sm">Profile</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">Class</th>
                @can('student.view', Student::class)
                <th class="th-sm">Status</th> 
                @endcan
                <th class="th-sm">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection