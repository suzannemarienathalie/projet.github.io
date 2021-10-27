$(function(){
	/**------------------Routing-------------------------*/
	route()
	function route(){
		$('li.menu-item').removeClass('active')
		var path = location.pathname.substring(1)
	    var part_path = path.split('/')
	    var target = "";
	    for(let i=1;i<part_path.length;i++){
	    	target += "/" + part_path[i]
	    }
	    target = target.substring(1)
    	switch (target) {
    		case "":
    			load_addContact()
    			break;
    		case "campagne":
    			load_campagne()
    			break;
    		case "send_mail":
    			load_sendMail()
    			break;    		
    		default:
    			console.log("404 not found")
    			break;
    	}
	}
	window.addEventListener('locationchange', function(){
		route();
	})
	
	/*----------------Event click menu----------------*/
	$("li.menu-item").each(function(){
		$(this).on('click',function(){
			if($(this).hasClass('active')){
				return false
			}
			$("li.menu-item").removeClass('active')
			$(this).addClass('active')
			let nextURL = $(this).data('uri')
			window.history.pushState(/*nextState*/null, /*nextTitle*/null, nextURL);
			//window.history.replaceState(/*nextState*/null, /*nextTitle*/null, nextURL);
		})
	})
	
	/*----------------add contact----------------*/
	function load_addContact(){
		$('li.menu-item:first-child').addClass('active')
		$.ajax({
			url: base_url('Contact/add'),
			type: 'get',
			dataType: 'html'
		})
		.done(function(res) {
			$(".main").html(res)
			set_event_addContact()
			affiche_table_contact()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}

	/*------------------Event addContact------------------------*/
	function set_event_addContact(){
		$('#form-addContact').on('submit',function(e){
			e.preventDefault();
			var self = this
			var url_api = $(this).attr("action")
			$.ajax({
				url: url_api,
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize(),
			})
			.done(function(res) {
				if(res.success){
					Swal.fire({
						icon: 'success',
						title: 'SUCCES',
						text : res.message
					})
					self.reset()
					affiche_table_contact()
					reinitialize_contact()
				}else{
					Swal.fire({
						icon: 'error',
						title: 'ERREUR',
						html : res.error
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

	/*------------------------affiche table contact----------------------------*/
	function affiche_table_contact(){
		$.ajax({
			url: base_url('Contact/liste'),
			type: 'get',
			dataType: 'html'
		})
		.done(function(res) {
			$("#table-list-contact").html(res)

			set_event_listContact()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
	/*------------------Event listContact------------------------*/
	function set_event_listContact()
	{
		$(".delete-contact").each(function(){
			$(this).on('click',function(){
				var id_contact = $(this).data('contact')
				Swal.fire({
                  title: 'CONFIRMATION',
                  text: "Voulez-vous vraiment supprimer ce contact ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OUI',
                  cancelButtonText: 'NON'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
							url: base_url('Contact/delete/' + id_contact),
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
								affiche_table_contact()
							}
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
		$('.update-contact').each(function(){
			$(this).on('click',function(){
				$("#form-addContact").attr('action',base_url('Contact/update'))
				$("#id-contact-input").val($(this).data('contact'))
				$("#btn-submit-contact").text('Mettre à jour')
				
				
				$("input[name='email_contact']").val($(this).data('email'))
				$("input[name='firstname_contact']").val($(this).data('firstname'))
				$("input[name='lastname_contact']").val($(this).data('lastname'))
				$("input[name='entreprise_contact']").val($(this).data('entreprise'))
				$("input[name='poste_contact']").val($(this).data('poste'))
				$("input[name='telephone_contact']").val($(this).data('telephone'))
				
			})
		})
	}

	/*-----------------------Reinitialisation interface contact-------------------------*/
	function reinitialize_contact(){
		$("#form-addContact").attr('action',base_url('Contact/create'))
		$("#id-contact-input").val(-1)
		$("#btn-submit-contact").text('Enregistrer')

	}
})