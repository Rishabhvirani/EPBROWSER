<?php

namespace App\Http\Livewire\Module;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\BookmarksModel;
use File;


class Bookmarks extends Component
{
    use WithFileUploads;
    public $state= [];
    public $bookmarks;

    public function create_bookmark(){
        $rules = [
            'label' => 'required',
            'link' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',            
        ];
        $validator = Validator::make($this->state,$rules);
        if ($validator->passes()) {
            $path = $this->state['photo']->store('bookmarks', 'public');
            if($path){
                $data['img_path'] = $path;
                $data['label'] = $this->state['label'];
                $data['link'] = $this->state['link'];
                if(BookmarksModel::create($data)){
                    $this->reset('state');
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Bookmark Created']);
                    $this->render();
                }else{
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Something went wrong']);
                }
            }
        }else{
            $this->dispatchBrowserEvent('alert', ['type' => 'danger',  'message' => $validator->errors()->first()]);
        }
    }

    public function render()
    {
        $this->bookmarks = BookmarksModel::get();
        return view('livewire.module.bookmarks');
    }

    public function delete($id){
        $firstrecord = BookmarksModel::where(array('id'=>$id))->first();
        if(unlink('storage/'.$firstrecord->img_path)){
            BookmarksModel::where(array('id'=>$id))->delete();
            $this->bookmarks = BookmarksModel::get();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Bookmark Deleted Successfully']);
        }else{    
            $this->dispatchBrowserEvent('alert', ['type' => 'danger',  'message' =>'something went wrong']);
        }
    }
}
