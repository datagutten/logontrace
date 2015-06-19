<?Php
//Usage sample:
//find /path/to/logondata/*.txt -exec php /path/to/logontrace/cleanfile.php {} \;
require 'logontrace_class.php';
$logontrace=new logontrace;
$fp=fopen('temp.txt','w');
$user=$argv[1];
if(substr($user,-3,3)=='txt')
	$user=substr(basename($user),0,-4);
foreach($logontrace->getlogons($user) as $key=>$logon)
{
	if($logon['timestamp']>strtotime('-7 days'))
	{
		$keeplogon=$logon;
		unset($keeplogon['timestamp']);
		fwrite($fp,implode(",",$keeplogon)."\r\n");
	}
}
fclose($fp);

unlink($logontrace->filename($user));
if(isset($keeplogon))
	rename('temp.txt',$logontrace->filename($user));
else
	unlink('temp.txt');
?>