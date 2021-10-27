
	                        <?php foreach($contacts as $contact): ?>
	                        <tr>
	                            <td><?= $contact->email_contact ?> </td>
	                            <td> <?= $contact->firstname_contact ?> <?= $contact->lastname_contact ?></td>
	                            <td><?= $contact->entreprise_contact ?></td>
	                            <td><?= $contact->poste_contact ?></td>
	                            <td><?= $contact->telephone_contact ?></td>
	                            <td>
	                            <span class="mr-2 text-success update-contact" data-contact="<?= $contact->id_contact ?>" data-email="<?= $contact->email_contact ?>" data-firstname="<?= $contact->firstname_contact ?>" data-lastname="<?= $contact->lastname_contact ?>" data-entreprise="<?= $contact->entreprise_contact ?>" data-poste="<?= $contact->poste_contact ?>" data-telephone="<?= $contact->telephone_contact ?>">
	                                    <i class="fas fa-edit" style="color: #096e8d;font-size: 20px;"></i>
	                                </span>
	                                <span class="mr-2 text-danger delete-contact" data-contact="<?= $contact->id_contact ?>">
	                                    <i class="fas fa-trash" style="color:#ed7f15 ;font-size: 20px;"></i>
	                                </span>
	                            </td>
	                        </tr>
	                        <?php endforeach ?>
