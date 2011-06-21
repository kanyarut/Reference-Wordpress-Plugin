<?
/*-----------------------------------------------------
Google Books API
Created by: *nice*
Version: 1.0 
Since: 2011-05-11
-----------------------------------------------------*/
class gBook{
	private $booksurl 	= 'https://www.googleapis.com/books/v1/volumes';
	private $apikey;
	
	function __construct($ak){
		$this->apikey = $ak;
	}
	
	function getList($params){
		return $this->gaConnect($params);
	}
	
	function gaConnect($params){
		if(function_exists('curl_exec'))
		{
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$url =	$this->booksurl."?key=".$this->apikey."&".http_build_query($params);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result=curl_exec($ch); 
			$info = curl_getinfo($ch);		
			curl_close($ch); 
			
			if($result==false || $info['http_code']!=200){
				echo "Fetch data error: ".$this->apikey." $result";
				exit();
				return false;
			}else{
				return json_decode($result, true);
			}
		}else{
			//no curl
			echo "Error no cURL funcition";
			exit();
			return false;
		}
	}
}
?>