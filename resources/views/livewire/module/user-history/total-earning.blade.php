<div>
    <div class="row layout-top-spacing">
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Referal User</th>
                        <th>Point</th>
                        <th>Earning Type</th>
                        <th>Referal Type</th>
                        <th>Timer ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($totalearning as $i=>$te){
                    ?>
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>
                            @if($te->referal_name != '')
                                {{$te->referal_name}}
                            @else
                                Self
                            @endif

                        </td>
                        <td>{{ $te->point }}</td>
                        <td>
                            @if($te->earn_type == 'r')
                                        Referal
                            @elseif($te->earn_type == 't')   
                                    Timer
                            @endif                                     
                        </td>
                        <td>
                            @if($te->ref_type == 'p')
                                Parent
                            @elseif($te->ref_type == 'c')
                                Child
                            @endif
                        </td>
                        <td>{{ $te->timer_id }}</td>
                        
                    </tr>                    
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>  
    </div>
</div>
