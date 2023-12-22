<h1>Meerdere items:</h1>
<?php foreach (queryMeerdereItems() as $item) {
    print "<pre>". var_export($item,true) ."</pre>";
} ?>

<h4>Enkel item:</h4>
<?php print "<pre>". var_export(queryEnkelItem(),true) ."</pre>"; ?>
