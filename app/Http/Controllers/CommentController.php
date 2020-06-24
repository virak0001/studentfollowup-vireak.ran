<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\User;
use App\Student;

class CommentController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $this->authorize('comment.create',$id);
        if (Gate::allows('comment.create', $id)) {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user_email = User::all();
        $to_email = $user_email->pluck("email")->toArray();
        $user = Auth::user();
        $student = Student::find($id);

        $data = array("application"=>"virakcambodia44@gmail.com","from"=>$user->email,"body"=>$request->comment,"email"=>$to_email,"subject"=>"Comment on ".$student->first_name.'.'.$student->last_name);
        
        $job = (new SendEmail($data,$user))
            ->delay(Carbon::now()->addSeconds(5));
             dispatch($job);

        $comment =new Comment;
        $comment -> student_id = $id;
        $comment -> user_id = Auth::id();
        $comment -> comment = $request -> get('comment');
        $comment -> save();
        return redirect()->back();
    }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->authorize('comment.update',$id);
        if (Gate::allows('comment.update', $id)) {
            $comment = Comment::find($id);
            $comment -> comment = $request -> get('comment');
            $comment -> save();
            return back();
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('comment.delete',$id);
            if (Gate::allows('comment.delete', $id)) {
                $comment = Comment::find($id);
                $comment ->delete();
                return back();
            }
    }
}
