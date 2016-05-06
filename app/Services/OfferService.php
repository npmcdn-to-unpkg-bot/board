<?php

namespace App\Services;

use App\Models\Offer;
use App\Services\Entity;
use App\Services\AppEnum;
use App\Services\OffersErrors;
use Illuminate\Support\Facades\Auth;

class OfferService implements iService
{
    /**
     * @var
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
                $offer = new Offer();
                $check['user_id'] = Auth::user()->id;

                foreach ($check as $item => $value) {
                    $offer->$item = $value;
                }

                return ($offer->save()) ? Offer::all() : AppEnum::ERROR_OFFER_SAVE;

            } else {
                return $this->errors;
            }
        } else {
            return AppEnum::ERROR_OFFER_SAVE_INVALID;
        }
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $check = $this->validation();

        if ($this->validity) {
            if (isset($check['image'])) {
                $name = Offer::where('id','=',$this->id)->get()[0]->image;
                $storage = new StorageService();

                $file = $storage->setStorage('offers')
                    ->addFile($check['image'])
                    ->setName($name)
                    ->save();

                if (!$file) {
                    $this->errors = $storage->getErrors();
                } else {
                    $check['image'] = $storage->getFullName();
                }
            }
            if (count($this->errors) == 0) {
                if(! Offer::where('id','=',$this->id)->update($check)) {
                    $this->errors = AppEnum::ERROR_OFFER_UPDATE;
                }
            }
        } else {
            $this->errors = AppEnum::ERROR_OFFER_SAVE_INVALID;
        }

        return count($this->errors) > 0 ?  $this->errors : Offer::where('id','=',$this->id)->get();
    }

    /**
     * @return string
     */
    public function remove()
    {
        return Offer::where('id','=',$this->id)->delete() ? Offer::all() : AppEnum::ERROR_OFFER_REMOVE;
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
        $this->item = Offer::where('id','=',$id)->get();
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
            'title'         => OffersErrors::TITLE,
            'description'   => OffersErrors::DESCRIPTION,
            'price'         => OffersErrors::PRICE
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

        return $this->validity ? $entity->getAttributes() : $entity->getErrors();
    }
}