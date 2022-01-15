<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarRequest;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->month) {
            $explode = explode('-', $request->month);
            $calendar = Calendar::whereYear('start', $explode[0])->whereMonth('start', $explode[1]);
        }

        $calendar ??= new Calendar;
        return view('operator.calendars.calendar', [
            'calendars' => $calendar->paginate(15)->withQueryString(),
            'month' => $request->month
        ]);
    }

    public function api()
    {
        $api = $this->getApi();

        foreach ($api as $key => $event) {
            $rules[$key . '.summary'] = 'string';
            $rules[$key . '.start'] = 'unique:calendars,start';

            $messages[$key . '.start.unique'] = $event['start'] . ' sudah ada';
        }

        $validator = Validator::make($api, $rules, $messages);
        $validated = $validator->validated();

        if ($validator->fails()) return back()->withErrors($validator);
        try {
            Calendar::insert($validated);
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah ' . count($validated) . ' event';
        return back()->with('alert', $alert);
    }

    public function getApi()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('GOOGLE_API_CALENDAR'));
        $json = json_decode($response->getBody());

        $data = [];
        foreach ($json->items as $item) {
            if (!(Str::before($item->start->date, '-') == date('Y'))) continue;
            $data[] = [
                'summary' => $item->summary,
                'start' => $item->start->date,
            ];
        }

        return $data;
    }

    public function store(CalendarRequest $request)
    {
        try {
            Calendar::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah event';
        return back()->with('alert', $alert);
    }

    public function update(CalendarRequest $calendar)
    {
        try {
            Calendar::find($calendar->id)->update($calendar->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'edit event ' . $calendar->format_start;
        return back()->with('alert', $alert);
    }

    public function destroy(Calendar $calendar)
    {
        try {
            $calendar->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus event ' . $calendar->format_start;
        return back()->with('alert', $alert);
    }
}
