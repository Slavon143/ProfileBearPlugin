<?php

namespace Inc\Classes;

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';


class MyFunctions
{

    public function make($post){
        if (!empty($post['delete']) && isset($_POST['options'])) {
            $this->delete($_POST);
        }
        if (!empty($post['edit_secondary']) && isset($_POST['options'])) {
            $this->update($post, '0');
        }
        if (!empty($post['edit']) && isset($_POST['options'])) {
            $this->update($post, '1');
        }
    }

    public function getCount(){
        global $wpdb;
        $sql  = "SELECT count(id) AS id FROM `optimize_img`";
        $result = $wpdb->get_results($sql);
        if ($result){
            return $result[0]->id;
        }
    }

    public function getAllImg($start, $limit, $name){
        global $wpdb;
        if (!empty($name)){
            $sql  = "SELECT * FROM `optimize_img` WHERE `img` LIKE '%$name%' LIMIT $limit";
        }else{
            $sql  = "SELECT * FROM `optimize_img` LIMIT $start, $limit";
        }
        $result = $wpdb->get_results($sql,ARRAY_A);

        return $result;
    }

    public function update($data,$arg){
        global $wpdb;
        $queryStr = '';
        if (empty($data)){
            return;
        }
        foreach ($data['options'] as $id){
            $queryStr .= "'$id',";
        }
        $queryStr = substr($queryStr, 0, -1);
        $sql = "UPDATE `optimize_img` SET `done` = $arg WHERE `id` IN ($queryStr);";
        $wpdb->query($sql);
    }

    public function delete($arg){
        if (empty($arg['options'])){
            return;
        }
        global $wpdb;
        $queryStr = '';
        if (!empty($arg['options'])){
            for ($i = 0; $i <= count($arg['options']); $i++){
                if (!empty($arg['options'][$i])){
                    $img = trim($arg['options'][$i]);
                    $queryStr .= "`id` = '$img' OR";
                }
            }
        }
        if (!empty($queryStr)){
            $queryStr = substr($queryStr, 0, -2);
            $query = "DELETE FROM `optimize_img` WHERE $queryStr;";
            $wpdb->query($query);
        }
    }

    public function buildLinkImg($img){

        $cat = str_replace("\\",'/',wp_upload_dir()['basedir']);
        $img = str_replace($cat,'',$img);
        $base_dir = wp_upload_dir()['baseurl'];
        $img_url_dir = $base_dir.$img;

        return $img_url_dir;
    }
}