<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUs\StoreRequest;
use App\Services\ContactUsService;

class ContactUsController extends Controller
{
    /**
     * @var ContactUsService
     */
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function create()
    {
        $division = auth()->user()->consumer->getDefaultDivison();
        if (! $division) {
            $ownDivisionTeams = auth()->user()->consumer->ownDivisionTeams();
            if ($ownDivisionTeams) {
                $division = $ownDivisionTeams->first();
            }
        }

        return view('manager.contact_us', compact('division'));
    }

    public function store(StoreRequest $request)
    {
        $email = $this->contactUsService->sendEmail($request->all(), auth()->user());

        if ($email) {
            flash(__('messages.contact_us.success_message'))->success();
        } else {
            flash(__('messages.contact_us.error_message'))->error();
        }

        return redirect()->back();
    }
}
