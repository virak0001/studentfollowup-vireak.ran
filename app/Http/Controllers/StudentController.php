<?php

namespace App\Http\Controllers;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('student.create', Student::class);
        $users = User::all();
        return view('student.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::allows('student.create', Student::class)){
            $student =new Student;
            if($request->picture != null){
                request()->validate([
                    'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $imageName = time().'.'.request()->picture->getClientOriginalExtension();
                request()->picture->move(public_path('/img_student/'), $imageName);
                $student -> picture = $imageName;
            }
            $student -> first_name = $request -> get('first_name');
            $student -> last_name = $request -> get('last_name');
            $student -> gender = $request -> get('gender');
            $student -> year = $request -> get('year');
            $student -> user_id = $request ->get('user_id');
            $student -> province = $request -> get('province');
            $student -> class = $request -> get('class');
            $student -> student_id = $request -> get('student_id');
            $student -> save();
            return redirect('/home');
        }else{
            return "you are not addmin";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        return view('student.detail',compact('student'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create', Student::class);
        if(Gate::allows('student.delete', Student::class)){
            $student = Student::find($id);
            $users = User::all();
            return view('student.edit',compact(['student','users']));
        }else{
            return "you are not addmin";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$student)
    {
        $this->authorize('update', Student::class);
        if(Gate::allows('student.update', Student::class)){
            $student =Student::find($student);
            if($request->picture == null){
                $student -> picture = $student->picture;
            }else {
                request()->validate([
                    'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $imageName = time().'.'.request()->picture->getClientOriginalExtension();
                request()->picture->move(public_path('/img_student/'), $imageName);
                $student -> picture = $imageName;
            }
            $student -> first_name = $request -> get('first_name');
            $student -> last_name = $request -> get('last_name');
            $student -> gender = $request -> get('gender');
            $student -> year = $request -> get('year');
            $student -> province = $request -> get('province');
            $student -> user_id = $request ->get('user_id');
            $student -> class = $request -> get('class');
            $student -> student_id = $request -> get('student_id');
            $student -> save();
            return redirect('/home');
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete',Student::class);
        if(Gate::allows('student.delete',Student::class)){
            $student ->delete();
            return back();
        }else{
            return back();
        }
    }

    // add student to follow up list
    public function addToFollowUp($id){
        $this->authorize('update', Student::class);
        $students = Student::find($id);
        $students -> status= true;
        $students -> save();
        return back();
    }

    // remove student from follow up list
    public function outOfFollowUP($id){
        $this->authorize('update', Student::class);
        $students = Student::find($id);
        $students -> status= false;
        $students -> save();
        return back();
    }
}
