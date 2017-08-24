<h2>ALireEgalement</h2>

<p>Plugin PluXml pour afficher des suggestions d'articles. Compatible avec la V5.6.</p>

<p>Pour l'utiliser, ajouter l'appel du hook suivant, à l'endroit que vous souhaitez, dans votre thème (par exemple dans le fichier article.php) :</p>
<pre><code><?php echo $plxShow->callHook("aLireEgalement");?></code></pre>

<p>Dans la config, il suffit de noter le nombre d'articles à afficher ainsi que la/les catégories concernées.<br/>
Si on met 0 pour les catégories, toutes les catégories seront concernées.<br/>
Sinon, il suffit de préciser le numéro de la catégorie dont on veut afficher les articles.</p>

<p>On peut également modifier le template d'affichage pour l'adapter à son thème.</p>
