<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Solr {

    private function natksort($array) {
        // Like ksort but uses natural sort instead
        $keys = array_keys($array);
        natsort($keys);
        $new_array = array();
        foreach ($keys as $k)
            $new_array[$k] = $array[$k];

        return $new_array;
    }

    private function getCoreQuery($coreList) {
        $query_str = "";
        if (count($coreList) > 0) {
            $i = 0;
            foreach ($coreList as $core_key => $core) {
                if (count($core) > 0) {
                    if ($i > 0) {
                        $query_str.=" AND ";
                    }
                    $query_str.="(";
                    for ($j = 0; $j < count($core); $j++) {
                        if ($j > 0) {
                            $query_str.=" or ";
                        }
                        $query_str.="{$core_key}:";
                        if("keyword"==$core_key){
                            $query_str.= $this->createKeywordVal($core[$j]);
                        }
                        elseif ("price" == $core_key) {
                            $query_str.='' . stripslashes($core[$j]) . '';
                        } else {
                            $query_str.='"'.$this->escape_for_solr_query($core[$j]).'"';
                        }
                    }
                    $query_str.=')';
                    $i++;
                }
            }
        }
        return $query_str;
    }

    private function createKeywordVal($val){
        //$val=  str_replace(" ", '+', $val);
        $val=  str_replace(" ", ' AND ', $val);
	return "*".$this->escape_for_solr_query($val)."*";
    }

    private function makeSolrCall($headers) {
        //$url = Yii::app()->params->solrUrl . "/wear/select?wt=json&group=true&group.field=model_id&group.ngroups=true&group.facet=true&facet.mincount=1&sort=priority+desc&facet.missing=false&";
        $url = Yii::app()->params->solrUrl . "/wear/select?wt=json&group=true&group.field=model_id&group.ngroups=true&group.facet=true&facet.mincount=1&sort=randno+asc&facet.missing=false&";
        //$url = SOLRBASEURL . "/cloggs/select?";
        $afterurl = ""; //&group=true&group.field=item_group_id&group.ngroups=true&wt=json&indent=true&rows=100&group.facet=true&facet.sort=index&facet.mincount=1";
        $query = "q=*:*";
        $temp_query = "";
        if (isset($_GET['limit']))
            $url.="rows=".$_GET['limit']."&";
        else
            $url.="rows=100&";
        if (isset($_GET['offset']))
            $url.="start=".$_GET['offset']."&";
        else
            $url.="start=0&";
        try {
            if ($headers!="{}") {
                $query = $headers;
                $query = $this->validate_json($query);
                $query = $this->getCoreQuery($query);
                $query = "q=" . rawurlencode($query);
            } 
            //$query = http_build_query(array("q"=>$query),null,null,PHP_QUERY_RFC3986);
            Yii::log("For display online ".$url . rawurldecode($query) . $afterurl);
            $url = $url . $query . $afterurl;
            Yii::log("Actual ".$url);
            // create curl resource
            $ch = curl_init();
            // set url
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic cmVzdEBmbGlra2FibGUuY29tOmFwcGRldg==',
            ));

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // $output contains the output string
            $output = curl_exec($ch);
            // close curl resource to free up system resources
            curl_close($ch);
            return $output;
        } catch (Exception $e) {
            return "";
        }
    }
    
    public function sortFacets($values){
        $temp = array();
        for ($i = 0; $i < count($values); $i+=2) {
            $temp[$values[$i]] = $values[$i + 1];
        }
        $temp = $this->natksort($temp);
        $newtemp = array();
        foreach ($temp as $k => $v) {
            $newtemp[] = $k;
            $newtemp[] = $v;
        }
        return $newtemp;
    }
    public function mainflow($headers) {
        $output = $this->makeSolrCall($headers);
        $data = "";
        if ($output != "")
            $data = CJSON::decode($output);
        else {
            return null;
        }
        //$data['facet_counts']['facet_fields']['brand']=$this->sortFacets($data['facet_counts']['facet_fields']['brand']);
        //$data['facet_counts']['facet_fields']['gender']=$this->sortFacets($data['facet_counts']['facet_fields']['gender']);
        //$data['facet_counts']['facet_fields']['sport']=$this->sortFacets($data['facet_counts']['facet_fields']['sport']);

        return $data;
    }

    private function escape_for_solr_query($specific) {
        /*
          This function is used to escape special characters when a solr query is made
          it escapes special charachters in specific name

         */
//        $replace_characters = array("\'", "\ ", "\+", "\-", "\!", "\(", "\)", "\{", "\}", "\[", "\]", "\^", '\"', "\~", "\*", "\?", "\:");
//        $special_characters = array("'", " ", "+", "-", "!", "(", ")", "{", "}", "[", "]", "^", '"', "~", "*", "?", ":");
        
        $replace_characters = array("\'","\+", "\-", "\!", "\(", "\)", "\{", "\}", "\[", "\]", "\^", '\"', "\~", "\*", "\?", "\:");
        $special_characters = array("'","+", "-", "!", "(", ")", "{", "}", "[", "]", "^", '"', "~", "*", "?", ":");
        
        $specific = str_replace('\\', "\\\\", $specific);
        $specific = str_replace($special_characters, $replace_characters, $specific);
        return $specific;
    }
    
    
    private function validate_json($json) {
        
        $json = CJSON::decode($json);
        
        if ($json == null || count($json) == 0) {
            throw new Exception("Syntax error, malformed JSON.");
        }
        
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid
                break;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // only PHP 5.3+
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }
        if ($error != "") {
            throw new Exception($error);
        }
        return $json;
    }

}
?>


