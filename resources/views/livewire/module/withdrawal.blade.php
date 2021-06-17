<div class="row layout-top-spacing" wire:ignore.self>
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Usd</th>
                            <th>Epc</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($Withdrawal_history as $i=>$withdrawal){
                        ?>
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{ $withdrawal->username }}</td>
                            <td>{{ $withdrawal->email }}</td>
                            <td>{{ $withdrawal->usd }}</td>
                            <td>{{ $withdrawal->epc }}</td>
                            <td>{{ $withdrawal->epc_address }}</td>
                            <td>
                                @if($withdrawal->status == 0)
                                    <span data-toggle="modal" data-target="#approve" wire:click="approve('{{ $withdrawal->wh_id }}')" class="badge badge-success">Approve</span>
                                    <span  wire:click="decline('{{ $withdrawal->wh_id }}')" class="badge badge-warning">Decline</span>
                                 @elseif($withdrawal->status == 1)
                                    <span class="badge badge-success">Approved</span>
                                 @else
                                    <span class="badge badge-danger">Decline</span>
                                 @endif
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@livewire('forms.withdrawal.approve')