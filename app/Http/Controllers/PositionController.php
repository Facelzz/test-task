<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
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
            $data = Position::latest()->get();
            return datatables()->of($data)
                ->addColumn('last_updated', function(Position $position)
                {
                    return date('d.m.y', strtotime($position->getAttribute('updated_at')));
                })
                ->addColumn('actions', function(Position $position)
                {
                    return '<div class="d-flex justify-content-between">
                                <a href="' . route('position.edit', $position) . '" class="btn p-0">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button class="delete-modal btn p-0" data-info="'.$position->id.', '.$position->getAttribute('name').'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>';
                })->rawColumns(['actions'])->make(true);
        }

        return view('position.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('position.create');
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
            'name' => 'required|string|min:2|max:256',
        ]);

        $data['admin_created_id'] = $data['admin_updated_id'] = auth()->user()->id;
        Position::create($data);

        return redirect()->route('position.index')->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Position $position
     * @return View
     */
    public function show(Position $position)
    {
        return view('position.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Position $position
     * @return View
     */
    public function edit(Position $position)
    {
        return view('position.edit',compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Position $position
     * @return RedirectResponse
     */
    public function update(Request $request, Position $position)
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:256',
        ]);

        $data['admin_updated_id'] = auth()->user()->id;

        $position->update($data);

        return redirect()->route('position.index')->with('success', 'Position updated successfully.');
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
        if(Position::all()->count() <= 1)
        {
            return response()->json(['failed' => 'You can not delete last position! Please, create at least one more before delete.']);
        }

        $position = Position::find($id);

        if($position->employees()->count() > 0)
        {
            if(Position::where('id', '>', $id)->count() > 0)
            {
                $position->employees()->update(['position_id' => Position::where('id', '>', $id)->first()->id]);
            }
            else {
                $position->employees()->update(['position_id' => Position::where('id', '<', $id)->first()->id]);
            }
        }

        $position->delete();

        return response()->json(['success' => 'Position deleted successfully']);
    }
}
