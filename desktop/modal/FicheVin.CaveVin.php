<?php
if (!isConnect('admin')) {
    throw new Exception('401 Unauthorized');
}
include_file('core', 'mesVin', 'class', 'CaveVin');
?>
<form class="form-horizontal">
    <fieldset>
		<div class="selecVin">
			<!--a class="btn btn-success mesVinAction" data-action="update"><i class="fa fa-check-circle"></i> {{Ajouter / modifier}}</a-->
			<select class="vinChoix">
				<option value="">---------</option>
				<?php
					foreach(mesVin::all() as $Vin){
						echo '<option value="'.$Vin->getId().'">'.$Vin->getNom().'</option>';
					}
				?>
			</select>
		</div>
		<table class="mesVin" style="width:100%;height: 500px;">
			<tr>
				<td colspan="2">	
					<input type="hidden" class="mesVinAttr form-control" data-l1key="id"/>
					<center><input type="text" class="mesVinAttr form-control " data-l1key="Nom" placeholder="{{Saisir le nom de votre vin}}"/></center>
				</td>
			</tr>
			<tr>
				<td style="width: 40%;">
					<table style="width: 90%;">	
						<tr>
							<td>
								<textarea cols="2" rows="10" class="mesVinAttr form-control " data-l1key="Vinification" placeholder="{{Saisir une courte description du vin et/ou du vignoble}}"></textarea>
							</td>
						</tr>			
						<tr>	
							<td>
								<input id="bt_uploadEttiquette" type="file" name="file" data-url="plugins/CaveVin/core/ajax/CaveVin.ajax.php?action=uploadEttiquette" placeholder="{{Importer a votre fiche l'étiquette de votre vin}}"/>
								<input class="mesVinAttr form-control" type="hidden" data-l1key="Ettiquette"/>
								<img class="imgEttiquette img-responsive">			
							</td>	
						</tr>
					</table>
				</td>
				<td style="width: 60%;">
					<table style="width: 90%;">				
						<tr>		
							<td>Cépage: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Cepage" placeholder="{{Saisir le cepage de votre vin}}"/>
							</td>
						</tr>
						<tr>
							<td>Couleur: </td>
							<td>
								<select class="mesVinAttr form-control " data-l1key="Couleur" >
									<option value="Rouge">Rouge</option>
									<option value="Rose">Rose</option>
									<option value="Blanc">Blanc</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Millésime: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Millesime" placeholder="{{Saisir le millésime de votre vin}}" />
							</td>
						</tr>
						<tr>
							<td>Terroir: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Terroir" placeholder="{{Saisir le terroir}}"/>
							</td>
						</tr>
						<tr>
							<td>Degre Alcoolique: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="DegreAlcoolique" placeholder="{{Saisir son degré d'alcool}}"/>
							</td>
						</tr>
						<tr>
							<td>Date d'apogée: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Apogee" placeholder="{{Saisir la date d'apogé si vous la connaissez}}"/>
							</td>
						</tr>
						<tr>
							<td>Date de garde: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Garde" placeholder="{{Saisir la date limite de garde si vous la connaissez}}"/>
							</td>
						</tr>
						<tr>
							<td>Température idéale de consommation: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="TempIdeal" placeholder="{{Saisir la température idéal si vous la connaissez}}" />
							</td>
						</tr>
						<tr>
							<td>Laisser décanter: </td>
							<td>
								<input type="text" class="mesVinAttr form-control " data-l1key="Decanter" placeholder="{{Saisir la temps de decantage si vous le connaissez}}"/>
							</td>
						</tr>
						<tr>
							<td>Volume: </td>
							<td>
								<select class="mesVinAttr form-control " data-l1key="Volume" >
									<option value="0.05">{{Mignonette (5cl)}}</option>
									<option value="0.35">{{Demi-bouteille (35cl)}}</option>
									<option value="0.375">{{Fillette (37,5cl)}}</option>
									<option value="0.46">{{Pot (46cl)}}</option>
									<option value="0.5">{{Désirée (50cl)}}</option>
									<option value="0.62">{{Clavelin (62cl)}}</option>
									<option value="0.75">{{Bouteille (75cl)}}</option>
									<option value="0.8">{{Namuroise (80cl)}}</option>
									<option value="1.28">{{Grosse panse (1,28l)}}</option>
									<option value="1.5">{{Fiasque (1,5l)}}</option>
									<option value="10">{{Dame-jeanne (10l)}}</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Plat a associer: </td>
							<td>
								<select class="mesVinAttr form-control " data-l1key="Met" multiple>
									<option value="apero">{{Apéritif}}</option>
									<option value="fromage">{{Fromage}}</option>
									<option value="gibier">{{Gibier}}</option>
									<option value="blanc">{{Viande blanche}}</option>
									<option value="rouge">{{Viande rouge}}</option>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">	
                         		<a class="btn btn-danger mesVinAction" data-action="del"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                         		<a class="btn btn-success mesVinAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                        		<a class="btn btn-warning mesVinAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Enlever}}</a>
                        		<a class="btn btn-primary mesVinAction" data-action="add"><i class="fa fa-check-circle"></i> {{Ajouter}}</a>
				</td>
			</tr>
		</table>
    </fieldset>
