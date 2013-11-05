<?

function __($text) {
  return htmlspecialchars($text);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

if (isset($_GET['group'])) {
  $groupId = $_GET['group'];

  $json = @file_get_contents("groups/$groupId.json");

  if (!$json) {
    $json = '{ "name": "Unknown Group", "people": [] }';
  }

  $group = json_decode($json, true);

  if (!isset($group['lists'])) {
    $group['lists'] = Array($group['people']);
  }

  $json = json_encode($group);

  require('player.tpl.php');
} else {

  $groups = array();

  if ($handle = opendir('groups')) {
      while (false !== ($file = readdir($handle))) {
          $info = pathinfo($file);
          if ($info['extension'] === 'json' && !endsWith($info['filename'], '.backup')) {
              $groups[] = $info['filename'];
          }
      }
      closedir($handle);
  }

  natsort($groups);

  $json = json_encode($groups);

  require('group-list.tpl.php');
}


?>
