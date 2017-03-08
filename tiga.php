<?php
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

        var_dump($response_kel);

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
            $no = 1;
            foreach ($result_kel[0] as $title_kel) {                        
                echo $no." ".$title_kel->ResidenceKelurahan."<br/>";
                $no++;
            }
        }
?>