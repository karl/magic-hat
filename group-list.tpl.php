<!DOCTYPE html> 
<html> 
<head> 
    <title>Group List</title> 

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>    
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

</head> 
<body> 

<div id="page"> 

  <h1>Group List</h1>

  <div id="content">
    <? if (count($groups) === 0) { ?>
      <div id="no-one">No groups created yet</div>
    <? } else { ?>
      <ul id="groups">
        <? foreach($groups as $group) {?>
          <li class="group">
            <a href="<?= __($group) ?>"><?= __($group) ?></a> 
            <a href="edit/<?= __($group) ?>" class="edit-button">edit</a>
          </li>
        <? } ?>
      </ul>
    <? } ?>

    <a class="button" id="create-group" href="edit">
      Create New Group
    </a>

  </div>

</div>

</body> 
</html>