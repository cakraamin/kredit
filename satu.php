<?php
$post = [
    'SupplierKey' 		=> 'dg44QTkXRD5EZZfZikCkDm3RQXZwWIvl',
    'CategoryID' 		=> '27',
    'AmountFinance'   	=> '3000000',
    'Tenor'				=> '12'
];

$query = http_build_query($post, '', '&');

$ch = curl_init('http://182.23.26.233:8094/kpservices/kreditplus.asmx/CityReq');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
//var_dump($response);

$xml = simplexml_load_string($response);
if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
    $sxe = new SimpleXMLElement($response);
    $sxe->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');
    $result = $sxe->xpath("//NewDataSet");    
    $no = 1;
    foreach ($result[0] as $title) {        
        
        $post = [
            'ResidenceCity'       => (string)$title->ResidenceCity,
        ];

        $query = http_build_query($post, '', '&');

        $ch_city = curl_init('http://182.23.26.233:8094/kpservices/kreditplus.asmx/KecamatanReq');
        curl_setopt($ch_city, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_city, CURLOPT_POSTFIELDS, $query);
        
        $response_city = curl_exec($ch_city);
        
        curl_close($ch_city);        

        $xml_city = simplexml_load_string($response_city);
        if ($xml_city === false) {
            echo "Failed loading XML: ";
            foreach(libxml_get_errors() as $error) {
                echo "<br>", $error->message;
            }
        } else {
            $sxe_city = new SimpleXMLElement($response_city);
            $sxe_city->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');
            $result_city = $sxe_city->xpath("//NewDataSet");    
            $no = 1;
            foreach ($result_city[0] as $title_city) {   

                $post_kel = [
                    'ResidenceCity'         => 'AGAM',
                    'ResidenceKecamatan'    => 'BANUHAMPU'
                ];

                $query_kel = http_build_query($post_kel, '', '&');

                $ch_kel = curl_init('http://182.23.26.233:8094/kpservices/kreditplus.asmx/KelurahanReq');
                curl_setopt($ch_kel, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_kel, CURLOPT_POSTFIELDS, $query_kel);
                
                $response_kel = curl_exec($ch_kel);
                
                curl_close($ch_kel);                

                $xml_kel = simplexml_load_string($response_kel);
                if ($xml_kel === false) {
                    echo "Failed loading XML: ";
                    foreach(libxml_get_errors() as $error) {
                        echo "<br>", $error->message;
                    }
                } else {
                    $xml_kel = new SimpleXMLElement($response_kel);
                    $xml_kel->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');
                    $result_kel = $xml_kel->xpath("//NewDataSet");    

                    foreach ($result_kel[0] as $title_kel) {

                        $post_code = [
                            'ResidenceCity'         => 'AGAM',
                            'ResidenceKecamatan'    => 'BANUHAMPU',
                            'ResidenceKelurahan'    => 'LADANG LAWEH'
                        ];

                        $query_code = http_build_query($post_code, '', '&');

                        $ch_code = curl_init('http://182.23.26.233:8094/kpservices/kreditplus.asmx/ZipCodeReq');
                        curl_setopt($ch_code, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch_code, CURLOPT_POSTFIELDS, $query_code);
                        
                        $response_code = curl_exec($ch_code);
                        
                        curl_close($ch_code);                        

                        $xml_code = simplexml_load_string($response_code);
                        if ($xml_code === false) {
                            echo "Failed loading XML: ";
                            foreach(libxml_get_errors() as $error) {
                                echo "<br>", $error->message;
                            }
                        } else {
                            $xml_code = new SimpleXMLElement($response_code);
                            $xml_code->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');
                            $result_code = $xml_code->xpath("//NewDataSet");    
                            $no = 1;
                            foreach ($result_code[0] as $title_code) {                        
                                echo $no." ".$title->ResidenceCity." ".$title_city->ResidenceKecamatan." ".$title_kel->ResidenceKelurahan." ".$title_code->ResidenceZipCode."<br/>";
                                //echo $no." ".$title_code->ResidenceZipCode."<br/>";
                                $no++;
                            }
                        }

                        //echo $no." ".$title->ResidenceCity." ".$title_city->ResidenceKecamatan." ".$title_kel->ResidenceKelurahan."<br/>";
                        //$no++;
                    }
                }
                //echo $no." ".$title->ResidenceCity." ".$title_city->ResidenceKecamatan."<br/>";
                //$no++;
            }
        }

        //echo $no.". ".$title->ResidenceCity."<br/>";
        //$no++;     
    }
    die;
    //print_r($xml);
    //echo $xml->InstallmentAmount;
}
?>