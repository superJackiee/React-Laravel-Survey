<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surveys;
use Webpatser\Uuid\Uuid;

class SurveyController extends Controller
{
    public function validateSurvey(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:127|min:3',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateSurvey($request);

        $survey = new Surveys();
        $survey->name = $request->name;
        $survey->uuid = Uuid::generate(4);
        $survey->description = $request->description;
        $survey->user_id = $request->user_id;
        $survey->branch_id = $request->branch_id;
        $survey->languages = $request->languages;

        $survey->save();
        return response()->json(['uuid' => $survey->uuid->string], 200);
    }

    /**
     * Update the survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        if (Surveys::isRunning($request->uuid) === Surveys::ERR_IS_RUNNING_SURVEY_OK) {
            return response()->json(['message' => 'This survey cannot be updated because it is being run.'], 401);
        }
        $this->validateSurvey($request);
        $survey = Surveys::getByOwner($request->uuid, $request->user()->id);
        
        if (!$survey) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $survey->name = $request->name;
        $survey->description = $request->description;
        $survey->save();
        return response()->json(['message' => 'Success'],  200);
    }

    /**
     * Delete the survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Surveys::isRunning($request->uuid) === Surveys::ERR_IS_RUNNING_SURVEY_OK) {
            return response()->json(['message' => 'This survey cannot be deleted because it is being run'], 401);
        }

        $deleted = Surveys::deleteByOwner($request->uuid, $request->user_id);

        if (!$deleted) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json(['message' => 'Successfully Removed'], 200);
    }
    /**
     * Run the survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllByOwner(Request $request)
    {
        $surveys = Surveys::getAllByOwner($request->user_id);
        return response()->json($surveys);
    }
    /**
     * Run the survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function run(Request $request)
    {
        $survey = Surveys::getByOwner($request->uuid, $request->user_id);
    }

    /**
     * Pause the survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function pause($uuid, Request $request)
    {
        $survey = Surveys::getByOwner($uuid, $request->user()->id);
    }

    /**
     * Return the statistics Result of Survey
     * 
     * @return \Illuminate\Http\Response
     */
    public function stats($s_uuid, Request $request)
    {

    }
}
