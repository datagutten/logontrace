<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Show logons</title>
</head>

<body>

<?Php
require 'logontrace_class.php';
$logontrace=new logontrace;

if (!isset($_GET['user']))
{
	foreach ($logontrace->getusers() as $user)
	{
		echo '<a href="?user='.$user.'">'.$user.'</a><br />';
	}
}
else
{
	echo '<table width="617" border="1">';

    foreach (array_reverse($logontrace->getlogons($_GET['user'])) as $logon)//Hent brukerens pålogginger og vis dem i motsatt rekkefølge
    {
		foreach($logontrace->fields as $fieldkey=>$label)
		{
			if(empty($logon[$fieldkey]))
				continue;
			if($fieldkey=='uptime')
				$logon[$fieldkey]=$logon[$fieldkey]. " minutes";
			echo "<tr>\n";
			echo "\t<td>$label</td>\n"; //Field label
			echo "\t<td>{$logon[$fieldkey]}</td>\n"; //Field value
			echo "</tr>\n";
		}
		echo "<tr>\n";
		echo '<td colspan="2">&nbsp;</td>';
		echo "</tr>\n";
	}
}
?>
</body>
</html>