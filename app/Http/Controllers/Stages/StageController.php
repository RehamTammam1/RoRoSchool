<?php 
namespace App\Http\Controllers\Stages;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Stage;
use Exception;
use Illuminate\Http\Request;
use Mockery\ExpectationInterface;

class StageController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $stages = Stage::all();
    $grades = Grade::all();
    return view('stages.stage_list',\compact('stages','grades'));
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $records = $request->input('group-a');
    //dd($records);
     $this->validate($request,[
     'group-a.*.Name'=>'required',
      'group-a.*.Name_en'=>'required',
      'group-a.*.grade_id'=>'required'
     ]);
    
      try{
         foreach($records as $record ){
          $stage = new Stage;
          $stage->name = ['en'=>$record['Name_en'],'ar'=>$record['Name']];
          $stage->grade_id = $record['grade_id'];
          $stage->save();
        }
 
       flash()->success(trans('message.success'));
       return redirect()->route('stages.index');
  
      }catch(Exception $e){

        return redirect()->back()->withErrors([trans('message.unsuccessful_operation')]);

      }   
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request)
  {
    
      try{
        $stage = Stage::find($request->id);
        $stage->name = ['en'=>$request->Name_en,'ar'=>$request->Name] ;
        $stage->grade_id = $request->grade_id;
        $stage->save();
        flash()->success(trans('message.success'));
        return redirect()->route('stages.index');

      }catch(Exception $e){
        return redirect()->back()->withErrors([trans('message.unsuccessful_operation')]);
      } 



  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request){

    try{
      Stage::find($request->id)->delete();
      flash()->success(trans('message.delete'));
      return redirect()->route('stages.index');
    }
    catch(Exception $e){
      return redirect()->back()->withErrors([trans('message.unsuccessful_operation')]);

    }
    
 
  
  }
  
}

?>