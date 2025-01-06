<?php
    $expressions = $this->getVar("expressions", 'pArray');

    if(!empty($_GET)) {
        $key = $_GET["expression"];
        $value = $expressions[$_GET["expression"]] ?? "";
    }

    if(!empty($_POST)) {
        $new_key = $_POST["expression"];
        $new_value = $_POST["dateinterval"];

        $content = file_get_contents(__CA_CONF_DIR__.'/datetime.conf');

        if(isset($key) && preg_match("/$key = $value/", $content))
            $content = preg_replace("/$key = $value/", "$new_key = $new_value", $content);
        else
            $content = implode("\n\t$new_key = $new_value,", [
                substr($content, 0, 296),
                substr($content, 296)
            ]);

        $result = file_put_contents(__CA_CONF_DIR__.'/datetime.conf', $content);

        if(!$result) {
            echo "Erreur lors de l'enregistrement";
            exit;
        }

        $key = $new_key;
        $value = $new_value;
    }
?>

<h1>Modification d'une expression temporelle</h1>
<a class="pull-right" href="Index">Retour</a>
<p style="clear:both">
    Une expression temporelle est une chaîne de caractères qui permet de définir une plage de dates.
</p>
<br>
<form action="" method="POST">
    <label for="expression">Expression</label>
    <input value="<?= $key ?>" type="text" id="expression" name="expression" required>
    <br>
    <br>
    <label for="expression">Plage de dates correspondante</label>
    <input value="<?= $value ?>" type="text" id="dateinterval" name="dateinterval" required>
    <br>
    <br>
    <input type="submit" value="Enregistrer">
</form>
<br>