$('.eqLogicAttr[data-l1key=configuration][data-l2key=analyse]').on('change', function() {
	if ($(this).val()== 'manual')
		$('.cmdAttr[data-l1key=configuration][data-l2key=SortieBoutielle]').parent().show();
	else
		$('.cmdAttr[data-l1key=configuration][data-l2key=SortieBoutielle]').parent().hide();
});
$('#table_cmd tbody').on( 'click','.bt_selectCmdExpression', function() {
	var _this=this;
	$(this).value()
	jeedom.cmd.getSelectModal({cmd: {type: 'info'},eqLogic: {eqType_name : ''}}, function (result) {
		$(_this).closest('.cmd').find('.cmdAttr[data-l1key=configuration][data-l2key=SortieBoutielle]').val(result.human);
	});
});  
	
function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
        var _cmd = {};
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }
	var tr =$('<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">');
	tr.append($('<td>')
		.append($('<input type="hidden" class="cmdAttr form-control input-sm" data-l1key="id">'))
		.append($('<input type="hidden" class="cmdAttr form-control input-sm" data-l1key="name" value="' + init(_cmd.name) + '">'))
		.append(init(_cmd.name).replace("Courant_","Logement "))
		.append($('<input type="hidden" class="cmdAttr" data-l1key="type" />'))
		.append($('<input type="hidden" class="cmdAttr" data-l1key="subType" />')));
	tr.append($('<td>')
			.append($('<span>')
				.append($('<label>').text('{{Déclencheur sortie Bouteille}}'))
				.append($('<input class="cmdAttr form-control input-sm " data-l1key="configuration" data-l2key="SortieBoutielle" style="width : 90%;display : inline-block;margin:5px;">'))
				.append($('<a style="display : inline-block;margin:5px;"class="btn btn-default btn-xs cursor bt_selectCmdExpression" style="position : relative; top : 3px;" title="{{Rechercher une commande}}" >')
					.append($('<i class="fa fa-list-alt">'))))		 
			.append($('<span>')
				.append($('<label>').text('{{Url de sortie}}'))
				.append($('<span class="cmdAttr" data-l1key="configuration" data-l2key="url">'))));
	tr.append($('<td>')
		.append($('<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure">')
			.append($('<i class="fa fa-cogs">'))));
	$('#table_cmd tbody').append(tr);
	$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
	jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
	}
