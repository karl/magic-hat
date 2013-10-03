<?

function __($text) {
  return htmlspecialchars($text);
}

function unichr($u) {
    return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
}

$groupId = $_GET['group'];

if (isset($_POST['name'])) {
  
  $groupName = stripslashes($_POST['name']);
  $lists = array();

  $list_index = 0;
  while (isset($_POST['list-' . $list_index])) {
    $names = explode("\r\n", stripslashes($_POST['list-' . $list_index]));
    $list = array();

    foreach ($names as $index => $name) {
      if (trim($name) === '') {
        continue;
      }

      $list[] = array(
        "id" => $index,
        "name" => $name
      );
    }
   
    $lists[] = $list;
    $list_index++;
  }

  $group = array(
    "name" => $groupName,
    "lists" => $lists,
    "showImages" => $_POST['showImages'] == "on"
  );

  $json = preg_replace_callback('/\\\u(\w\w\w\w)/', 
      function($matches)
      {
          return unichr(hexdec($matches[1]));
      }
      , json_encode($group));


  if ($groupName === '') {
    $saved = "failed";
  } else {
    @rename("../groups/$groupId.json", "../groups/$groupId.backup.json");
    $json = file_put_contents("../groups/$groupName.json", $json);

    $saved = "success";
  }

} else {

  $json = @file_get_contents("../groups/$groupId.json");

  if (!$json) {
    $json = '{ "name": null, "people": [], "showImages": true }';
  }

  $group = json_decode($json, true);
  
  if (!isset($group['lists'])) {
    $group['lists'] = Array($group['people']);
  }

  $json = json_encode($group);

}

require('edit.tpl.php');


?>