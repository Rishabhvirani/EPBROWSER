<div class="row layout-top-spacing">
    <div class="col-xl-5 col-lg-4 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">                                
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Create Bookmark</h4>
                        <br>
                    </div>                                                                        
                </div>
            </div>
            <div class="widget-content">
                <form  wire:submit.prevent="create_bookmark" enctype="multipart/form-data">
                    <div class="form-group row  mb-4">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Select Image</label>
                        <div class="col-sm-8">
                            <input type="file" wire:model="state.photo" class="form-control form-control-sm" id="colFormLabelSm">
                            
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Label Name</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model="state.label" class="form-control form-control-sm" id="colFormLabelSm" placeholder="Enter Label Name">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label for="colFormLabelSm"  class="col-sm-4 col-form-label col-form-label-sm">Enter Url</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model="state.link" class="form-control form-control-sm" id="colFormLabelSm" placeholder="Enter URL">
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="col-xl-7 col-lg-4 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>View Bookmarks</h4>
                            <br>
                        </div>                                                                        
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Label</th>
                                    <th>link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach($bookmarks as $bookmark)
                                <tr>
                                    <td> 
                                        <img src="{{ url('storage') .'/' . $bookmark->img_path }}" height="30" alt="" />
                                    </td>
                                    <td>{{ $bookmark->label }}</td>
                                    <td>{{ $bookmark->link }}</td>
                                    <td>
                                        <span wire:click="delete('{{ $bookmark->id }}')" class="badge badge-danger">Delete</span>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                            
                        </table>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

