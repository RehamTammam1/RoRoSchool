<?php 
namespace App\Http\Controllers\Grades;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Grade as ModelsGrade;
use Exception;
use Flasher\Laravel\Http\Request;
use Illuminate\Http\Request as HttpRequest;

use function PHPSTORM_META\type;

class GradeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $grades = ModelsGrade::all();
    
    return view('grades.gradelist',compact('grades'));

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
  public function store(StoreGradeRequest $request)
  {
      //validate the request
      $validated = $request->validated();

      if(ModelsGrade::where('Name->ar',$request->Name)->
                orWhere('Name->en',$request->Name_en)->
                exists()){
        return redirect()->back()->withErrors([trans('message.duplicate_grade')]);
      }

      try{
        $grade = new ModelsGrade();
        $grade->Name = ['en'=>$request->Name_en,'ar'=> $request-> Name];
        $grade->Notes = $request->Notes ;
        $grade->save();
        flash()->success(trans('message.success'));
        return redirect()->route('grades.index');
      }
      catch(Exception $e){

        return redirect()->back()->withErrors(['error'=> $e->getMessage()]);

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
  public function update(StoreGradeRequest $request)
  {    
 
    $validated = $request->validated();
    
    try{

        $grade = ModelsGrade::find($request->id);
        $grade->Notes = $request->Notes;
        $grade->Name = ['en'=>$request->Name_en,'ar'=> $request-> Name];
        $grade->save();
        flash()->success(trans('message.update'));
        return redirect()->route('grades.index');
 
    }catch(Exception $e){
        return redirect()->back()->withErrors(['error'=> $e->getMessage()]);
    }

   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(HttpRequest $request)
  {
    try{

      $grades = ModelsGrade::find($request->id);
      
      if($grades->stages()->exists()){

        flash()->error(trans('message.grade_delete_restrection'));
        return redirect()->back();
      }
      $grade = ModelsGrade::find($request->id);
      $grade->delete();
      flash()->success(trans('message.delete'));
      return redirect()->route('grades.index');
    }
    catch(Exception $e){
      return redirect()->back()->withErrors(['error'=> $e->getMessage()]);

    }
 
  }
  
}

?>