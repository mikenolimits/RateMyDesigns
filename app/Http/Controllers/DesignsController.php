<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 6/7/15
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\DesignRequest;
use App\Repositories\DesignsRepository;
use Request;
use Storage;
use Image;
class DesignsController extends Controller
{

    /* @var $repository DesignsRepository */
    public $repository;
    public $endpoint;

    public function __construct(DesignsRepository $designsRepository){
        $this->repository = $designsRepository;
        $this->middleware('auth',['only' => 'create']);
    }

    public function index(){
        $designs         = $this->repository->paginate(6);
        $view['designs'] = $designs;

        return view('designs.index',$view);
    }


    public function getResults(){
        $designs = $this->repository->all();

        $designs->map(function($item){
            $item['votes'] = $item->ratings->sum(function($item){
               return +1;
            });
        });
        $view['designs'] = $designs;
        return view('ratings.index',$view);
    }
    public function edit(){
        $designs         = $this->repository->paginate(6);
        $view['designs'] = $designs;

        return view('designs.edit',$view);
    }

    public function destroy($id){


        $this->repository->destroy($id);

        return redirect()->back()->with('success',
            'Destroyed the design. You can make a new one at '. link_to_route('designs.create'));
    }

    public function create(){
        return view('designs.create');
    }

    public function store(DesignRequest $designRequest){
        $file         = Request::file('image');

        $storage      = \Storage::disk('local');

        $hash         = time() . str_random(10) . "{$file->getClientOriginalName()}";
        $fileName     = 'images/' . $hash;
        $realPath     = $file->getRealPath();

        Image::make($realPath)->resize(400,400)->save($fileName);

        //$storage->put($fileName,\File::get($realPath));

        $data = Request::input();
        $data['image']   = $fileName;
        $data['user_id'] = \Auth::id();

        $this->repository->create($data);

        return redirect()->back()->withInput()->with('success','Success! Added new design.');

    }
}
