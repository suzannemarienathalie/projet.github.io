<div class="container-fluid">
	<h1 class="pb-2 bold-700">Ajouter contact</h1>
	<hr class="mt-0">
	<div class="row">
		<div class="col-md-6">
			<form id="form-addContact" action="<?= base_url("Contact/create") ?>">
				<input type="hidden" name="id_contact" value="-1" id="id-contact-input">
				<div class="form-group">
					<label class="bold-700 mb-0">Email</label>
					<input class="form-control form-control-sm" type="email" name="email_contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="bold-700 mb-0">Nom</label>
					<input class="form-control form-control-sm" type="text" name="firstname_contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="bold-700 mb-0">Prénom(s)</label>
					<input class="form-control form-control-sm" type="text" name="lastname_contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="bold-700 mb-0">Entreprise</label>
					<input class="form-control form-control-sm" type="text" name="entreprise_contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="bold-700 mb-0">Poste</label>
					<input class="form-control form-control-sm" type="text" name="poste_contact" autocomplete="off"> 
				</div>
				<div class="form-group">
					<label class="bold-700 mb-0">Téléphone</label>
					<input class="form-control form-control-sm" type="text" name="telephone_contact" autocomplete="off">
				</div>

				<div class="form-group text-right">
					<button type="submit" class="btn btn-primary">
						<i class="fas fa-save"></i>
						<span class="ml-2" id="btn-submit-contact">Enregistrer</span>
					</button>
				</div>
			</form>
		</div>

		<div class="col-12">
			<div class="table-responsive scroll-moz scroll-all px-0 table-contact">

	                <table id="" class="table table-striped table-bordered table-sm tableau-sticky">
	                    <thead>
	                        <tr >
	                            <th class="th-lg">Email</th>
	                            <th class="th-lg">Nom et Prénom(s)</th>
	                            <th class="th-lg">Entreprise</th>
	                            <th class="th-lg">Poste</th>
	                            <th class="th-lg">Téléphone</th>
	                            <th class="th-lg">Action</th>
	                        </tr>
	                    </thead>

	                    <tbody id="table-list-contact">
	                      <tr>
                              <td colspan="6">
                               <div style="height: 20vh;" class="d-flex align-items-center justify-content-center">
                               <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                               </div>
                               </div>
                              </td>     
                        </tr> 
	                    </tbody>
	                </table>
	        </div>
        </div>
	</div>
	
</div>