<?php
    $expressions = $this->getVar("expressions", 'pArray');
	$yearStart = $this->getVar("yearStart", 'pInteger');
	$yearEnd = $this->getVar("yearEnd", 'pInteger');
?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css"/>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<h1>Gestion des dates</h1>

<p>Les expressions de dates suivantes sont actuellement configurées.<br/>
Lors du catalogage, la saisie d'une expression de date permet de définir une plage de dates correspondante.<br/>
Par exemple, l'expression correspondante à "XVIIIe siècle" correspond à la plage de dates "1700-1799".</p>
<p>
<u>A noter</u>, les expressions de dates dans CollectiveAccess sont rédigées sous la forme d'une expression texte.<br/>
Dans leur saisie, ne pas mettre de majuscule, d'accents, de ponctuation, de symboles ou de caractères spéciaux.</p>

<form action="/gestion/index.php/DateTimeConfigurator/DateTime/Index" method="get">
<p>Vous pouvez filtrer ce tableau pour n'afficher que les expressions de dates entre : <input type="text" id="yearStart" name="yearStart" placeholder="Année de début" <?= ($yearStart ? "value='$yearStart'" : "") ?> > et <input type="text" id="yearEnd" name="yearEnd" placeholder="Année de fin" <?= ($yearEnd ? "value='$yearEnd'" : "") ?> > <button type="submit">Filtrer</button></p>
</form>

<table id="dataTable" class="display">
    <thead>
        <tr>
            <th>Expression</th>
            <th>Plage de dates correspondante</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th hidden></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($expressions as $expression => $date):
				$tep = new TimeExpressionParser();
				$parsed_date = $tep->parse($date);
				$parsed_date_td = $tep->getHistoricTimestamps();
				$start = round($parsed_date_td["start"]);
				$end = round($parsed_date_td["end"]);
				/*var_dump($start);
				var_dump($end);
				var_dump($yearStart);
				var_dump($yearEnd);*/
				if((!$yearStart && !$yearEnd)||(($yearStart && $yearEnd) && ($yearStart <= $start && $yearEnd >= $end))) {
        ?>
            <tr>
                <td><?= $expression ?></td>
                <td><?= $date ?></td>
                <?php
                    
                    
                    $format_date_start = preg_replace('/^(-?\d{1,4})\.(\d{2})(\d{2})(.*)/', "$3/$2/$1", $parsed_date_td["start"]);
                    $format_date_end = preg_replace('/^(-?\d{1,4})\.(\d{2})(\d{2})(.*)/', "$3/$2/$1", $parsed_date_td["end"]);
                ?>
                <td><?= $format_date_start ?></td>
                <td><?= $format_date_end ?></td>
                <td><a href="Editor?expression=<?= $expression ?>"><i class="caIcon fa fa-file editIcon fa-1x"></i></a></td>
            </tr>
        <?php
				}
            endforeach;
        ?>
    </tbody>
</table>

<a href="Editor">Ajouter nouveau</a>

<div style="padding-bottom: 170px"></div>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/fr-FR.json'
            }
        });
    } );
</script>