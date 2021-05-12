<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @param array
     */
    protected $fillable = [
        'name', 'description', 'languages', 'user_id', 'branch_id',
    ];  

    /***************************************************************/
    public static function getAllByOwner($user_id)
    {
        return self::where('user_id', '=', $user_id)
        ->orderBy('updated_at', 'desc');
    }

    /************************************************/

    public static function getByOwner($uuid, $user_id)
    {
        return (
        $surveys = self::where('user_id', '=', $user_id)
            ->where('uuid', '=', $uuid)
            ->limit(1)
            ->get()
        ) &&
          count($surveys) === 1
        ? $surveys[0]
        : null;
    }

    /************************************************/

    public static function deleteByOwner($uuid, $user_id)
    {
        return self::where([
            'user_id' => $user_id,
            'uuid'    => $uuid,
        ])->delete();
    }

    /************************************************/

    const ERR_RUN_SURVEY_OK = 0;
    const ERR_RUN_SURVEY_NOT_FOUND = 1;
    const ERR_RUN_SURVEY_INVALID_STATUS = 2;
    const ERR_RUN_SURVEY_ALREADY_RUNNING = 3;

    public static function run($uuid, $user_id)
    {
        $survey = self::getByOwner($uuid, $user_id);

        if (!$survey) {
            return self::ERR_RUN_SURVEY_NOT_FOUND;
        }

        if ($survey->status === 'ready') {
            return self::ERR_RUN_SURVEY_ALREADY_RUNNING;
        }

        $mocked_invalid_status = Helper::getTestEnvMockVar('Surveys::ERR_RUN_SURVEY_INVALID_STATUS', $survey->status !== 'draft');

        if ($mocked_invalid_status) {
            return self::ERR_RUN_SURVEY_INVALID_STATUS;
        }

        $survey->status = 'ready';
        $survey->save();

        return self::ERR_RUN_SURVEY_OK;
    }

    /************************************************/

    const ERR_PAUSE_SURVEY_OK = 0;
    const ERR_PAUSE_SURVEY_NOT_FOUND = 1;
    const ERR_PAUSE_SURVEY_INVALID_STATUS = 2;
    const ERR_PAUSE_SURVEY_ALREADY_PAUSED = 3;

    public static function pause($uuid, $user_id)
    {
        $survey = self::getByOwner($uuid, $user_id);

        if (!$survey) {
            return self::ERR_PAUSE_SURVEY_NOT_FOUND;
        }

        if ($survey->status === 'draft') {
            return self::ERR_PAUSE_SURVEY_ALREADY_PAUSED;
        }

        $mocked_invalid_status = Helper::getTestEnvMockVar('Surveys::ERR_PAUSE_SURVEY_INVALID_STATUS', $survey->status !== 'ready');

        if ($mocked_invalid_status) {
            return self::ERR_PAUSE_SURVEY_INVALID_STATUS;
        }

        $survey->status = 'draft';
        $survey->save();

        return self::ERR_PAUSE_SURVEY_OK;
    }

    /************************************************/

    public static function getAvailables()
    {
        return DB::table('surveys')
            ->select('surveys.*', 'users.firstName as author_name')
            ->join('users', 'users.id', '=', 'surveys.user_id')
            ->where('surveys.status', '=', 'ready')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /************************************************/

    const ERR_IS_RUNNING_SURVEY_OK = 0;
    const ERR_IS_RUNNING_SURVEY_NOT_FOUND = 1;
    const ERR_IS_RUNNING_SURVEY_NOT_RUNNING = 2;

    public static function isRunning($uuid)
    {
        $survey = self::getByUuid($uuid);

        if (!$survey) {
            return self::ERR_IS_RUNNING_SURVEY_NOT_FOUND;
        }

        return $survey->status === 'ready' ? self::ERR_IS_RUNNING_SURVEY_OK : self::ERR_IS_RUNNING_SURVEY_NOT_RUNNING;
    }

    /************************************************/

    public static function getByUuid($uuid)
    {
        $surveys = self::where('uuid', '=', $uuid)
            ->limit(1)
            ->get();

        return $surveys && count($surveys) === 1 ? $surveys[0] : null;
    }
}
