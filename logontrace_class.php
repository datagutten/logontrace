<?php
class logontrace
{
	public $filepath;
	public $fields;
	function __construct()
	{
		require 'config.php';
		$this->filepath=$filepath;
		$this->fields=array('userid'=>'User ID','hostname'=>'Host name','uptime'=>'Uptime','ip'=>'IP Address','rdp_clientname'=>'RDP client name','rdp_sessionname'=>'RDP session name','date'=>'Date','time'=>'Time','fullname'=>'Full name');
		/*@USERID+","+@WKSTA+","+$uptime+","+@IPAddress0+","+%CLIENTNAME%+","+%SESSIONNAME%+","+@DATE+","+@TIME+","+@FULLNAME+@CRLF
    <td>Fullt navn:</td>
    <td>Brukernavn:</td>
    <td>Maskinnavn:</td>
    <td>Uptime:</td>
    <td>IP:</td>
    <td>Påloggingstidspunkt:</td>
    <td>Klientnavn:</td>
    <td>RDP &oslash;ktnavn:</td>*/
	}
	public function getusers()
	{
		foreach(scandir($this->filepath) as $file)
		{
			if(substr($file,-3,3)!='txt')
				continue;
			$users[]=substr($file,0,-4);
		}
		return $users;
	}
	function getlogons($user)
	{
		if(!file_exists($file=$this->filepath.'/'.$user.'.txt'))
			return false;
		$logondata=trim(file_get_contents($file));
		//$logondata=utf8_encode(trim(file_get_contents($file)));
		$fieldkeys=array_keys($this->fields);
		foreach (explode("\r\n",$logondata) as $key=>$line)
		{
			$logon=array_combine($fieldkeys,explode(',',$line));
			$logon['timestamp']=strtotime($logon['date'].' '.$logon['time']);
			$logons[]=$logon;
		}
		return $logons;
	}
}
