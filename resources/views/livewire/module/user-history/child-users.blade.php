<div>
    <div class="row layout-top-spacing">
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Points</th>
                        <th>Usd</th>
                        <th>CN</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($users as $i=>$user){
                            ?>
                                <tr>
                                        <td>{{$i+1}}</td>
                                        <td><a href='{{ url("users/history/$user->u_id") }}'>{{$user->username}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{{$user->points}}</td>
                                        <td>{{$user->usd}}</td>
                                        <td>{{$user->country}}</td>
                                        <td>{{$user->email_verified}}</td>
                                        <td>{{$user->mobile_verified}}</td>    
                                        <td>{{$user->created_at->format('d-M-Y')}}</td> 
                                        <td><span data-toggle="modal" data-target="#edit" wire:click="openEdit('{{ $user->u_id }}')" wire:key="{{ $user->u_id }}" class="badge badge-warning">Edit</span></td>
                                </tr>    
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>  
    </div>
</div>
@livewire('forms.user.edit')
