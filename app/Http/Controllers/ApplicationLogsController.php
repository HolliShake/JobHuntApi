<?php
namespace App\Http\Controllers;

use App\Services\application_log\IApplicationLogService;
use Illuminate\Support\Facades\Validator;

class ApplicationLogsController extends ControllerBase
{
    function __construct(protected IApplicationLogService $service) {
    }

    function createEventLog() {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $eventLog = $this->service->create(request()->all());

        return ($eventLog)
            ? $this->created($eventLog)
            : $this->badRequest('');
    }

    function updateEventLog($application_log_id) {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->service->getById($application_log_id);

        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->service->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function deleteEventLog($application_log_id) {
        $old = $this->service->getById($application_log_id);

        if (!$old) {
            return $this->notFound('');
        }

        $result = $this->service->delete($old);

        return ($result)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function updateScore($application_log_id) {
        $validator = Validator::make(request()->all(), [ 'score' => 'required|integer' ]);

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->service->getById($application_log_id);

        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, request()->all());
        $uresult = $this->service->update($updated);

        return ($uresult)
            ? $this->ok($updated)
            : $this->badRequest('');
    }

    function rules() {
        return [
            'event_date' => 'date',
            'event_title' => 'required|string|max:50',
            'event_description' => 'required|string',
            'score' => 'required|numeric',
            'job_applicant_id' => 'required|integer',
        ];
    }
}
