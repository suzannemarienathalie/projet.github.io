<div class="container-fluid">
	<h1 class="pb-2 bold-700">Envoie d'email</h1>
	<hr class="mt-0">
	<form id="form-sendMail">
		<div class="row">
			<div class="col-md-6">
			        <div class="form-group">
			        	<label class="bold-700">Type message</label>
			        	<!-- Default unchecked -->
						<div class="custom-control custom-radio">
						  <input type="radio" class="custom-control-input" id="msg-brute" name="type-message" checked value="texte brute">
						  <label class="custom-control-label" for="msg-brute">Texte brute</label>
						</div>

						<!-- Default checked -->
						<div class="custom-control custom-radio">
						  <input type="radio" class="custom-control-input" id="msg-template" name="type-message" value="template">
						  <label class="custom-control-label" for="msg-template">Template</label>
						</div>
			        </div>
			        <div class="form-group">
			        	<label class="mb-0 bold-700">Objet</label>
			        	<input class="form-control" type="text" autocomplete="off" name="objet" >
			        </div>
			        <div class="form-group">
			        	<label class="mb-0 bold-700">Message</label>
			        	<textarea class="form-control" rows="8" name="message" ></textarea>
			        </div>
			        <div class="form-group">
			        	<label class="mb-0 bold-700">Pièce jointe</label>
			        	<input type="file" name="piece-jointe" id="email-attachement" class="d-none">
			        	<label for="email-attachement" class="btn btn-sm btn-primary">
			        		<i class="fas fa-paperclip"></i>
			        		<span class="ml-2">Importer un fichier</span>
			        	</label>
			        	<p class="text-small text-info py-0 my-0" id="name-attachement"></p>
			        </div>	
			
	        </div>
	        <div class="col-md-6">
	        	<div class="form-group">
			        <label class="bold-700">Déstinataire</label>
					<div class="custom-control custom-radio">
						<input type="radio" class="custom-control-input radio-destinataire" id="msg-all" name="dest-message" checked value="1">
						<label class="custom-control-label" for="msg-all">Tous les contacts</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" class="custom-control-input radio-destinataire" id="msg-choose" name="dest-message" value="2">
						<label class="custom-control-label" for="msg-choose" id="label-msg-choose">Choisir</label>
					</div>
					<div id="list-contact-selected" class="bg-white py-2 scroll-moz scroll-all d-none ">
						<p class="text-small text-danger ml-4">Aucun contact selectionné</p>


						<!--<ul>
							<li class="text-small text-info">Contact 1</li>
							<li class="text-small text-info">Contact 2</li>
						</ul>-->

						
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" class="custom-control-input radio-destinataire" id="msg-file" name="dest-message" value="3">
						<label class="custom-control-label" for="msg-file">Fichier texte</label>
					</div>
					<div class="form-group mt-4 d-none" id="import-mail-txt">
						<input id="email-list-text-input" class="form-control form-control-sm" readonly>
			        	<input type="file" name="destinataire-text" id="email-list-text" class="d-none">
			        	<label for="email-list-text" class="btn btn-sm btn-primary">
			        		<i class="fas fa-paperclip"></i>
			        		<span class="ml-2">Importer un fichier</span>
			        	</label>
			        </div>	
			    </div>
<!-- 			    <div class="form-group">
			        <label class="bold-700 mb-0">Intervalle entre message (millisecondes)</label>
			        <input class="form-control" type="number" value="500"   autocomplete="off" id="intervalle-send-mail" >
			    </div> -->
	        </div>


		</div>
				<div class="form-group text-right" >
				    <button class="btn btn-primary" type="submit">
				        <i class="fas fa-share"></i>
				        <span class="ml-2">Envoyer</span>
				    </button>
				</div>
	</form>
</div>







<!--Modal choix destinataire-->
<div class="modal fade" id="choose-dest-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="static">


  <div class="modal-dialog modal-xl" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Choix destinataires</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

	  	<div class="custom-control custom-checkbox mb-2 d-none" id="select-all-contact-wrapper">
		    <input type="checkbox" class="custom-control-input" id="select-all-contact">
		    <label class="custom-control-label bold-700" for="select-all-contact" id="select-all-contact-label">Séléctionner tous</label>
		</div>
	  	<div class="row list-destinataire scroll-moz scroll-all">
	  	 	<div class="col-md-6">
	  	 		<ul class="list-group" id="list-destinataire-1">


				</ul>
	  	 	</div>
	  	 	<div class="col-md-6">
	  	 		<ul class="list-group" id="list-destinataire-2">


	  	 		</ul>
	  	 	</div>
	  	 </div>			 
      </div>
      <div class="modal-footer justify-content-between">
      	<span>
      		<strong class="bold-700 h5" id="nbre-contact-selected">0</strong>
      		<span class="ml-1">Contact(s) selectionné</span>
      	</span>
        <button type="button" class="btn btn-warning btn-sm" id="btn-choix-contact" >Valider</button>
      </div>
    </div>
  </div>
</div>









<div class="modal" id="intervalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
   	<div class="modal-content">
	    <div class="modal-header">
	        <h4 class="modal-title w-100" id="myModalLabel">Envoie en cours...</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	           <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	      	<div class="w-100 text-center">
	      		<img src="<?= base_url('public/IMAGE/pulse.gif') ?>" alt="loading..." >
	      		<p class="h4 bold-700">
	      			<span id="mail-envoye" class="text-muted">10</span> /
	      			<span id="mail-total">100</span>	
	      		</p>
	      	</div>		
	    </div>
    </div>
  </div>
</div>