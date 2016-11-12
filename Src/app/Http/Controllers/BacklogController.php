<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Backlog as Backlog;
use App\ContributionModel as ContributionModel;

use App\UserStoryModel as UserStoryModel;
use App\ProjectModel as ProjectModel;


class BacklogController extends Controller
{
     public function __construct() {
        $this->backlog = new Backlog();

        $this->contribution_model = new ContributionModel();

        $this->UserStoryModel = new UserStoryModel();

        $this->projects_model = new ProjectModel();


        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $uStories = Backlog::all();
    // return view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function USCreate($id)
    {
        return view('projects.createUS',array('id'=>$id));
    }

    public function USCreate1($id)
    {
        return view('projects.createUS',array('id'=>$id,'status'=>' New User Story added'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
       
        if ( $EditBacklog = Backlog::find($id)) {
            return view('backlog',array('EditBacklog'=>$EditBacklog));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request) {
         
        $this->validate($request,
                [
            'us_description' => 'required|max:500',
            'us_prio' => 'required',
            'us_effort' => 'required',
            'id' =>'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


     public function AddUS(Request $request){
       $this->validate(
            $request,
            [
            'us_description' => 'required',
            'us_effort' => 'required',
            'us_prio' => 'required', 
            'id' => 'required',
                 ]
        );

    $this->UserStoryModel->description = $request->us_description;
    $this->UserStoryModel->id_project = $request->id;
    $this->UserStoryModel->effort = $request->us_effort;
    $this->UserStoryModel->priority = $request->us_prio;
    $this->UserStoryModel->us = $request->id;
    $querry=$this->UserStoryModel->save();

    $Project = ProjectModel::find($request->id);
    $UserStory = $this->UserStoryModel->GetUserStory($request->id);

    if ($querry) {
            //return $EditProject;
       return redirect()->action(
    'BacklogController@USCreate', array('id' => $request->id)
);
            //return view('projects.createUS',array('id'=>$request->id,'status'=>' New User Story added','UserStorys'=>$UserStory));
        
    }else{
            //return $EditProject;
             return back()->withInput();
        }
       
     }

}