</form>
<script>
	$('#bt_uploadEttiquette').hide();
	$('.mesVinAction[data-action=save]').hide();
	$('.mesVinAction[data-action=del]').hide();
	$('.mesVinAction[data-action=remove]').hide();
	$('.mesVinAction[data-action=add]').hide();
	$('.mesVinAttr').prop( "disabled", true );
	if ($('.mesVinAttr[data-l1key=id]') == ''){
		$('.mesVinAction[data-action=save]').hide();
	}
	$('.vinChoix').on('change',function(){
		getVinInformation($(this).val());
		$('.mesVinAction[data-action=remove]').show();
		$('.mesVinAction[data-action=save]').show();
	});
	$('.mesVinAction[data-action=new]').on('click', function () {
		getVinInformation('');
		$('.mesVinAction[data-action=update]').trigger('click');
	});
	$('.mesVinAction[data-action=update]').on('click', function () {
		$('#bt_uploadEttiquette').show();
		$('.mesVinAttr').prop( "disabled", false);
		$('.mesVinAction[data-action=save]').show();
		$('.mesVinAction[data-action=del]').show();
		$('.mesVinAction[data-action=remove]').hide();
		$('.mesVinAction[data-action=add]').hide();
	});
	$('#bt_uploadEttiquette').fileupload({
		dataType: 'json',
		replaceFileInput: false,
		done: function (e, data) {
			if (data.result.state != 'ok') {
				$('#div_alert').showAlert({message: data.result.result, level: 'danger'});
				return;
			}
			$('#div_alert').showAlert({message: '{{L\'image a été ajouté avec succès.}}', level: 'success'});
			$('.mesVinAttr[data-l1key=Ettiquette]').val(data.result.result);
			$('.mesVinAttr[data-l1key=Ettiquette]').parent().find('.imgEttiquette').attr('src',data.result.result).show();
		}
	});
	$('.mesVinAction[data-action=save]').on('click', function () {
			var newVin = $(this).closest('.mesVin').getValues('.mesVinAttr');
			newVin = newVin[0];
			$.ajax({
				type: 'POST',
				url: 'plugins/CaveVin/core/ajax/CaveVin.ajax.php',
				data: {
					action: 'updateVin',
					event: json_encode(newVin)
				},
				dataType: 'json',
				error: function (request, status, error) {
					handleAjaxError(request, status, error, $('#div_alert'));
				},
				success: function (data) {
					if (data.state != 'ok') {
						$('#div_alert').showAlert({message: data.result, level: 'danger'});
						return;
					}
					$('#bt_uploadEttiquette').hide();
					$('.mesVinAttr').prop( "disabled", true );			
					$('.mesVinAttr[data-l1key=id]').val(data.result.id);
					UpdateListVin();
					$('.mesVinAction[data-action=save]').hide();
					$('.mesVinAction[data-action=del]').hide();
					$('.mesVinAction[data-action=remove]').hide();
					$('.mesVinAction[data-action=add]').hide();
				}
			});
	});
	$('.mesVinAction[data-action=del]').on('click', function () {
			bootbox.confirm('{{Etes vous certain de vouloire supprimer ce vin de la base? }}', function (result) {
				if (result) {
					$.ajax({
						type: 'POST',
						url: 'plugins/CaveVin/core/ajax/CaveVin.ajax.php',
						data: {
							action: 'removeVin',
							id:$('.mesVinAttr[data-l1key=id]').val(),
						},
						dataType: 'json',
						error: function (request, status, error) {
							handleAjaxError(request, status, error, $('#div_alert'));
						},
						success: function (data) {
							if (data.state != 'ok') {
								$('#div_alert').showAlert({message: data.result, level: 'danger'});
								return;
							}
							$('#bt_uploadEttiquette').hide();
							$('.mesVinAttr').prop( "disabled", true );	
							UpdateListVin();
							getVinInformation(1);
							$('.mesVinAction[data-action=save]').hide();
							$('.mesVinAction[data-action=del]').hide();
							$('.mesVinAction[data-action=remove]').hide();
							$('.mesVinAction[data-action=add]').hide();
						}
					});
				}
			});
	});
	$('.mesVinAction[data-action=add]').on('click', function () {
		if(logement!='')
			Gestionbouteille(logement,true,$('.mesVinAttr[data-l1key=id]').val());
		$('#md_modal').dialog( "close" );
	});
	$('.mesVinAction[data-action=remove]').on('click', function () {
		if(logement!='')
      			Gestionbouteille(logement,false,'');
		$('#md_modal').dialog( "close" );
	});
	function Gestionbouteille(logement,status,typeVin) {
		if(logement!=""){
			$.ajax({
				type: 'POST',            
				async: false,
				url: 'plugins/CaveVin/core/ajax/CaveVin.ajax.php',
				data:{
					action: 'gestionBouteille',
					logement:logement,
					status:status,
					type:typeVin
				},
				dataType: 'json',
				global: false,
				error: function(request, status, error) {},
				success: function(data) {
				}
			});
		}
	};
	function getVinInformation(id) {
		$('.mesVinAttr').val('');
		$('.mesVinAttr[data-l1key=Ettiquette]').parent().find('.imgEttiquette').hide();
		$('.mesVinAttr').prop( "disabled", true);
		if(id!=''){
			$('.mesVinAction[data-action=save]').hide();
			$('.mesVinAction[data-action=del]').hide();
			$('.mesVinAction[data-action=remove]').show();
			$('.mesVinAction[data-action=add]').show();
			$.ajax({
				type: 'POST',            
				async: false,
				url: 'plugins/CaveVin/core/ajax/CaveVin.ajax.php',
				data:{
					action: 'getVinInformation',
					id:id
				},
				dataType: 'json',
				global: false,
				error: function(request, status, error) {},
				success: function(data) {	
					$('.mesVinAttr[ data-l1key=id]').val(data.result.id);
					$('.mesVinAttr[ data-l1key=Nom]').val(data.result.Nom);
					$('.mesVinAttr[ data-l1key=Cepage]').val(data.result.Cepage);
					$('.mesVinAttr[ data-l1key=Couleur]').val(data.result.Couleur);
					$('.mesVinAttr[ data-l1key=Millesime]').val(data.result.Millesime);
					$('.mesVinAttr[ data-l1key=Terroir]').val(data.result.Terroir);
					$('.mesVinAttr[ data-l1key=DegreAlcoolique]').val(data.result.DegreAlcoolique);
					$('.mesVinAttr[ data-l1key=Vinification]').val(data.result.Vinification);
					$('.mesVinAttr[ data-l1key=TempIdeal]').val(data.result.TempIdeal);
					$('.mesVinAttr[ data-l1key=Decanter]').val(data.result.Decanter);
					$('.mesVinAttr[ data-l1key=Volume]').val(data.result.Volume);
					$('.mesVinAttr[data-l1key=Met]').val(data.result.Met);
					$('.mesVinAttr[data-l1key=Ettiquette]').val(data.result.Ettiquette);
					$('.mesVinAttr[data-l1key=Apogee]').val(data.result.Apogee);
					$('.mesVinAttr[data-l1key=Garde]').val(data.result.Garde);
					if(data.result.Ettiquette!=''&&data.result.Ettiquette!='NULL')
						$('.mesVinAttr[data-l1key=Ettiquette]').parent().find('.imgEttiquette').attr('src',data.result.Ettiquette).show();
				}
			});
		}else{			
			$('.mesVinAction[data-action=save]').hide();
			$('.mesVinAction[data-action=del]').hide();
			$('.mesVinAction[data-action=remove]').show();
			$('.mesVinAction[data-action=add]').hide();	
		}		
	};
</script>
