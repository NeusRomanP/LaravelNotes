<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class NoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        
        $notes = $user->notes()->orderBy('id')->get();

        return view('notes.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("notes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $note = new Note();
        $note->title = $data['title'];
        $note->content = $data['note'];
        $note->creator_id = Auth::id();
        //dd($note->title."-".$note->content."-".$user->id);

        $note->save();
        $note->users($note)->attach($user->id);

        $user = User::find(Auth::id());
        
        $notes = $user->notes()->orderBy('id')->get();

        return redirect()->route('notes.index', ['notes' => $notes]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note=Note::find($id);
        $creator = User::find($note->creator_id);
        $exceptions=[];
        foreach ($note->users($note)->get() as $exception){
            
            array_push($exceptions, $exception->id);
        }
        $users=User::all()->except($exceptions);
        $sharedWith = User::findMany($exceptions);
        if($note->users($note)->where('id', Auth::id())->exists()){
            return view("notes.show", ['note' => $note, 'users'=>$users, 'creator'=>$creator, 'sharedWith'=>$sharedWith]);
        }
        return redirect('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note=Note::find($id);
        if($note->users($note)->where('id', Auth::id())->exists()){
            return view("notes.show", ['note' => $note]);
        }
        return redirect('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $note = Note::find($id);
        $note->title = $data['title'];
        $note->content = $data['content'];

        $users=[];

        
        if(isset($data['users'])){
            foreach($data['users'] as $user){
                array_push($users, $user);
            }
            
        }
        


        $note->save();
        
        foreach($users as $user){
            $userId = User::where("name", $user)->first();
            
            $note->users($note)->attach($userId['id']);
        }

        $currentUser = User::find(Auth::id());
        
        $notes = $currentUser->notes()->orderBy('id')->get();

        return redirect()->route('notes.index', ['notes' => $notes]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note=Note::find($id);
        if($note->users($note)->wherePivot('user_id', Auth::id())->exists()){
            $note->users($note)->detach(Auth::id());
            if($note->users($note)->count()==0){
                $note->delete();
            }
        }

        $user = User::find(Auth::id());
        
        $notes = $user->notes()->orderBy('id')->get();

        return redirect('notes')->with('notes', $notes);
    }

    public function getUsers(Request $request, $id, $user){
        $note=Note::find($id);

        $data = $request->all();
        $shared = $data["shared"];
        $exceptions=[];
        foreach ($note->users($note)->get() as $exception){
            
            array_push($exceptions, $exception->id);
        }

        foreach($shared as $sharedUser){
            $exception=User::where("name", $sharedUser)->first();
            array_push($exceptions, $exception->id);
        }

        $users=User::where("name", $user)->orWhere('name', 'like', '%' . $user . '%')->get()->except($exceptions)->take(3);


        return $users;
    }
}
