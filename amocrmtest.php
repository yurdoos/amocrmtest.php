if($_GET['cmd']=="newlead"){

$id_lead = $_POST['leads']['add'][0]['id'];
$name_lead = $_POST['leads']['add'][0]['name'];


$user=array(
  'USER_LOGIN'=>'ecoyuriy@gmail.com', 
 'USER_HASH'=>'51df92e8877e255694739b958c0256337858bb20' 
);
$subdomain='test'; 

$link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';

$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl); 



function amocrm_updateLead($id,$name){


$leads['request']['leads']['update']=array(
  array(
    'id'=>$id,
    'name'=>$name.' - '.$id,
    'last_modified'=>time(),
 )
 );
 $link='https://'.ecoyuriy.'.amocrm.ru/private/api/v2/json/leads/set';
 $result = amocrm_Request($link,$leads);

}
//----------------------

function amocrm_Request($link , $params = array()){
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link);
if($params!=null){
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($params));  
}

curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0); 
$out=curl_exec($curl);

$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);
//
$code=(int)$code;
$errors=array(
  301=>'Moved permanently',
  400=>'Bad request',
  401=>'Unauthorized',
  403=>'Forbidden',
  404=>'Not found',
  500=>'Internal server error',
  502=>'Bad gateway',
  503=>'Service unavailable'
);
try
{
if($code!=200 && $code!=204){
 throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
  }
 //   
}
catch(Exception $E)
{
  print('Îřčáęŕ: '.$E->getMessage().PHP_EOL.'Ęîä îřčáęč: '.$E->getCode());
}
 
$Response=json_decode($out,true);
$Response=$Response['response']; #Response - îáúĺęň ęëŕńńŕ StdClass
return $Response;
}

amocrm_updateLead($id_lead,$name_lead);
exit;
