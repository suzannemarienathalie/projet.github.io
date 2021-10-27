var nbre_contact_selected = 0
var tabs_contact_selected = []
/*----------------send mail----------------*/
	function load_sendMail(){
		$('li.menu-item:nth-child(3)').addClass('active')
		$.ajax({
			url: base_url('EnvoieMail/index'),
			type: 'GET',
			dataType: 'html'
		})
		.done(function(res) {
			$('.main').html(res)
			set_event_sendMail()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}
/*-------------------modal---------------------*/
function set_event_sendMail(){
	$("#label-msg-choose").on('click',function(){
		nbre_contact_selected = 0
		tabs_contact_selected = []
		$("#nbre-contact-selected").text(nbre_contact_selected)
		$('#select-all-contact').prop('checked',false)
		$("#choose-dest-modal").modal('show')
		$.ajax({
			url: base_url('EnvoieMail/getContact'),
			type: 'GET',
			dataType: 'json'
		})
		.done(function(res) {
			var li_1 = ''
			var li_2 = ''
			var nbre_contact = res.length
			var offset_list_1 = Math.ceil(nbre_contact/2)
			var counter = 0
			for(var contact of res){
				if(counter < offset_list_1){
					li_1 += `<li class="list-group-item py-1">
						<div class="row">
					    	<div class="col-1 d-flex align-items-center">
								<div class="form-check">
									<input class="form-check-input position-static checkbox-choose-destinataire" type="checkbox" value="${contact.email_contact}">
								</div>
					    	</div>
					    	<div class="col-11 d-flex flex-column justify-content-center">
					    		<span class="text-muted">${(contact.firstname_contact) ? contact.firstname_contact : ''} ${(contact.lastname_contact) ? contact.lastname_contact : ''}</span>
					    		<span class="bold-700 text-info">${contact.email_contact}</span>
					    	</div>
					    </div>
					</li>`	
				}else{
					li_2 += `<li class="list-group-item py-1">
						<div class="row">
					    	<div class="col-1 d-flex align-items-center">
								<div class="form-check">
									<input class="form-check-input position-static checkbox-choose-destinataire" type="checkbox" value="${contact.email_contact}">
								</div>
					    	</div>
					    	<div class="col-11 d-flex flex-column justify-content-center">
					    		<span class="text-muted">${(contact.firstname_contact) ? contact.firstname_contact : ''} ${(contact.lastname_contact) ? contact.lastname_contact : ''}</span>
					    		<span class="bold-700 text-info">${contact.email_contact}</span>
					    	</div>
					    </div>
					</li>`
				}
				counter ++
			}
			$("#list-destinataire-1").html(li_1)
			$("#list-destinataire-2").html(li_2)
			$("#select-all-contact-wrapper").removeClass('d-none')
			set_event_modal_choose_destinataire()
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	})

	/*----------------------Selection------------------*/
	$('#select-all-contact').on('change',function(e){
		var all_checkbox = $('.checkbox-choose-destinataire') 
		if($(this).is(':checked')){
			for(var ck of all_checkbox){
				$(ck).prop('checked',true)
			}
			nbre_contact_selected = all_checkbox.length
		}else{
			for(var ck of all_checkbox){
				$(ck).prop('checked',false)
			}
			nbre_contact_selected = 0
		}
		
		$("#nbre-contact-selected").text(nbre_contact_selected)
	})
	/*----------------------Choix destinataire------------------------*/
	function set_event_modal_choose_destinataire()
	{
		$('.checkbox-choose-destinataire').each(function(){
			$(this).on('change',function(){
				if($(this).is(':checked')){
					nbre_contact_selected ++
				}
				else{
					nbre_contact_selected --
				}
				$("#nbre-contact-selected").text(nbre_contact_selected)
			})
		})
		$('#btn-choix-contact').on('click',function(){
			if(nbre_contact_selected === 0){
				return false
			}
			tabs_contact_selected = []
			var ul_html = document.createElement('ul')
			var li_html = ''
			$('.checkbox-choose-destinataire').each(function(){
				if($(this).is(':checked')){
					var email_contact = $(this).val().trim()
					tabs_contact_selected.push(email_contact)
					li_html += `<li class="text-small text-info">${email_contact}</li>`
				}
			})
			$(ul_html).html(li_html)
			$('#list-contact-selected').html(ul_html)
			$("#choose-dest-modal").modal('hide')
		})
		$('#choose-dest-modal').on('hidden.bs.modal', function (e) {
			if(nbre_contact_selected === 0){
				$('#list-contact-selected').html(`<p class="text-small text-danger ml-4">Aucun contact selectionné</p>`)
			}
		})
	}
	/*------------------------Importer mail texte---------------------------*/
	$('.radio-destinataire').on("change",function(){
		if(Number($(this).val()) === 3){
			$("#import-mail-txt").removeClass('d-none')
			$("#list-contact-selected").addClass('d-none')
		}else if(Number($(this).val()) === 2){
			$("#import-mail-txt").addClass('d-none')
			$("#list-contact-selected").removeClass('d-none')
		}else{
			$("#import-mail-txt").addClass('d-none')
			$("#list-contact-selected").addClass('d-none')
		}
	})
	$('#email-list-text').on('change',function(){
		var file = this.files[0]
		if(file.type === 'text/plain'){
			$('#email-list-text-input').val(file.name)
		}else{
			Swal.fire({
				icon: 'error',
				title: 'ERREUR',
				text: 'Fichier invalide'
			})
		}
	})
	/*----------------------------Pièce jointe------------------------------*/
	$("#email-attachement").on('change',function(){
		var file = this.files[0]
		$("#name-attachement").text(file.name)
	})

	
	/*--------------------- formulaire-------------------------*/
	$("#form-sendMail").on('submit',function(e){
		e.preventDefault()
		var self = this
		var data = new FormData(this)
		

		update_tabs_contact_selected(function(){
			nbre_contact_selected = tabs_contact_selected.length
			send_first_mail_ajax(data,tabs_contact_selected[0],function(state){
				if(nbre_contact_selected > 1){
					if(state.success){
						var counter = 1
						data.append("nbre-contact",nbre_contact_selected)
						var interval_send_mail = setInterval(function(){
							if(counter >= nbre_contact_selected){
								clearInterval(interval_send_mail)
							}else{
								send_rest_mail_ajax(data,tabs_contact_selected[counter],counter + 1,function(data){
									if(data.success){								
										$("#mail-envoye").text(data.index)
										if(data.index === nbre_contact_selected){
											$("#intervalle").modal('hide')
											Swal.fire({
												icon: 'success',
												title: 'SUCCES',
												text: 'Email envoyé'
											})
											self.reset()
											$("#list-contact-selected").addClass('d-none')
											$("#list-contact-selected").html(`<p class="text-small text-danger ml-4">Aucun contact selectionné</p>`)
											$("#name-attachement").text('')  
										}
									}
								})	
							}
							counter++ 
						})
					}else{
						$("#intervalle").modal('hide')
						Swal.fire({
							icon: 'error',
							title: 'ERREUR',
							text: 'Email non envoyé'
						})
					}	
				}else{
					$("#intervalle").modal('hide')
					if(state.success){
						Swal.fire({
							icon: 'success',
							title: 'SUCCES',
							text: 'Email envoyé'
						})
						self.reset()
						$("#list-contact-selected").addClass('d-none')
						$("#list-contact-selected").html(`<p class="text-small text-danger ml-4">Aucun contact selectionné</p>`)
						$("#name-attachement").text('')
					}else{
						Swal.fire({
							icon: 'error',
							title: 'ERREUR',
							text: 'Email non envoyé'
						})
					}
				}
			})
			
			
			
		})

	})
	/*------------mise à jour--------*/
		function update_tabs_contact_selected(callback){
		var checked = Number($('.radio-destinataire:checked').val())
		console.log(checked)
		if( checked === 1){
			tabs_contact_selected = []
			$.ajax({
				url: base_url('EnvoieMail/getContact'),
				type: 'GET',
				dataType: 'json'
			})
			.done(function(res) {
				for(var contact of res){
					tabs_contact_selected.push(contact.email_contact)
				}
				callback()
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}else if (checked === 3) {
			tabs_contact_selected = []
			$.ajax({
				url: base_url('EnvoieMail/getContentText'),
				type: 'POST',
				dataType: 'json',
				enctype: 'multipart/form-data',
				contentType: false,
				cache: false,
				processData: false,
				data: new FormData(document.getElementById('form-sendMail'))
			})
			.done(function(res) {
				console.log(res)
				if(res.success){
					for(var contact of res.contacts){
						tabs_contact_selected.push(contact.email_contact)
					}
					callback()
				}else{
					Swal.fire({
						icon: 'error',
						title: 'ERREUR',
						text: res.error
					})
				}
				
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}else{
			callback()
		}
	}

		/*----------------------------Ajax sendmail-----------------------------*/
	function send_first_mail_ajax(data,destinataire,callback){
		data.append("destinataire",destinataire)
		
		$("#intervalle").modal('show')

		$("#mail-envoye").text(1)
		$("#mail-total").text(nbre_contact_selected)
		$.ajax({
			url: base_url('EnvoieMail/envoie'),
			type: 'POST',
			enctype: 'multipart/form-data',
			data: data,
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'json'
		}).done((res)=>{
			callback(res)
		})
	}
	function send_rest_mail_ajax(data,destinataire,index_email,callback){
		data.append("destinataire",destinataire)
		data.append("index-email",index_email)
		$.ajax({
			url: base_url('EnvoieMail/sendmail'),
			type: 'POST',
			enctype: 'multipart/form-data',
			data: data,
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'json'
		}).done((res)=>{
			callback(res)
		})
	}
}

