<!DOCTYPE html>
<html>
<head>
    <title><?= __($group['name']) ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>
<body>

<div id="player">

  <h1><?= __($group['name']) ?></h1>

  <? $width = 100 / max(count($group['lists']), 1); ?>

  <table class="results-container">
    <tr>

      <? foreach($group['lists'] as $index => $list) {?>
      <td width="<?= $width ?>%">

      <div class="result" id="result-<?= $index ?>">
        <div class="no-one">
          <? if ($group['showImages']) { ?>
          <img class="image" src="images/placeholder.png" />
          <? } ?>
          <div class="name">&nbsp;</div>
        </div>
        <ul class="people">
          <? foreach($list as $person) {?>
            <li class="person person-<?= $person['id'] ?>">
              <? if ($group['showImages']) { ?>
              <img class="image" src="http://robohash.org/<?= __($person['name']) ?>.png" />
              <? } ?>
              <div class="name"><?= __($person['name']) ?></div>
            </li>
          <? } ?>
        </ul>
      </div>

      </td>
      <? } ?>

    </tr>
  </table>

  <button class="btn btn-lg btn-primary center-block" id="chooser"><img src="images/media-shuffle.png" alt="choose" /></button>

</div>


<script>
MH = window.MH || {}
MH.group = <?= $json ?>;
</script>

<script src="app.js"></script>


</body>
</html>
