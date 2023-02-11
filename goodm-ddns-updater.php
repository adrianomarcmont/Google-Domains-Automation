<?php
// https://support.google.com/domains/answer/6147083?hl=pt-BR
// Responses:
// good
// nochg
// nohost
// badauth
// notfqdn
// badagent
// abuse
// 911
// conflict

// To Do: 
// comparar o cache DNS local com o cache DNS do Google, pois mudanças recentes de DNS não refletirão na resolução local, ou seja, já estará atualizado no Google Domains mas não no cache DNS local.
// https://dns.google/resolve?name=olimpo.brztec.com&type=AAAA
// https://dns.google/resolve?name=olimpo.brztec.com&type=A	
function getipbydomain($domain){
	
	$dns_query_ipv4 = dns_get_record($domain, DNS_A);
	foreach ($dns_query_ipv4 as $record) {
		$ipv4 = $record['ip'];
	}
	
	$dns_query_ipv6 = dns_get_record($domain, DNS_AAAA);
	foreach ($dns_query_ipv6 as $record) {
		$ipv6 = $record['ipv6'];
	}
	
	if(isset($ipv4)){
		return $ipv4;
	}
	
	if(isset($ipv6)){
		return $ipv6;
	}
}

$username 	= "YOUR_USERNAME";
$password 	= "YOUR_PASSWORD";
$domain		= "olimpo.brztec.com";
$ip_old 	= getipbydomain($domain);
$ip_new		= file_get_contents("https://domains.google.com/checkip");

// To Do: adicionar verificação temporal para evitar loops e ser bloqueado.
if($ip_old == $ip_new){
	echo("No update needed!");
} else {
	$command 	= "https://".$username.":".$password."@domains.google.com/nic/update?hostname=".$domain."&myip=".$ip_new;
	$result		= file_get_contents($command);
	echo ($result);
}

die();
?>