/*----------------Campagne----------------*/
function load_campagne(){
	$('li.menu-item:nth-child(2)').addClass('active')
	$.ajax({
		url: base_url('Campagne/index'),
		type: 'get',
		dataType: 'html'
	})
	.done(function(res) {
		$(".main").html(res)
		set_event_campagne()
		refresh_table_campagne()
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function set_event_campagne(){
	$("#form-campagne").on('submit',function(e){
		e.preventDefault()
		var self = this
		var url_api = $(this).attr('action')
		$.ajax({
			url: url_api,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize()
		})
		.done(function(res) {
			if(res.success){
				self.reset()
				Swal.fire({
					icon: 'success',
					title: 'SUCCES',
					text: res.message
				})
				refresh_table_campagne()
				reinitialize_campagne()
			}else{
				Swal.fire({
					icon: 'error',
					title: 'ERREUR',
					html: res.error
				})
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	})
}

/*------------------------Refresh table campagne----------------------------*/
	function refresh_table_campagne(){
		$.ajax({
			url: base_url('Campagne/liste'),
			type: 'get',
			dataType: 'html'
		})
		.done(function(res) {
			$("#table-list-campagne").html(res)
			set_event_listCampagne()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
	/*------------------Event listCampagne------------------------*/
	function set_event_listCampagne()
	{
		$(".delete-campagne").each(function(){
			$(this).on('click',function(){
				var id_campagne = $(this).data('campagne')
				Swal.fire({
                  title: 'CONFIRMATION',
                  text: "Voulez-vous vraiment pour suivre cette action ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#096e8d',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OUI',
                  cancelButtonText: 'NON'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
							url: base_url('Campagne/delete/' + id_campagne),
							type: 'GET',
							dataType: 'json'
						})
						.done(function(res) {
							if(res.success){
								Swal.fire({
									icon: 'success',
									title: 'SUCCES',
									text : 'Contact supprimé' 
								})
							}
							refresh_table_campagne()
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
                    }
                })
				
				
			})
		})
		$('.update-campagne').each(function(){
			$(this).on('click',function(){
				$("#form-campagne").attr('action',base_url('Campagne/update'))
				$("#id-campagne-input").val($(this).data('campagne'))
				$("#btn-submit-campagne").text('Mettre à jour')
				
				$("input[name='name_campagne']").val($(this).data('name'))
				$("input[name='debut_campagne']").val($(this).data('debut'))
				$("input[name='fin_campagne']").val($(this).data('fin'))
				$("input[name='objectif_campagne']").val($(this).data('objectif'))
			})
		})
	}


	/*-----------------------Reinitialisation interface campagne-------------------------*/
	function reinitialize_campagne(){
		$("#form-campagne").attr('action',base_url('Campagne/create'))
		$("#id-campagne-input").val(-1)
		$("#btn-submit-campagne").text('Enregistrer')
	}
	