<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use App\Models\OrdersTasks;
use Illuminate\Http\Request;
use Session;
use DB;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        return view('admin.Tasks.index', $data);
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
    public function store(Request $request)
    {
        if(!empty($request->id)){
            $task = Tasks::where('id', $request->id)->first();
        } else {
            $task = new Tasks();
        }
        $task->task_name = !empty($request->task_name) ? $request->task_name : NULL;
        $task->save();
        $return = array();
        if($task->id){
            if(!empty($request->id)){
                $return['success'] = "Updated";
            } else {
                $return['success'] = "Added";
            }
        }
        print json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $return = array();
        $return['task_data'] = Tasks::find($id);
        print json_encode($return);
        exit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks)
    {
        //
    }

    public function getTasksDatatable(Request $request) {
        $data = $request->all();
        $search_value = trim($data['search']['value']);
        $user = auth()->user();
        $taskQuery = Tasks::select(DB::raw('*'))
            ->when($search_value, function ($taskQuery) use ($search_value,$request) {
                return $taskQuery->where(function ($taskQuery) use ($search_value,$request) {
                    /** @var Builder $taskQuery */
                    $preparedQ = '%' .$search_value. '%';
                    $num = 0;
                    foreach (
                        [
                            'task_name',
                        ] AS $field
                    ) {
                        if ($num) {
                            $taskQuery = $taskQuery->orWhere($field, 'LIKE', $preparedQ);
                        } else {
                            $taskQuery = $taskQuery->where($field, 'LIKE', $preparedQ);
                        }
                        $num++;
                    }
                    return $taskQuery;
                });
            });
        $taskQuery->orderBy('created_at', 'DESC');
        return datatables()->of($taskQuery)->toJson();
    }

    public function taskDelete(Request $request)
    {
        $task = Tasks::find($request->delete_task_id);
        $order_detail = OrdersTasks::where('task_id', $request->delete_task_id)->get();
        if($order_detail->count()>0){
            \Session::flash('status', 'danger');
            \Session::flash('message', "Task not allow to delete. Because it's Used.");
            return redirect()->back();
        } else {
            $task->delete();
            \Session::flash('status', 'success');
            \Session::flash('message', 'Task Successfully Deleted.');
        }
        return redirect()->back();
    }
}
