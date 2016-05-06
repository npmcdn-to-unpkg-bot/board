<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Http\Helpers\BoardHelpers;
use App\Services\OfferService;
use App\Services\AppEnum;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    private $names;
    private $errors;

    public function __construct()
    {
        $this->names = $this->getNames();
        $this->middleware('limited');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Offer::where('user_id','=',Auth::user()->id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Offer::where('id','=',$id)->get();
    }

    /**
     * @param $advert
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|mixed|string|static[]
     */
    public function create($advert, Request $request)
    {
        $data = BoardHelpers::parseRequest($this->names,$request);
        $data['adv_id'] = $advert;
        return OfferService::create()
            ->addItem($data)
            ->save();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return OfferService::create()
            ->setItem($id)
            ->putValues(BoardHelpers::parseRequest($this->names,$request))
            ->update();
    }

    /**
     * @param $id
     * @return string
     */
    public function remove($id)
    {
        return OfferService::create()
            ->setItem($id)
            ->remove();
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     */
    public function statusChange($id, Request $request)
    {
        $offer = Offer::where('id','=',$id);
        $advert = Advert::where('id','=',$offer->get()[0]->adv_id);
        //
        $status = $request->input('status');
        if (isset($status) && $status == 'accepted') {
            if ($this->closeOffers($advert->get()[0]->id)) {
                if (! $offer->update(['status' => 'accepted'])) {
                    $this->errors =  AppEnum::ERROR_CHANGE_OFFER_STATUS;
                } else {
                    if (! $advert->update(['status' => $status])) {
                        $this->errors =  AppEnum::ERROR_CHANGE_OFFER_STATUS;
                    }
                }
            }
        }

        return count($this->errors) == 0 ? Offer::where('id','=',$id)->get(): AppEnum::ERROR_CHANGE_OFFER_STATUS;
    }

    /**
     * @param $adv_id
     * @return bool
     */
    public function closeOffers($adv_id)
    {
        return Offer::where('adv_id','=',$adv_id)->update(['status' => 'canceled']) ? true : false;
    }
    /**
     * @return array
     */
    private function getNames()
    {
        return ['title','description','price','image'];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function parseRequest(Request $request)
    {
        $data = [];
        foreach ($this->names as $name) {
            $data[$name] = $request->input($name);
        }
        return $data;
    }
}
