$(document).ready(function(){
    App.init();
    window.addEventListener('alert', event => { 
        if(event.detail.type == 'danger'){
            Snackbar.show({
                text: event.detail.message,
                pos: 'bottom-right',
                duration:5000,
                actionTextColor: '#fff',
                backgroundColor: 'red'
            });
        }else{
                Snackbar.show({
                text: event.detail.message,
                pos: 'bottom-right',
                duration:5000,
                actionTextColor: '#fff',
                backgroundColor: '#8dbf42'
            });
        }
    });
    window.addEventListener('approve',event=>{
        $('#approve').modal('show');
    });
    window.addEventListener('openform',event=>{
        $('#create').modal('show');
    });
    window.addEventListener('closeform',event=>{
        $('#create').modal('hide');
        $('#edit').modal('hide');
        $('#approve').modal('hide');
    });
    
    $('#table').DataTable({
        responsive: true
    });

    $('#usertable').DataTable({
        serverSide: true,
        processing: true,
		language: {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
		},
		pageLength: 10,
		order: [
			[0, "asc"]
		],
        ajax: {
            url: "http://127.0.0.1:8000/users/get_users", 
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }
    });    


    
    
});