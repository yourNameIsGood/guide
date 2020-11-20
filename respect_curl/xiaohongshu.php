<?php
$util_path = "/Users/rl0408/work/code/onionGuide/util_php/";
include($util_path."common_function.php");
include($util_path."utilmail.php");
$runlog = "/tmp/xiaohongshu/log";
$filetable = "/tmp/xiaohongshu/table.html";

$page = 1;
$pageSize = 50;
$public_url = get_url($page, $pageSize);
$header = null;
$title = '';

// Step 1: visit API to get latest goods
$res = get_data();

// Step 2: filter data the way we want
$res = filtering($res);

// Step 3: optimization of data
$res = sort_two_demension_arr_by_index($res, $sortindex = "discount_rate", $sort='A');

// Step 4: form the whole table with data in it
$html = format_table($res);
if(!$res){ write_log($GLOBALS['runlog'], "Nothing new here"); exit; }
//die;

// Step 5: notify someone by sending it an email
$notify = new UtilMail('小红书: '.$title, $html);
$notify->send();

function get_filters(){
    $conditions = [
        ['tags'=>["99选9"] ],//只要出现99选9
        ['desc'=>[ '百优霜','红色蜜露', 'red seal', 'babyganics', 'mustela', 'baby ganics'] ], //只要出现这些商品
        //e.g. Meet multiple conds: desc(product name) && tags (99选4)
        //['desc'=>['saem'], 'tags'=>['99选4'] ],
    ];
    return $conditions;
}

function filtering($data){
    $conds = get_filters();
    $_title = [];
    $after_data = [];
    foreach($conds as $cond){
        foreach($data as $key=>$good){
            foreach($cond as $cond_name=>$cond_range_arr){
                if(isset($after_data[$key])){ continue; }
                $_g_attr = $good[$cond_name]; // g_attr is val 

                /* Deal with tags */
                if($cond_name == "tags"){
                    if(!$_g_attr) continue;
                    foreach($_g_attr as $_tag){
                        $_tag_name = $_tag['name'];
                        if(in_array($_tag_name, $cond[$cond_name])){
                            $after_data[$key] = $good;
                            $_title[] = $_tag_name;
                            continue;
                        }
                    }
                } 
                /* Deal with desc  */
                else{
                    $_g_attr = strtolower($_g_attr); // g_attr is val 
                    foreach($cond_range_arr as $_cond_val){
                        if (strpos($_g_attr, $_cond_val) !== false){
                            $after_data[$key] = $good;
                            $_title[] = $_cond_val;
                        }
                    }
                }
            }
        }
    }
    $GLOBALS['title'] = implode("," , $_title);
    return $after_data;
}

function get_data(){
    $url = $GLOBALS['public_url'];
    $jsondata = request_get($url);
    $data = json_decode($jsondata,true);
    $items = $data['data']['items'];

    if($items){
        foreach($items as $key=>$item){
            $desc = $item['desc'];
            $image = $item['image'];
            $discount_price = $item['discount_price']; // non-member price
            $member_price = $item['member_price']?$item['member_price']:$discount_price; // member price could be null from API response
            $price = $item['price']; // origin price
            $discount_rate = sprintf("%d", $member_price / $price * 100);
            $discount_val = sprintf("%d", $price - $member_price) ;

            $line = sprintf("%s\t%s\t%s\t%s".PHP_EOL, $desc, $image, $member_price, $discount_rate);
            //write_log($GLOBALS['runlog'], $line);

            $res[$key]['desc'] = $desc;
            $res[$key]['image'] = $image;
            $res[$key]['member_price'] = $member_price;
            $res[$key]['discount_price'] = $discount_price;
            $res[$key]['price'] = $price;
            $res[$key]['discount_rate'] = $discount_rate;
            $res[$key]['discount_val'] = $discount_val;
            $res[$key]['tags'] = isset($item['tags'])?$item['tags']:null;
        }
        $line = sprintf("Fetched %d items from xiaohongshu", count($res));
        write_log($GLOBALS['runlog'], $line);
        return $res;
    }else{
        $line = "error response: {$jsondata} ".PHP_EOL;
        write_log($GLOBALS['runlog'], $line);
        var_export($data); die;
    }
}

