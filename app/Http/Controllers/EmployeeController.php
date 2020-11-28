<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Employee::select([
                'id',
                'photo',
                'full_name',
                'position_id',
                'employment_date',
                'phone_number',
                'email',
                'salary'
            ]);
            return datatables()->of($data)
                ->editColumn('employment_date', function (Employee $employee)
                {
                    return date('d.m.y', strtotime($employee->employment_date));
                })
                ->editColumn('position_id', function (Employee $employee)
                {
                    return $employee->position->name;
                })
                ->editColumn('salary', function(Employee $employee)
                {
                    return '$'.number_format($employee->salary,3,',','.');
                })
                ->editColumn('photo', function (Employee $employee)
                {
                    return '<img width="50" height="50" class="rounded-circle" src="'.$employee->photo.'">';
                })
                ->addColumn('actions', function (Employee $employee)
                {
                    return '<div class="d-flex justify-content-between">
                                <a href="' . route('employee.edit', $employee->id) . '" class="btn p-0">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button class="delete-modal btn p-0" data-info="'.$employee->id.', '.$employee->full_name.'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>';
                })->rawColumns(['photo', 'actions'])->make(true);
        }
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $positions = Position::all();
        $employees = Employee::select(['full_name', 'position_id']);
        return view('employee.create', compact('positions', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|min:2|max:256',
            'position_id' => 'required|exists:positions,id',
            'head' => [
                'required',
                'exists:employees,full_name',
                function($attr, $value, $fail) use($request){
                    if (is_null(Employee::whereFullName($value)->first()) or Employee::whereFullName($value)->first()->position_id > $request['position_id'])
                    {
                        $fail($attr . ' must be in the same position or higher.');
                    }
                }
            ],
            'employment_date' => 'required|date_format:d.m.y',
            'phone_number' => ['required','regex:/[+](380)( \()(39|67|68|96|97|98|50|66|95|99|63|93|91|92|94)(\) )[0-9]{3}( )[0-9]{2}( )[0-9]{2}/'],
            'email' => 'required|email',
            'salary' => 'required|min:0|max:500',
            'photo' => 'required|image|mimes:jpeg,png|max:5120|dimensions:min_width=300,min_height=300',
        ]);

        $data['employment_date'] = date('Y.m.d', strtotime($data['employment_date']));
        $data['admin_updated_id'] = $data['admin_created_id'] = auth()->user()->id;

        $data['photo'] = 'storage/' . $data['photo']->store('uploads', 'public');
        Image::configure(['driver' => 'gd']);
        Image::make($data['photo'])->encode('jpg', 80)->orientate()->fit(300,300)->save();

        Employee::whereFullName($data['head'])->first()->subordinates()->create($data);

        return redirect()->route('employee.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $employee
     * @return View
     */
    public function edit(Employee $employee)
    {
        $employees = Employee::select(['full_name', 'position_id']);
        $positions = Position::all();
        $employee['head'] = $employee->head()->getResults()->full_name;
        $employee->employment_date = date('d.m.y', strtotime($employee->employment_date));

        return view('employee.edit', compact('employee', 'employees', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'full_name' => 'required|min:2|max:256',
            'position_id' => 'required|exists:positions,id',
            'head' => [
                'required',
                'exists:employees,full_name',
                function($attr, $value, $fail) use($request){
                    if (is_null(Employee::whereFullName($value)->first()) or Employee::whereFullName($value)->first()->position_id > $request['position_id'])
                    {
                        $fail($attr . ' must be in the same position or higher.');
                    }
                }
            ],
            'employment_date' => 'required|date_format:d.m.y',
            'phone_number' => ['required','regex:/[+](380)( \()(39|67|68|96|97|98|50|66|95|99|63|93|91|92|94)(\) )[0-9]{3}( )[0-9]{2}( )[0-9]{2}/'],
            'email' => 'required|email',
            'salary' => 'required|min:0|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5120|dimensions:min_width=300,min_height=300',
        ]);

        if (!key_exists('photo', $data) or $data['photo'] == null)
        {
            $data['photo'] = $employee->photo;
        }
        else {
            $data['photo'] = 'storage/' . $data['photo']->store('uploads', 'public');
            Image::configure(['driver' => 'gd']);
            Image::make($data['photo'])->encode('jpg', 80)->orientate()->fit(300,300)->save();
            unlink($employee->photo);
        }

        $data['employment_date'] = date('Y.m.d', strtotime($data['employment_date']));
        $data['admin_updated_id'] = auth()->user()->id;

        $employee->update($data);

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Select a deputy based on the hierarchy
     *
     * @param $emp_id
     * @param $pos_id
     * @return mixed
     */
    public function findDeputy($emp_id, $pos_id)
    {
        if(Employee::all()->where('position_id', '=', $pos_id)->where('id', '!=', $emp_id)->count() != 0)
        {
            return Employee::all()->where('position_id', '=', $pos_id)->where('id', '!=', $emp_id)->first();
        } else {
            if(Employee::find($emp_id)->getAttribute('position_id') >= $pos_id)
            {
                if($pos_id == 1)
                {
                    return $this->findDeputy($emp_id, Employee::find($emp_id)->getAttribute('position_id') + 1);
                } else {
                    return $this->findDeputy($emp_id, $pos_id - 1);
                }
            } else {
                return $this->findDeputy($emp_id, $pos_id + 1);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee->subordinates()->count() >= 1)
        {
            if(!($employee->subordinates()->count() == 1 && $employee->subordinates()->first()->id == $employee->id))
            {
                $new_boss = $this->findDeputy($id, $employee->position_id);
                $employee->subordinates()->update(['head_id' => $new_boss->id]);
            }
        }
        if($employee->getAttribute('head_id') == $employee->id)
        {
            $employee->update(['head_id' => null]);
        }
        unlink($employee->photo);
        $employee->delete();

        return response()->json(['success' => 'Employee deleted successfully']);
    }

}
