<?php

namespace App\Http\Controllers;

use App\Models\EventAgent;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class EventController extends Controller
{
    public function index()
    {
        $events = UserEvent::first()->get();
        $user = Auth::user();

        $eventAgents = [];
        if ($user->role === USER::ROLE_AGENT) {

            $eAgents = EventAgent::where('user_id', $user->id)->get();

            $eventAgents = [];
            foreach ($eAgents as $eAgent) {
                $eventAgents[$eAgent->event_id] = true;
            }
        }


        return view('event.index', ['events' => $events, 'eventAgents' => $eventAgents, 'user' => $user]);
    }
    public function show($id)
    {
        $event = UserEvent::findOrFail($id);
        $user = Auth::user();
        $eAgents = [];

        if ($user->role === USER::ROLE_ADMIN) {

            $eAgents = EventAgent::where('event_id', $event->id)->get();
        }
        return view('event.show', ['event' => $event, 'user' => $user, 'eventAgents' => $eAgents]);

    }

    public function join(Request $request)
    {
        $user = Auth::user();
        $event = UserEvent::findOrfail($request['event_id']);
        $base64Code = base64_encode($user->id);
        $eventAgent = EventAgent::where('code', $base64Code)->where('event_id', $event->id)->first();

        if ($eventAgent !== null) {
            return redirect(route("event_list"));
        }


        $qrcodeFilename = '/files/' . $event->id . $user->id . 'qrcode.png';
        $code = base64_encode($user->id);
        echo $code;
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('/event/visit_confirm/' . $event->id . '/' . $base64Code)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->validateResult(false)
            ->build();
        $result->saveToFile($_SERVER['DOCUMENT_ROOT'] . $qrcodeFilename);

        $eventAgent = new EventAgent();
        $eventAgent->user_id = $user->id;
        $eventAgent->event_id = $event->id;
        $eventAgent->code = $base64Code;
        $eventAgent->status = false;
        $eventAgent->qrcode = $qrcodeFilename;
        $eventAgent->save();

        return redirect(route("event_list"));
    }

    public function visitConfirm($event_id, $code)
    {
        $event = EventAgent::where('code',$code)->where('event_id', $event_id)->first();

        $event->status = true;
        $event->save();

        return redirect(route("event_show", $event_id));
    }

}
