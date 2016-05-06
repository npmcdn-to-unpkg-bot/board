<?php

namespace App\Services;

use App\Models\Advert;
use App\Models\Offer;
use App\Services\Entity;
use App\Services\AppEnum;
use App\Services\StorageService;
use App\Services\AdvertsErrors;
use Illuminate\Support\Facades\Auth;

class AdvertService implements iService
{
    /**
     * @var int $id
     */
    protected $id;
    /**
     * @var
     */
    protected $item;
    /**
     * @var
     */
    protected $values;
    /**
     * @var
     */
    protected $validity;
    /**
     * @var
     */
    protected $errors;

    /**
     * @return AdvertService
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|string|static[]
     */
    public function save()
    {
        $check = $this->validation();

        if ($this->validity) {
            if (isset($check['image'])) {
                $storage = new StorageService();

                $file = $storage->setStorage('adverts')
                        ->addFile($check['image'])
                        ->save();
                

                ($file) ? $check['image'] = $storage->getFullName() : $this->errors = $storage->getErrors();
            }
            //
            if(!$this->errors) {
                $advert = new Advert();
                $check['user_id'] = Auth::user()->id;
                foreach ($check as $item => $value) {
                    $advert->$item = $value;
                }

                return ($advert->save()) ? Advert::all() : AppEnum::ERROR_ADVERT_SAVE;

            } else {
                return $this->errors;
            }
        } else {
            return AppEnum::ERROR_ADVERT_SAVE_INVALID;
        }
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $check = $this->validation();

        if($this->validity) {
            if(isset($check['image'])) {
                $name = Advert::where('id','=',$this->id)->get()[0]->image;
                $storage = new StorageService();

                $file = $storage->setStorage('adverts')
                        ->addFile($check['image'])
                        ->setName($name)
                        ->save();

                if(!$file){
                    $this->errors = $storage->getErrors();
                } else {
                    $check['image'] = $storage->getFullName();
                }
            }
            if (count($this->errors) == 0) {
                if(! Advert::where('id','=',$this->id)->update($check)) {
                    $this->errors = AppEnum::ERROR_ADVERT_UPDATE;
                }
            }
        } else {
            $this->errors = $check;
        }

        return count($this->errors) > 0 ?  $this->errors : Advert::where('id','=',$this->id)->get();
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection|string|static[]
     */
    public function remove()
    {
        if($this->removeOffers()){
            return (Advert::where('id','=',$this->id)->delete()) ? Advert::all() : false;
        } else {
            return AppEnum::ERROR_REMOVE_OFFERS;
        }
    }

    /**
     * @param $object
     * @return $this
     */
    public function addItem($object)
    {
        $this->item = $object;
        $this->putValues($object);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setItem($id)
    {
        $this->id = $id;
        $this->item = Advert::where('id','=',$id)->get();
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function putValues($data)
    {
        $this->values = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['null' => false, 'rule' => ''],
            'description' => ['null' => false, 'rule' => ''],
            'price' => ['null' => true, 'rule' => '/^\d+$/']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title'         => AdvertsErrors::TITLE,
            'description'   => AdvertsErrors::DESCRIPTION,
            'price'         => AdvertsErrors::PRICE
        ];
    }

    /**
     * @return array
     */
    public function prepareProperties()
    {
        return [
            'rules'     => $this->rules(),
            'messages'  => $this->messages()
        ];
    }

    /**
     * @return mixed
     */
    public function validation()
    {
        $entity = new Entity();
        $this->validity = $entity->import($this->values)
            ->setProperties($this->prepareProperties())
            ->validate();

        return ($this->validity) ? $entity->getAttributes() : $entity->getErrors();
    }

    /**
     * @return bool
     */
    public function removeOffers()
    {
        $result = true;
        $offers = Offer::where('adv_id','=',$this->id)->get();
        if(count($offers) > 0) {
            foreach ($offers as $offer) {
                $result = (!Offer::where('id','=',$offer->id)->delete()) ? : false;
            }
        }
        return $result;
    }
}