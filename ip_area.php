<?php
 $ip = '42.121.106.187';
            $ch = curl_init("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip) ; 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 
            $output = curl_exec($ch) ; 
            $area_info = json_decode($output,true);
            $area = array();
            if(!$area_info['code']){
                if(($area_info['data']['city'] || $area_info['data']['region'] || $area_info['data']['country']) && $area_info['data']['country'] != '未分配或者内网IP'){
                    if(isset($area_info['data']['country']) && !empty($area_info['data']['country'])){
                        $area[] = $area_info['data']['country'];
                    }
                    if(isset($area_info['data']['region']) && !empty($area_info['data']['region'])){
                        $area[] = $area_info['data']['region'];
                    }
                    if(isset($area_info['data']['city']) && !empty($area_info['data']['city'])){
                        $area[] = $area_info['data']['city'];
                    }
                }
            }
var_dump($area);
