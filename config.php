<?php 
/**
* Plugin ALireEgalement - config page
*
* @package	PLX
* @version	1.0
* @date	12/08/17
* @author Cyril MAGUIRE
**/
if(!defined("PLX_ROOT")) exit; ?>
<?php 
	$format = '&lt;li&gt;#art_date : &lt;a href=&#034;#art_url&#034; title=&#034;#art_title&#034;&gt;#art_title&lt;/a&gt;&lt;/li&gt;';
	if(!empty($_POST)) {
		$plxPlugin->setParam("nb_art", plxUtils::strCheck($_POST["nb_art"]), "numeric");
		$plxPlugin->setParam("format", plxUtils::strCheck($_POST["format"]), "string");
		$plxPlugin->setParam("catActiveOuId", plxUtils::strCheck($_POST["catActiveOuId"]), "numeric");

		$plxPlugin->saveParams();
		header("Location: parametres_plugin.php?p=ALireEgalement");
		exit;
	}
?>

<p><?php $plxPlugin->lang("L_DESCRIPTION") ?></p>
<form action="parametres_plugin.php?p=ALireEgalement" method="post" >

	<p>
		<label><?php $plxPlugin->lang("L_NB_ART") ?> : 
			<input type="text" name="nb_art" value="<?php echo ($plxPlugin->getParam("nb_art") == 0 ? 3 : $plxPlugin->getParam("nb_art"));?>" size="2"/>
		</label>
	</p>
	<p>
		<label><?php $plxPlugin->lang("L_FORMAT") ?> <?php $plxPlugin->lang("L_FORMAT_WARNING") ?> : </label>
			<textarea name="format" cols="100" rows="10"><?php echo ($plxPlugin->getParam("format") == '' ? $format : $plxPlugin->getParam("format"));?></textarea>
	</p>
	<p>
		<label><?php $plxPlugin->lang("L_ACTIVE_CAT_OR_ID") ?> : 
			<input type="text" name="catActiveOuId" value="<?php echo ($plxPlugin->getParam("catActiveOuId") < 0 ? 0 : $plxPlugin->getParam("catActiveOuId"));?>" size="3"/>
		</label>
	</p>

	<br />
	<input type="submit" name="submit" value="<?php $plxPlugin->lang("L_REC") ?>"/>
</form>
