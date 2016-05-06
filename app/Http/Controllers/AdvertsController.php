<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Helpers\BoardHelpers;
use App\Models\Advert;
use App\Services\AdvertService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class AdvertsController extends Controller
{
    private $names;

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
        return Advert::all();
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

    /**
     * @return mixed
     */
    public function allMy(){
        return Advert::where('user_id','=',Auth::user()->id)->get();
    }

    public function getOffersByAdvert($id)
    {
        return [
            'advert' => Advert::where('id','=',$id)->get(),
            'offers' => Offer::where('adv_id','=',$id) ->get()
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Advert::where('id','=',$id)->get();
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
     * @return \Illuminate\Database\Eloquent\Collection|mixed|string|static[]
     */
    public function create(Request $request)
    {
        return AdvertService::create()
            ->addItem(BoardHelpers::parseRequest($this->names,$request))
            ->save();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return AdvertService::create()
            ->setItem($id)
            ->putValues(BoardHelpers::parseRequest($this->names,$request))
            ->update();
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Database\Eloquent\Collection|string|static[]
     */
    public function remove($id)
    {
        return AdvertService::create()
            ->setItem($id)
            ->remove();
    }
}
