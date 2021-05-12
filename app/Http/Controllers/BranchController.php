<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branchs;
use Auth;

class BranchController extends Controller
{
    public function validateBranch(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:127|min:3|unique:branchs',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateBranch($request);

        $branch = new Branchs();

        $branch->name = $request->name;
        $branch->country = $request->country;
        $branch->city = $request->city;
        $branch->picture = $request->picture;
        $branch->owner_id = Auth::user()->id;
        $branch->manager_id = $request->manager_id;

        $branch->save();
        return response()->json(['id' => $branch->id], 200);
    }

    /**
     * Update the branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validateBranch($request);
        $branch = Branchs::getById($request->id);

        $branch->name = $request->name;
        $branch->country = $request->country;
        $branch->city = $request->city;
        $branch->picture = $request->picture;
        $branch->save();
        return response()->json(['message' => 'Update Success'], 200);
    }

    public function destroy(Request $request)
    {
        $deleted = Branchs::destroyByOwner($request->id);
        
        if(!$deleted) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json(['message' => 'Successfully Removed'], 200);
    }

    public function getAllByOwner(Request $request)
    {
        $branchs = Branchs::getAllByOwner(Auth::user()->id);

        return response()->json($branchs);
    }
}
