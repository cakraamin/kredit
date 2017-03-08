<?php
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

        var_dump($response_code);

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
                echo $no." ".$title_code->ResidenceZipCode."<br/>";
                $no++;
            }
        }
?>