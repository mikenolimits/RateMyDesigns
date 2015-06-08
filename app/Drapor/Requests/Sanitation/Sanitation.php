<?php namespace App\Drapor\Requests\Sanitation;

use Mjarestad\Filtry\Filtry;

class Sanitation
{

    protected $filtry;


    public function __construct(Filtry $filtry)
    {
        $this->filtry = $filtry;

    }

    /**
     * @param  $data
     * @param  $filters
     * @return array
     */
    public function sanitise(array $data,array $filters)
    {
        /* $filtered Filtry */
        $filteredFilters = [];
        foreach($data as $key => $input){
            //Basically the Endpoint has default filters setup,
            //but we want to make sure that Filtry only gets ones that match
            //the keys data provided.
            if(array_key_exists($key,$filters)){
                $filteredFilters[$key] = $filters[$key];
            }
        }
        $this->filtry =   $this->filtry->make($data, $filteredFilters);
        return $this->filtry->getFiltered();
    }

}