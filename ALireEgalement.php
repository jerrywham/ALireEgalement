<?php
/**
* Plugin ALireEgalement
*
* @package	PLX
* @version	1.0
* @date	12/08/17
* @author Cyril MAGUIRE
**/
class ALireEgalement extends plxPlugin {
	public function __construct($default_lang) {
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		
		# limite l'acces a l'ecran de configuration du plugin
		# PROFIL_ADMIN , PROFIL_MANAGER , PROFIL_MODERATOR , PROFIL_EDITOR , PROFIL_WRITER
		$this->setConfigProfil(PROFIL_ADMIN);
		
		
		# Declaration d'un hook (existant ou nouveau)
		$this->addHook('aLireEgalement','aLireEgalement');

		
	}

	# Activation / desactivation
	public function OnActivate() {
		# code à executer à l’activation du plugin
	}
	public function OnDeactivate() {
		# code à executer à la désactivation du plugin
	}
	

	########################################
	# HOOKS
	########################################


	########################################
	# aLireEgalement
	########################################
	# Description:
	public function aLireEgalement(){
		$plxMotor = plxMotor::getInstance();
		$plxShow = plxShow::getInstance();
		$formatThumb = '<img class="art_thumbnail" src="#img_url" alt="#img_alt" title="#img_title" />';
		$format = html_entity_decode($this->getParam('format'));
		if ($this->getParam('catActiveOuId') == 0) {
			$cat_ids = $plxShow->artActiveCatIds();
			$cat_ids = ($cat_ids ? implode('|', $cat_ids) : '');
		} else {
			$cat_ids = str_pad(intval($this->getParam('catActiveOuId')),3,'0',STR_PAD_LEFT);
		}
		# Recherche de tous les articles publiés dans la catégorie paramétrée/les catégories actives de l'article en cours de lecture
		$plxGlob_arts = clone $plxMotor->plxGlob_arts;
		$motif = '/^[0-9]{4}.((?:[0-9]|home|,)*(?:'.str_pad($cat_ids,3,'0',STR_PAD_LEFT).')(?:[0-9]|home|,)*).[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
		$aFiles = $plxGlob_arts->query($motif,'art','rsort',0,9999,'before');
		$sizeofaFiles = sizeof($aFiles);
		if ($aFiles AND $sizeofaFiles > 1) {
			$arts = array();
			# Recherche aléatoire des articles
			$random = array_rand($aFiles,($this->getParam('nb_art') > $sizeofaFiles ? $sizeofaFiles : $this->getParam('nb_art')));
			foreach ($random as $numart) {
				# On ne liste pas l'article en cours
				if ($plxMotor->plxRecord_arts == null || ($aFiles[$numart] <> basename($plxMotor->plxRecord_arts->f('filename'))) ) {
					$art = $plxMotor->parseArticle(PLX_ROOT.$plxMotor->aConf['racine_articles'].$aFiles[$numart]);
					$row = str_replace('#art_url', $plxMotor->urlRewrite('?article'.intval($art['numero']).'/'.$art['url']), $format);
					$row = str_replace('#art_title', plxUtils::strCheck($art['title']),$row);
					$row = str_replace('#art_chapo', html_entity_decode($art['chapo']),$row);
					$row = str_replace('#art_content', html_entity_decode($art['content']),$row);
					$row = str_replace('#art_date', plxDate::formatDate($art['date'],'#num_day/#num_month/#num_year(4)'),$row);
					$author = plxUtils::getValue($plxMotor->aUsers[$art['author']]['name']);
					$row = str_replace('#art_author', plxUtils::strCheck($author),$row);
					$imgUrl = plxUtils::strCheck($art['thumbnail']);
					if($imgUrl) {
						$thumb = str_replace('#img_url', $plxMotor->urlRewrite($imgUrl), $formatThumb);
						if ($plxMotor->plxRecord_arts != null) {
							$thumb = str_replace('#img_title', plxUtils::strCheck($plxMotor->plxRecord_arts->f('thumbnail_title')), $thumb);
							$thumb = str_replace('#img_alt', $plxMotor->plxRecord_arts->f('thumbnail_alt'), $thumb);
						} else {
							$thumb = str_replace('#img_title', '', $thumb);
							$thumb = str_replace('#img_alt', '', $thumb);
						}
						$row = str_replace('#art_thumb', $thumb, $row);

					} else {
						$row = str_replace('#art_thumb', '', $row);
					}
					$arts[] = $row;
				}
			}
		}
		if (isset($arts)) {
			return implode('',$arts);
		} else {
			return '';
		}
	}
}





/* Pense-bete:
 * Récuperer des parametres du fichier parameters.xml
 *	$this->getParam("<nom du parametre>")
 *	$this-> setParam ("param1", 12345, "numeric")
 *	$this->saveParams()
 *
 *	plxUtils::strCheck($string) : sanitize string
 *
 * 
 * Quelques constantes utiles: 
 * PLX_CORE
 * PLX_ROOT
 * PLX_CHARSET
 * PLX_PLUGINS
 * PLX_CONFIG_PATH
 * PLX_ADMIN (true si on est dans admin)
 * PLX_CHARSET
 * PLX_VERSION
 * PLX_FEED
 *
 * Appel de HOOK dans un thème
 *	eval($plxShow->callHook("ThemeEndHead","param1"))  ou eval($plxShow->callHook("ThemeEndHead",array("param1","param2")))
 *	ou $retour=$plxShow->callHook("ThemeEndHead","param1"));
 */