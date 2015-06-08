<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 7:03 PM
 */

namespace App\Http\Controllers;


use App\Http\Requests\RatingRequest;
use App\Repositories\RatingsRepository;

class RatingController extends Controller
{
    public  $repository;

    public function __construct(RatingsRepository $ratingsRepository){
        $this->repository = $ratingsRepository;
    }

    public function index(){
        $ratings = $this->repository->paginate(99999);

    }

    public function store(RatingRequest $ratingRequest){
        $design = $ratingRequest->input('design');

        $ip     = $ratingRequest->ip();

        $this->repository->setCacheLifeTime(0);
        $res = $this->repository->whereCached('ip',$ip);

        /*
        if($res->count() > 1){
            return redirect()->back()->with('success','You already voted. Sorry');
        }
        */

        $this->repository->create([
            'design_id' => $design,
            'ip'       => $ip
        ]);

        return redirect()->back()->with('success','Thanks for voting.');
    }
}
