<?php
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<form class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label class="col-lg-3 control-label">{{Le plugin doit réagir aux interactions}}</label>
            <div class="col-lg-4">
                <textarea class="configKey form-control" data-l1key="interact::sentence"></textarea>
            </div>
        </div>
    </fieldset>
</form>