function format_table($data){
    $css = fetch_css(); 
    $header_col = fetch_header_col();
    $content = format_content($data);
    $table_html = sprintf("%s
                   <table id='t01'>
                   %s
                   %s
                   </table>",
                   $css, $header_col, $content);
    write_log($GLOBALS['filetable'], $table_html, $append=false);
    return $table_html;
}
function format_content($data){
    $lines = '';
    foreach($data as $key=>$val){
        $lines .= '<tr>';

        // image 
        $lines .= sprintf('<td><img src="%s" width="85" height="85" style="display:block" ></td>', $val['image']);

        // desc && tags
        $val['desc'] = wordwrap($val['desc'], 32, "<br>");
        $tags_arr = $val['tags'];
        if($tags_arr){
            $tagline = [];
            foreach($tags_arr as $_t){
                if( false !== strpos($_t['name'], "选")){ // only shows 99选X
                    $tagline[] = $_t['name'];
                }
            }
            $tagline = implode(",", $tagline);
        }
        $lines .= $tagline ? sprintf("<td>%s</td><br>", $val['desc']."<br>".$tagline) : sprintf("<td>%s</td>"."<br>", $val['desc']);

        // all price 
        $mp = "现价:￥{$val['member_price']}";
        $dv = "力度:-￥{$val['discount_val']}";
        $dr = 100 - $val['discount_rate'];
        $p = "原价:￥{$val['price']}";
        $lines .= "<td>";
        $lines .= sprintf("%s"."<br>", $mp);
        $lines .= sprintf("%s (%s%%)"."<br>", $dv, $dr);
        $lines .= sprintf("%s"."<br>", $p);
        $lines .= "</td></tr>";
    }
    return $lines;
}

// definition of column name in the table
function fetch_header_col(){
    $cols = ['image', 'desc', 'member_price'];
    $lines = '<tr>';
    foreach($cols as $col){
        $_line = '';
        if($col == "image"){
            $col = " "; 
            $_line = sprintf("<th width='85px'>%s</th>", $col);
        }elseif($col == "desc"){
            $col = "商品";
            $_line = sprintf("<th width='34%%'>%s</th>", $col);
        }elseif($col == "member_price"){
            $col = "价";
        }
        $lines .= $_line ? $_line : sprintf("<th>%s</th>", $col);
    }
    $lines .= "</tr>";
    return $lines; 
}

function fetch_css(){
    return  "<meta charset='utf-8' />
             <style type='text/css'>
                table {
                  width:100%;
                }
                table, th, td {
                  border: 3px black;
                  border-bottom: 1px solid yellow;
                  border-collapse: collapse;
                }
                th, td {
                  padding: 15px;
                  text-align: left;
                }
                table#t01 tr:nth-child(even) {
                  background-color: #eee;
                }
                table#t01 tr:nth-child(odd) {
                 background-color: #fff;
                }
                table#t01 th {
                  background-color: green;
                  color: white;
                }
              </style>";
}

function get_url($page=1, $pageSize=1){
    $url = "https://www.xiaohongshu.com/api/store/ps/products/v2?deviceId=7927A3E-A73E-551A-322A-2F08241EAED1&device_fingerprint=2019013122292289e06216a573e573ad4592b373af99f501d00f7230659c2&device_fingerprint1=2019013122292335e06216a573ebf4ad4592b445af99f501d00f7230679y1&ios_app_ssl=1&keyword=%s&lang=zh&page=%s&platform=iOS&search_id=2AB0E5B200534EC1BFB9AB88BF6C98D9&sid=session.1548949730410565295&sign=dc0c5563e76de1ff999acd1d781edfe3&size=%s&source=store_feed&t=154925411";
    $keyword = "%E7%A6%8F%E5%88%A9%E7%A4%BE"; // 福利社
    $url = sprintf($url, $keyword, $page, $pageSize);
    write_log($GLOBALS['runlog'], $url);
    return $url;
}
