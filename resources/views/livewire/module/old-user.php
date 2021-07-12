<tbody>
                        <?php 
                    foreach($users as $user){
                        ?>
                        <tr>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->points}}</td>
                            <td>{{$user->usd}}</td>
                            <td>{{$user->country}}</td>
                            <td>{{$user->email_verified}}</td>
                            <td>{{$user->mobile_verified}}</td>
                            <td>
                                <span data-toggle="modal" data-target="#edit" wire:click="openEdit('{{ $user->u_id }}')" wire:key="{{ $user->u_id }}" class="badge badge-warning">Edit</span>
                            </td>
                            
                        </tr>
                    <?php } ?>
                    </tbody>