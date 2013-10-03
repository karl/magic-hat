<!DOCTYPE html> 
<html> 
<head> 
    <title><?= $group['name'] == null ? 'Create' : 'Edit: ' . __($group['name']) ?></title> 

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>    
    <link href="../styles/main.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

</head> 
<body> 

<div id="page"> 

  <a id="back" class="small-button" href="../">◄ Group List</a>

  <h1><?= $group['name'] == null ? 'Create' : 'Editing' ?></h1>

  <? if ($saved === "success") { ?>
    <div id="message">Group saved</div>
  <? } else if ($saved === "failed") { ?>
    <div id="message" class="error">Error saving group</div>
  <? } ?>

  <form id="content" method="post">

    <div id="name-field-container">
      <input id="name-field" name="name" placeholder="Group Name" value="<?= __($group['name']) ?>" />
    </div>

    <? $width = 100 / count($group['lists']); ?>
    <table class="lists-container">
      <tr>

        <? foreach($group['lists'] as $index => $list) { ?>
        <td width="<?= $width ?>%">
          
              <div class="people-field-container">
<textarea class="people-field" name="list-<?= $index ?>" placeholder="Names">
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

    <input type="submit" value="Save" class="button" />

    <a href="#" class="small-button" id="add-list">+</a>
    <a href="#" class="small-button" id="remove-list">-</a>

  </form>

</div>

<script src="../app.js"></script>

</body> 
</html>