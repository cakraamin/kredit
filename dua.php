<?php
        $post = [
            'ResidenceCity'       => 'AGAM',
        ];

        $query = http_build_query($post, '', '&');

        $ch_city = curl_init('http://182.23.26.233:8094/kpservices/kreditplus.asmx/KecamatanReq');
        curl_setopt($ch_city, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_city, CURLOPT_POSTFIELDS, $query);
        
        $response_city = curl_exec($ch_city);
        
        curl_close($ch_city);

        var_dump($response_city);

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
                echo $no." ".$title_city->ResidenceKecamatan."<br/>";
                $no++;
            }
        }
?>