@extends('layouts.frontend.app')
@section('body')
<div class="card">
  <div class="container-fluid">
    <h4 class="page-title text-center">Detail Information Of Student</h4>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-3">
              <img class="mx-auto d-block" src="{{asset('img_student/'.$student->picture)}}" width="120" style="border-radius: 5px;" height="120" alt="User" />
            </div>
            <div class="col-12 col-sm-12 col-md-9">
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <P><strong>NAME : </strong>{{$student->first_name}}.{{$student->last_name}}</P>
                    </div>
                    <div class="col-6 col-sm-6">
                        <P><strong>Class : </strong>{{$student->class}}</P>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <P><strong>Year : </strong>{{$student->year}}</P>
                    </div>
                    <div class="col-6 col-sm-6">
                        <P><strong>ID : </strong>{{$student->student_id}}</P>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <P><strong>Status : </strong>
                            @if ($student->status == false)
                                Achieve Student
                            @else    
                                Follow Up                            
                            @endif
                        </P>
                    </div>
                    <div class="col-6 col-sm-6">
                        @if ($student->user_id == null)
                           <p><strong>Tutor : </strong><i>No tutor</i></p>
                        @else
                         <p><strong>Tutor : </strong> {{$student->user['first_name']}}.{{$student->user['last_name']}}</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                  <div class="col-6 col-sm-6">
                      <P><strong>Province : </strong>{{$student->province}}</P>
                    </div>
                    <div class="col-6 col-sm-6">
                      <P><strong>Gender : </strong>{{$student->gender}}</P>
                  </div>
              </div>
            </div>
        </div>
        <br>
        <div class="card-header">
          @if ($student->status == 1)
            Please leave your comments
                
            @endif
            @foreach ($student->comments as $comment)
            <div class="row">
              <div class="col-1">
                <img class="profile-image" src="{{asset('assets/img/'.$comment->user['profile'])}}" width="40" height="40" style="border-radius: 50%;" alt="User" />
              </div>
              <div class="col-11">
                <small class="ml-2">{{$comment->user['first_name']}}.{{$comment->user['last_name']}}</small><br>
                <p style="font-size:16px">
                  {{$comment->comment}}
                  @if (Auth::id() == $comment->user['id'])
                  <a onclick="getValue({{$comment->id}})" style="cursor: pointer"><i class="material-icons text-primary" data-toggle="tooltip" data-placement="top" title="edit" style="font-size:10px">edit</i></a>
                  <a onclick="document.getElementById('{{'comment'.$comment->id}}').submit()" href="#"><i class="material-icons text-primary" data-toggle="tooltip" data-placement="top" title="delete" style="font-size:10px">delete</i></a><br>
                    <form id="{{'comment'.$comment->id}}" action="{{route('comment.destroy',$comment->id)}}" method="post">
                      @csrf
                      @method('delete')
                    </form>
                  @endif
                  </p>
              </div>
            </div>
            @endforeach
          </div>
          <div class="card-footer">
            @if ($student->status == 1)
              <form id="inserComment" action="{{route('comment.store',$student->id)}}" method="post">
                @csrf
                @method('PUT')
                <textarea name="comment" class="form-control" cols="52" rows="3" placeholder="Please write you comment"></textarea>
                <a href="#" class="btn btn-sm btn-success mt-1 id="send" onclick="document.getElementById('inserComment').submit()">POST</a>
              </form>
            @endif
            <form id="editForm" method="post">
              @csrf
              @method('PUT')
              <textarea id="editComment" name="comment" class="form-control" cols="52" rows="3" placeholder="Edit comment"></textarea>
              <a href="#" id="send" onclick="document.getElementById('editForm').submit()"><i class="material-icons" style="margin-top:3px;">send</i></a>
            </form>
          </div>
    </div>
</div>
<script>
    document.getElementById("editForm").hidden = true;
    function getValue(value) {
      document.getElementById("inserComment").hidden = true;
      document.getElementById("editForm").hidden = false;
      @foreach($student -> comments as $comment)
      var data = '{{$comment->id}}';
      if (data == value) {
        $('#editForm').attr('action', "{{route('comment.update',[$comment->id])}}");
        document.getElementById("editComment").innerHTML = `{{$comment->comment}}`;
      }
      @endforeach
    }
  </script>
@endsection