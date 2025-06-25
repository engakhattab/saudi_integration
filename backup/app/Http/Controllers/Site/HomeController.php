<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Activity;
use App\Models\ContactUs;
use App\Models\GeneralSetting;
use App\Models\Groups;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\Slider;
use App\Models\ObstacleCources;
use App\Models\PricesSlider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $expert=ObstacleCources::where('id',2)->first();
        $invoice=ObstacleCources::where('id',3)->first();
        $skilled=ObstacleCources::where('id',1)->first();
        $prices_sliders=PricesSlider::get();

        $sliders = Slider::latest()->get();
        $setting = GeneralSetting::first();
        $offers  = Offer::latest()->get();
        return view('site.index',compact('sliders','setting','offers','skilled','invoice','expert','prices_sliders'));
    }

    public function about(){
        $abouts = AboutUs::latest()->get();
        return view('site.about-us',compact('abouts'));
    }

    public function activities(){
        $activities = Activity::latest()->get();
        return view('site.activities',compact('activities'));
    }

    public function ExistAllPeople(){
        $exit_time             = date('Y-m-d').' '.GeneralSetting::first()->exit_time;
        $current_date          = date('Y-m-d H:i:s');
        if($exit_time < $current_date){
        $tickets      = Ticket::whereDate([['visit_date','<',$exit_time],['status','in']])->get();
        $reservations = Reservations::whereDate([['day','<',$exit_time],['status','in']])->get();
            foreach ($tickets as $ticket){
                foreach ($ticket->models as $model){
                    $model->update([
                     //  'temp_status' => 'in',
                      // 'status'      => 'in',
                       //'bracelet_number' => null
                    ]);
                }
                $ticket->update([
                  // 'status' => 'in',
                ]);
            }
            foreach ($reservations as $reservation){
                foreach ($reservation->models as $model){
                    $model->update([
                     //  'temp_status' => 'in',
                      //  'status'      => 'in',
                       // 'bracelet_number' => null
                    ]);
                }
                $reservation->update([
                   // 'status' => 'in',
                ]);
            }
        }
    }

    public function terms(){
        return view('site.terms');
    }

    public function groups(){
        $groups = Groups::latest()->get();
        return view('site.groups',compact('groups'));
    }

    public function contact(){
        return view('site.contact');
    }

    public function storeContact(request $request){
        try {
            $data = $request->validate([
                'first_name'     =>'required|max:255',
                'last_name'      =>'required|max:255',
                'phone'          =>'required|max:255',
                'email'          =>'required|max:255',
                'message'        =>'required',
            ]);
            $data['status'] = '0';
            ContactUs::create($data);
            return redirect()->back()->with('success', 'We Will Answer You As Soon As Possible');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function safety(){
        return view('site.safety');
    }
    public function offerDetails($id){
        $offer  = OfferItem::findOrFail($id);
        $tags   = Offer::select('title')->get();
        $offers = OfferItem::orderBy('id','DESC')->where('id','<>',$id)->take(2)->get();
        return view('site.offerDetails',compact('offer','tags','offers'));
    }


    //start cities by gov_id
    public function cities($id)
    {
        $cities = DB::table("cities")->where("gov_id", $id)->pluck("title", "id");
        return json_encode($cities);
    }
}
