<?php

namespace App\Http\Controllers;

use App\Helpers\EventNotificationUtility;
use App\Helpers\ResponseStatusCodes;
use App\Http\Requests\Education\AddEventRequest;
use App\Http\Requests\Education\UpdateEventRequest;
use App\Http\Resources\Education\EventBasicResource;
use App\Http\Resources\Education\EventInvitationWithEventResource;
use App\Http\Resources\Education\EventRegistrationResource;
use App\Http\Resources\Education\EventRegistrationWithEventResource;
use App\Http\Resources\Education\EventResource;
use App\Jobs\GenerateAndSendCertificateJob;
use App\Models\Education\Event;
use App\Models\Education\EventInvitePosition;
use App\Models\Education\EventNotification;
use App\Models\Education\EventNotificationDates;
use App\Models\Education\EventRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class EventController extends Controller
{

    protected $certPaperSize = array(0, 0, 800, 480);

    public function view($eventId)
    {
        if (!$event = Event::find($eventId)) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Record not found");
        }
        return successResponse('Successful', EventResource::make($event));
    }

    public function list(Request $request)
    {
        $query = Event::query()->where('is_del', 0);

        // Filter by event name
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by start date
        if ($request->from_date) {
            $query->where('date', '>', $request->from_date);
        }

        // Filter by end date
        if ($request->to_date) {
            $query->where('date', '<', $request->to_date);
        }

        // Filter for past events
        if (!$request->show_past_events || $request->show_past_events == "0" || $request->show_past_events == "false" && !($request->from_date || $request->to_date)) {
            // Filter for events with a date greater than or equal to today
            $query->whereDate('date', '>=', Carbon::today());
        }

        // Get the paginated results
        $events = $query->latest()->paginate(500);

        // Return the response
        return EventBasicResource::collection($events);
    }

    public function add(AddEventRequest $request)
    {
        $validated = $request->validated();

        // Store the image
        $imagePath = null;

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('event_images', $imageName, 'public');
        }

        // validate the notification dates
        $validRegisteredDates = [];
        $validUnregisteredDates = [];

        // split $validated['unregistered_remainder_dates'] by comma.
        // Validate each date to be YYYY-MM-DD
        // Add to $validUnregisteredDates;

        if ($validated['registered_remainder_dates']) {
            $dateArr = $this->stringToDateArray($validated['registered_remainder_dates']);

            if (is_string($dateArr)) {
                return errorResponse(1, $dateArr);
            }

            $validRegisteredDates = $dateArr;
        }

        if ($validated['unregistered_remainder_dates']) {

            $dateArr = $this->stringToDateArray($validated['unregistered_remainder_dates']);

            if (is_string($dateArr)) {
                return errorResponse(1, $dateArr);
            }

            $validUnregisteredDates = $dateArr;
        }

        unset($validated['registered_remainder_dates'], $validated['unregistered_remainder_dates'], $validated['img']);

        $validated['image'] = $imagePath;
        $validated['user_id'] = $request->user()->id;

        $event = Event::create($validated);

        if (!empty($validRegisteredDates)) {
            collect($validRegisteredDates)->each(function ($notificationDate) use ($event) {
                EventNotificationDates::create([
                    'type' => 'Registered',
                    'event_id' => $event->id,
                    'reminder_date' => $notificationDate,
                ]);
            });
        }

        if (!empty($validUnregisteredDates)) {
            collect($validUnregisteredDates)->each(function ($notificationDate) use ($event) {
                EventNotificationDates::create([
                    'type' => 'Unregistered',
                    'event_id' => $event->id,
                    'reminder_date' => $notificationDate,
                ]);
            });
        }

        // Get the positions from the request
        $requestedPositions = $request->input('positions');

        //Notify newly added AR
        $this->addInviteesToEvent($event, $requestedPositions);

        $logMessage = "Added a new Event: $event->name";
        logAction($request->user()->email, 'Add Event', $logMessage, $request->ip());

        return successResponse('Successful', EventResource::make($event));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $validated = $request->validated();

        // Store the image
        if (isset($validated['img']) && $request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('event_images', $imageName, 'public');

            $validated['image'] = $imagePath;
            unset($validated['img']);
        }

        // validate the notification dates

        // split dates by comma.
        // Validate each date to be YYYY-MM-DD
        // Add to $validUnregisteredDates;

        if (isset($validated['registered_remainder_dates'])) {

            $validRegisteredDates = [];

            if ($validated['registered_remainder_dates']) {
                $dateArr = $this->stringToDateArray($validated['registered_remainder_dates']);

                if (is_string($dateArr)) {
                    return errorResponse(ResponseStatusCodes::BAD_REQUEST, $dateArr);
                }

                $validRegisteredDates = $dateArr;
            }

            // clear the existing records
            EventNotificationDates::where('type', 'Registered')->where('event_id', $event->id)->delete();

            if (!empty($validRegisteredDates)) {
                collect($validRegisteredDates)->each(function ($notificationDate) use ($event) {
                    EventNotificationDates::create([
                        'type' => 'Registered',
                        'event_id' => $event->id,
                        'reminder_date' => $notificationDate,
                    ]);
                });
            }

            unset($validated['registered_remainder_dates']);
        }

        if (isset($validated['unregistered_remainder_dates'])) {
            $validUnregisteredDates = [];

            if ($validated['unregistered_remainder_dates']) {

                $dateArr = $this->stringToDateArray($validated['unregistered_remainder_dates']);

                if (is_string($dateArr)) {
                    return errorResponse(ResponseStatusCodes::BAD_REQUEST, $dateArr);
                }

                $validUnregisteredDates = $dateArr;
            }

            EventNotificationDates::where('type', 'Unregistered')->where('event_id', $event->id)->delete();

            if (!empty($validUnregisteredDates)) {
                collect($validUnregisteredDates)->each(function ($notificationDate) use ($event) {
                    EventNotificationDates::create([
                        'type' => 'Unregistered',
                        'event_id' => $event->id,
                        'reminder_date' => $notificationDate,
                    ]);
                });
            }

            unset($validated['unregistered_remainder_dates']);
        }

        if ($validated) { // there is something to update
            $event->update($validated);
            $logMessage = "Updated an Event: $event->name";
            logAction($request->user()->email, 'Update Event', $logMessage, $request->ip());

            $event->refresh();
        }

        // Get the positions from the request
        $requestedPositions = $request->input('positions', []);

        //Notify newly added AR
        if ($requestedPositions) {
            $this->addInviteesToEvent($event, $requestedPositions);
        } else {
            EventNotificationUtility::eventUpdated($event);
        }

        return successResponse('Successful', EventResource::make($event));
    }

    public function updateInvitePositions(Request $request, Event $event)
    {
        $request->validate([
            'positions' => 'required|array', // Ensure 'positions' is present and is an array
            'positions.*' => [
                'integer',
                Rule::exists('positions', 'id'), // Ensure each position ID exists in the 'positions' table
            ],
        ]);
        // Get the positions from the request
        $requestedPositions = $request->input('positions');

        //Notify newly added AR
        $this->addInviteesToEvent($event, $requestedPositions);

        $event->refresh();
        return successResponse('Successful', EventResource::make($event));
    }

    //Change to re-useable method
    protected function addInviteesToEvent(Event $event, $positions)
    {
        // Get the existing positions for the event
        $existingPositions = $event->invitePosition()->pluck('position_id')->toArray();

        // Determine positions to add and positions to remove
        $positionToUpdate = array_intersect($positions, $existingPositions);
        $positionsToAdd = array_diff($positions, $existingPositions);
        $positionsToRemove = array_diff($existingPositions, $positions);

        $newPositionToAdd = [];
        // Create new records for positions to add
        foreach ($positionsToAdd as $positionId) {
            $newPositionToAdd[] = [
                'event_id' => $event->id,
                'position_id' => $positionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($newPositionToAdd) {
            EventInvitePosition::insert($newPositionToAdd);
        }

        // Remove records for positions to remove
        EventInvitePosition::where('event_id', $event->id)
            ->whereIn('position_id', $positionsToRemove)
            ->delete();

        $event->update([
            'last_reminder_date' => now(),
        ]);

        //SEND NOTIFICATION TO ADDED POSITIONS
        if ($newPositionToAdd) {
            EventNotificationUtility::eventAdded($event->refresh());
        }

        if (count($positionToUpdate)) {
            $users = User::whereIn('position_id', $positionToUpdate)->get();
            EventNotificationUtility::eventUpdated($event, $users);
        }

        if (count($positionsToRemove)) {
            $eventName = $event->name;
            $users = User::whereIn('position_id', $positionsToRemove)->get();
            EventNotificationUtility::eventUninvited($users, $eventName);
        }

        return true;
    }

    public function delete(Request $request, $eventID)
    {
        // did not inject the model so even already deleted records can return success
        $event = Event::find($eventID);
        $reason = $request->reason;
        if ($event) {

            $eventName = $event->name;
            //$registeredUsers = $event->getRegisteredUsers();
            $invitedUsers = $event->newlyInvitedUsers();

            $event->is_del = 1;
            $event->save();

            EventNotificationDates::where('event_id', $eventID)->update(['is_del' => 1]);
            EventInvitePosition::where('event_id', $eventID)->update(['is_del' => 1]);
            EventRegistration::where('event_id', $eventID)->update(['is_del' => 1]);
            EventNotification::where('event_id', $eventID)->update(['is_del' => 1]);

            $logMessage = "Deleted the Event: $eventName";
            logAction($request->user()->email, 'Delete Event', $logMessage, $request->ip());

            EventNotificationUtility::eventDeleted($invitedUsers, $event, $reason);
        }

        return successResponse('Successful');
    }

    // array on success, string on error.
    // Returns an array on success, or a string on error.
    private function stringToDateArray($dateStr)
    {
        $unregisteredDates = explode(',', $dateStr);

        $formattedDates = [];

        foreach ($unregisteredDates as $date) {
            $trimmedDate = trim($date);

            // Validate date format (YYYY-MM-DD)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmedDate)) {
                // Check if it's a valid PHP date
                $dateTime = \DateTime::createFromFormat('Y-m-d', $trimmedDate);

                if ($dateTime->format('Y-m-d') == $trimmedDate) {
                    // Check if it's a future date
                    $currentDate = new \DateTime('now');

                    if ($dateTime > $currentDate) {
                        $formattedDates[] = $trimmedDate;
                    } else {
                        // Handle past date
                        return 'Invalid date: ' . $trimmedDate . ' is in the past';
                    }
                } else {
                    // Handle invalid PHP date
                    return 'Invalid date: ' . $trimmedDate;
                }
            } else {
                // Handle invalid date format
                return 'Invalid date format: ' . $trimmedDate;
            }
        }

        return $formattedDates;
    }

    public function register(Request $request, Event $event)
    {
        $request->validate([
            'evidence_of_payment_img' => 'sometimes|mimes:jpeg,png,jpg|max:5048',
        ]);

        if ($event->is_del) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "You are unable to register for this event at this time");
        }

        $registered = EventRegistration::where('user_id', $request->user()->id)
            ->where('event_id', $event->id)->first();

        if ($registered) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "You have already registered for this event. You can can update your POP instead.");
        }

        // Store the image
        $imagePath = null;

        if (isset($request->evidence_of_payment_img) && $request->hasFile('evidence_of_payment_img')) {
            $image = $request->file('evidence_of_payment_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('event_pop', $imageName, 'public');
        }

        if ($event->fee > 0 && !$imagePath) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Evidence of payment is required");
        }

        $eventReg = EventRegistration::create([
            'user_id' => $request->user()->id,
            'event_id' => $event->id,
            'status' => ($event->fee > 0) ? EventRegistration::STATUS_PENDING : EventRegistration::STATUS_APPROVED,
            'evidence_of_payment' => $imagePath,
        ]);

        $logMessage = "Registered for the Event: $event->name";
        logAction($request->user()->email, 'Register for Event', $logMessage, $request->ip());

        //Notify FSD Cc MBG and MEG For payment Approval
        if ($event->fee > 0) {
            EventNotificationUtility::pendingPaymentEventRegistration($eventReg);
        }

        return successResponse('Successful', EventRegistrationResource::make($eventReg));
    }

    public function registerUpdatePOP(Request $request, EventRegistration $eventReg)
    {
        $request->validate([
            'evidence_of_payment_img' => 'required|mimes:jpeg,png,jpg|max:5048',
        ]);

        if ($eventReg->user_id != $request->user()->id) {
            return errorResponse(ResponseStatusCodes::PERMISSION_DENIED, "You are not allowed to perform this action");
        }

        if ($eventReg->status = EventRegistration::STATUS_APPROVED) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "This registration payment has already been approved");
        }

        // Store the image
        $imagePath = null;

        if (isset($request->evidence_of_payment_img) && $request->hasFile('evidence_of_payment_img')) {
            $image = $request->file('evidence_of_payment_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('event_pop', $imageName, 'public');
        }

        if (!$imagePath) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Evidence of payment is required");
        }

        $eventReg->evidence_of_payment = $imagePath;
        $eventReg->save();

        $event = $eventReg->event;

        $logMessage = "Updated POP for the Event: $event->name";
        logAction($request->user()->email, 'Register for Event', $logMessage, $request->ip());

        //Notify FSD Cc MBG and MEG For payment Approval
        if ($event->fee > 0) {
            EventNotificationUtility::pendingPaymentEventRegistration($eventReg);
        }

        return successResponse('Successful', EventRegistrationResource::make($eventReg));
    }

    public function myInvitedEvents(Request $request)
    {
        $records = EventInvitePosition::with(['event'])->where('is_del', 0)->where('position_id', $request->user()->position_id)->latest()->get();

        return successResponse('Successful', EventInvitationWithEventResource::collection($records));
    }
    public function myRegisteredEvents(Request $request)
    {
        $records = EventRegistration::with(['user', 'event'])->where('is_del', 0)->where('user_id', $request->user()->id)->latest()->get();
        return successResponse('Successful', EventRegistrationWithEventResource::collection($records));
    }

    public function eventRegistrations(Request $request, Event $event)
    {
        $records = EventRegistration::with(['user', 'event'])->where('is_del', 0)->where('event_id', $event->id)->latest()->get();

        return successResponse('Successful', ['report' => EventRegistrationWithEventResource::collection($records), 'report_url' => route('downloadReport', ['education_report'])]);
    }

    public function approveEventRegistration(Request $request, EventRegistration $eventReg)
    {
        $request->validate([
            'status' => 'required|in:Approved,Declined',
            'reason' => 'nullable|required_if:status,Declined',
        ]);

        $oldStatus = $eventReg->status;

        //Change approved status to registered
        $eventReg->status = ($request->status == "Approved") ? EventRegistration::STATUS_APPROVED : EventRegistration::STATUS_DECLINED;
        $eventReg->admin_remark = $request->reason;
        $eventReg->save();

        $logMessage = "Updated Event Registration Status from $oldStatus to $eventReg->status  (# $eventReg->id)";
        logAction($request->user()->email, 'Update Event Registration Status', $logMessage, $request->ip());

        EventNotificationUtility::paymentStatusUpdated($eventReg);
        return successResponse('Successful', EventRegistrationWithEventResource::make($eventReg));
    }

    public function certificateSample(Event $event)
    {
        $name = "John Doe";
        $isDownload = false;

        $eventName = $event->name;
        $eventDate = $event->date;
        $cert_signature = $event->cert_signature ? config('app.url') . '/storage/app/public/' . $event->cert_signature : null;

        return view('mails.certificate', compact('event', 'name', 'isDownload', 'cert_signature'));
    }

    public function certificateSamplePreview(Event $event)
    {
        $name = "John Doe";
        $isDownload = true;

        $eventName = $event->name;
        $eventDate = $event->date;
        $cert_signature = $event->cert_signature ? config('app.url') . '/storage/app/public/' . $event->cert_signature : null;

        return view('mails.certificate', compact('event', 'name', 'isDownload', 'cert_signature'));
    }

    public function certificateSampleDownload(Event $event)
    {
        $name = "John Doe";
        $isDownload = true;

        $pdf = App::make('dompdf.wrapper');

        $eventName = $event->name;
        $eventDate = $event->date;
        $cert_signature = $event->cert_signature ? config('app.url') . '/storage/app/public/' . $event->cert_signature : null;

        $pdf->loadView('mails.certificate', compact('event', 'name', 'isDownload', 'cert_signature'))->setPaper($this->certPaperSize);

        return $pdf->download('certificate.pdf');
    }

    public function sendCertificates(Request $request, Event $event)
    {
        $request->validate([
            'presentation' => 'sometimes|mimes:pdf|max:2048',
            'event_registrations' => 'required|array',
            'event_registrations.*' => [
                'integer',
                Rule::exists('event_registrations', 'id'), // Ensure each  ID exists in the 'EventRegistration' table
            ],
        ]);
        $event = Event::find(request('eventID'));
        $presentation = $request->hasFile('presentation') ? $request->file('presentation')->storePublicly('event_presentation', 'public') : null;

        $event->is_event_completed = true;
        $event->presentation = $presentation;
        $event->save();

        $requestedIDs = $request->input('event_registrations');

        GenerateAndSendCertificateJob::dispatch($requestedIDs, $this->certPaperSize);

        return successResponse('Certificates will be sent to the selected participants');

    }

    public function sendCertificateForSigning(Request $request, $eventID)
    {

        $event = Event::find($eventID);

        if ($event) {

            $event->is_sent_for_signing = true;
            $event->save();

            $logMessage = "Sent for certificate signin the Event: {$event->name}";
            logAction($request->user()->email, 'Event Certificate', $logMessage, $request->ip());
        }

        return successResponse('Successful');
    }
    public function signCertificate(Request $request, $eventID)
    {
        // did not inject the model so even already deleted records can return success
        $event = Event::find($eventID);

        if ($event) {

            $request->validate([
                'signature' => 'required|mimes:jpeg,png,jpg|max:2048',
            ]);

            $signature = $request->hasFile('signature') ? $request->file('signature')->storePublicly('event_signature', 'public') : null;

            $event->cert_signature = $signature;
            $event->signed_by = auth()->user()->id;
            $event->save();

            $logMessage = "{$request->user()->email} Signed {$event->name} Event certificate";
            logAction($request->user()->email, 'Delete Event', $logMessage, $request->ip());

            return successResponse("Signature Updated Successfully", []);

        }

        return successResponse('Fail to update signature');
    }

}
