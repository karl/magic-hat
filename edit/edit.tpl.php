<!DOCTYPE html>
<html>
<head>
    <title><?= $group['name'] == null ? 'Create' : 'Edit: ' . __($group['name']) ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../styles/main.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>
<body>

<div id="page">

  <a id="back" class="btn btn-default" href="../">◄ Group List</a>

  <h1><?= $group['name'] == null ? 'Create' : 'Editing' ?></h1>

  <? if ($saved === "success") { ?>
    <div id="message">Group saved</div>
  <? } else if ($saved === "failed") { ?>
    <div id="message" class="error">Error saving group</div>
  <? } ?>

  <form id="content" method="post">

    <div id="name-field-container">
      <input id="name-field" class="form-control input-lg" name="name" placeholder="Group Name" value="<?= __($group['name']) ?>" />
    </div>

    <? $width = 100 / max(count($group['lists']), 1); ?>
    <table class="lists-container">
      <tr>

        <? foreach($group['lists'] as $index => $list) { ?>
        <td width="<?= $width ?>%">

              <div class="people-field-container">
<textarea class="people-field form-control input-lg" name="list-<?= $index ?>" placeholder="Names">
<? foreach($list as $person) { ?>
<?= __($person['name']) ?>

<? } ?>
</textarea>
              </div>

        </td>
        <? } ?>

      </tr>
    </table>

    <div class="options">
      <input type="checkbox" name="showImages" id="showImages" <?= $group['showImages'] ? 'checked="checked"' : '' ?> />
      <label for="showImages"> Show Robot Images</label>
    </div>

    <input type="submit" value="Save" class="btn btn-lg btn-primary center-block" />

    <a href="#" class="btn btn-default" id="add-list">+</a>
    <a href="#" class="btn btn-default" id="remove-list">-</a>

  </form>

</div>

<script src="../app.js"></script>

</body>
</html>
