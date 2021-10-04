
<div class="userhistory_title">
    <div class="widget widget-table-one">
            <div class="widget-heading">
                <h5 class="">User History</h5>
            </div>
            <div>
                <p><b>Parent User :</b> {{$parent_details->username}} </p>
                <p><b>Point :</b> {{$parent_details->points}}  &nbsp;&nbsp;&nbsp; <b>USD :</b> {{$parent_details->usd}} </p>
            </div>

            <div class="user_dashbaord">
                <div class="widget-content">
                    <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>{{ $total_referal_user }}</h4>
                                        <p class="meta-date">Total Referal User</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>{{ $total_earning }}</h4>
                                        <p class="meta-date">Total Earning</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>{{ $total_withdrawal }}</h4>
                                        <p class="meta-date">Total Withdrawal</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>{{ $total_referal_earning }}</h4>
                                        <p class="meta-date">Total Referal Earning</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="container">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'child_users' ? 'active' : '' }}" wire:click="$set('tab', 'child_users')" wire:change="ctab('child_users')" href="#child_users">Child Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'earning' ? 'active' : '' }}" wire:click="$set('tab', 'earning')" href="#earning">Total Earning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'withdrawal' ? 'active' : '' }}" wire:click="$set('tab', 'withdrawal')" href="#withdrawal">Total withdrawal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'ref_earning' ? 'active' : '' }}" wire:click="$set('tab', 'ref_earning')" href="#ref_earning">Referal Earning</a>
                </li>
            </ul>
            
            @if($tab == 'child_users')
                <div class="tab-pane container">
                    @livewire('module.user-history.child-users',['user'=>$user_id])
                </div>
            @elseif($tab == 'earning')
                <div class="tab-pane container">
                    @livewire('module.user-history.total-earning',['user'=>$user_id])
                </div>
            @elseif($tab == 'withdrawal')
                <div class="tab-pane container">
                    
                </div>
            @elseif($tab == 'ref_earning')
                <div class="tab-pane container">
                    
                </div>

            @endif
        </div>

        






    </div>
</div>


