# ALireEgalement

Plugin PluXml pour afficher des suggestions d'articles. Compatible avec la V5.6.

Pour l'utiliser, ajouter l'appel du hook suivant, à l'endroit que vous souhaitez, dans votre thème (par exemple dans le fichier article.php) :

```php
   <?php echo $plxShow->callHook("aLireEgalement");?>
```

Dans la config, il suffit de noter le nombre d'articles à afficher ainsi que la/les catégories concernées.
Si on met 0 pour les catégories, toutes les catégories seront concernées.
Sinon, il suffit de préciser le numéro de la catégorie dont on veut afficher les articles.

On peut également modifier le template d'affichage pour l'adapter à son thème.
