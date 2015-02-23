<?php

class DB
{

    private $connection;

    //opens the connections based on the info in the config file
    public function __construct()
    {
        //gets config info from config.php
        require("config.php");
        //PDO connection
        $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function __destruct()
    {
        $this->connection = null;
    }

    //this will contruct the querys based on the _POST values given
    function insert_campaign($campaign,$country_code,$vert)
    {
        $stmt = $this->connection->prepare("INSERT INTO campaigns(id,name,country_code,vertical,date_changed) VALUES (:id,:campaign,:country_code,:vert,:datetime)");

        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindParam(':campaign', $campaign);
        $stmt->bindParam(':country_code', $country_code);
        $stmt->bindParam(':vert', $vert);
        $stmt->bindValue(':datetime', null, PDO::PARAM_INT);
        $stmt->execute();

        return $this->connection->lastInsertId();

    }
    function update_offer($data)
    {
        $offer_id = $data['id'];
        unset($data['id']);
        $offername = $data['offername'];
        unset($data['offername']);
        $offer_link = $data['offer_link'];
        unset($data['offer_link']);

        $network_id = $this->get_else_create_network($data['network_name']);
        unset($data['network_name']);

        $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $stmt = $this->connection->prepare("UPDATE offers SET name=:name, network_id=:network_id, offer_link=:offer_link WHERE id=:id");
        $stmt->bindParam(':name', $offername);
        $stmt->bindParam(':offer_link',$offer_link);
        $stmt->bindParam(':id', $offer_id);
        $stmt->bindParam(':network_id', $network_id);
        $stmt->execute();

        //need to handle editing of custom variables
        foreach($data as $key => $value)
        {
            $this->update_custom_else_create($key,$value, $offer_id);
        }
    }

    function create_offer($data, $campaign_id,$images)
    {
        $offername = $data['offername'];
        unset($data['offername']);

        $offer_link = $data['affurl'];
        unset($data['affurl']);
        $network_id = $this->get_else_create_network($data['network']);
        unset($data['network']);


        $offerid = $this->insert_offer($offername, $network_id);


        if (isset($campaign_id)) {
            $this->insert_caof($campaign_id,$offerid);
            $weight = $data['weight'];
            unset($data['weight']);
            $this->insert_rotation_weight($campaign_id, $offerid, $weight);
        }
        //custom variable portion (customs table looks like id|field|value|offer_id|date_changed)
        //inserts all remaining variables in 'post' into customs table
        foreach ($data as $key => $value) {
            $stmt = $this->connection->prepare("INSERT INTO customs(id,field,value,offer_id,date_changed) VALUES (:id,:field,:value,:offer_id,:date_changed)");
            $stmt->bindValue(':id', null, PDO::PARAM_INT);
            $stmt->bindParam(':field', $key);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':offer_id', $offerid, PDO::PARAM_INT);
            $stmt->bindValue(':date_changed', null, PDO::PARAM_INT);
            $stmt->execute();
        }
        foreach($images as $name=>$hash)
        {
            $this->insert_image($name,$hash,$offerid);
        }
        return $offerid;
    }

    function insert_caof($campaignid, $offerid)
    {
        $stmt = $this->connection->prepare('INSERT INTO caof(campaign_id,offer_id) VALUES (:campaignid,:offerid)');
        $stmt->bindParam(':campaignid', $campaignid);
        $stmt->bindParam(':offerid', $offerid);
        $stmt->execute();
    }

    //create offer function
    function insert_offer($offername, $network_id)
    {
        $stmt = $this->connection->prepare("INSERT INTO offers(id,name,network_id,date_changed) VALUES (:id,:offername,:network_id,:date_changed)");
        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindParam(':offername', $offername);
        $stmt->bindParam(':network_id', $network_id, PDO::PARAM_INT);
        $stmt->bindValue(':date_changed', null, PDO::PARAM_INT);
        $stmt->execute();
        $offerid = $this->connection->lastInsertId();

        return $offerid;
    }
    function get_all_campaigns(){
        $stmt = $this->connection->prepare("SELECT * FROM campaigns");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function get_all_enabled_campaigns()
    {
        $stmt = $this->connection->prepare("SELECT * FROM campaigns WHERE disabled = 'FALSE'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function campaign_everything_admin($id){
        //this object gets complicated, many nested arrays
        $campaign = $this->get_campaign($id);

        $stmt = $this->connection->prepare("SELECT * FROM caof WHERE campaign_id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        //looks up all associated offers
        $offers = array();
        $set_array = array();
        $sets = $this->get_all_sets($id);
        foreach($sets as $set)
        {
            $offer = $this->get_offer($set['offer_id']);

            $weight = $this->get_rotation_weight($id,$set['offer_id']);//gets the rotation weight for this campaign offer;
            $set_info = $this->get_set($id,$set['offer_id']);
            $offer['set_part'] = $set_info['part_number'];
            $offer['set'] = $set_info['set_id'];
            $offer['weight'] = $weight['weight'];
            if(!isset($set_array[$set['set_id']]))
            {
                $set_array[$set['set_id']] = array();
            }
            array_push($set_array[$set['set_id']],$offer);
        }
        foreach($this->caof_lookup($id) as $offer_id)
        {
            $offer= $this->get_offer($offer_id);
            $weight = $this->get_rotation_weight($id,$offer['id']);//gets the rotation weight for this campaign offer;
            $offer['weight'] = $weight['weight'];
            $set = array($offer);
            array_push($set_array, $set);

        }
        $result = array('campaign' => $campaign, 'sets' => $set_array);

        return $result;
    }
    function campaign_everything($id) //gets everything associated with the campaign
    {
        //this object gets complicated, many nested arrays
        $campaign = $this->get_campaign($id);

        $stmt = $this->connection->prepare("SELECT * FROM caof WHERE campaign_id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        //looks up all associated offers
        $offers = array();
        $set_array = array();
        $sets = $this->get_all_sets($id);
        foreach($sets as $set)
        {
            $offer = $this->get_offer($set['offer_id']);

            $weight = $this->get_rotation_weight($id,$set['offer_id']);//gets the rotation weight for this campaign offer;
            $set_info = $this->get_set($id,$set['offer_id']);
            $offer['set_part'] = $set_info['part_number'];
            $offer['set'] = $set_info['set_id'];
            $offer['weight'] = $weight['weight'];
            if(!isset($set_array[$set['set_id']]))
            {
                $set_array[$set['set_id']] = array();
            }
            array_push($set_array[$set['set_id']],$offer);
        }
        foreach($this->caof_lookup($id) as $offer_id)
        {
            $offer= $this->get_offer($offer_id);
            if($offer['disabled']!='1')
            {
                $weight = $this->get_rotation_weight($id,$offer['id']);//gets the rotation weight for this campaign offer;
                $offer['weight'] = $weight['weight'];
                $set = array($offer);
                array_push($set_array, $set);
            }
        }
        $result = array('campaign' => $campaign, 'sets' => $set_array);

        return $result;
    }
    function caof_lookup($campaign_id){
        $stmt = $this->connection->prepare("SELECT * FROM caof WHERE campaign_id=:id");
        $stmt->bindParam(':id',$campaign_id);
        $stmt->execute();
        $offers = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($offers,$row['offer_id']);
        }
        return $offers;
    }
    function toggle_campaign($campaign_id){
        $stmt = $this->connection->prepare("UPDATE campaigns SET disabled = IF(disabled=0,1,0) WHERE id=:id");
        $stmt->bindParam(':id',$campaign_id);
        $stmt->execute();
    }
    function toggle_offer($offer_id){
        $stmt = $this->connection->prepare("UPDATE offers SET disabled = IF(disabled=0,1,0) WHERE id=:id");
        $stmt->bindParam(':id',$offer_id);
        $stmt->execute();
    }

    //returns a single offer
    function get_offer($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM offers WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $network_id = $row['network_id'];
        unset($row['network_id']); //looks up the network ID
        $networkinfo = $this->get_network_name($network_id);

        $row = $this->get_customs($row['id'], $row); //adds the custom variables to the array
        $row = $this->get_images($row['id'],$row);
        $row['network'] = $networkinfo; //adds network info to the array
        return $row;
    }

    //adds the custom variables to the offer array
    private function get_customs($offer_id, $offer_array)
    {
        $stmt = $this->connection->prepare("SELECT * FROM customs WHERE offer_id = :offer_id");
        $stmt->bindParam('offer_id', $offer_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $offer_array[$row['field']] = $row['value'];
        }
        return $offer_array;
    }
    private function update_custom_else_create($field,$value,$offer_id)
    {
        //check if the row already exists and just needs to be updated
        $stmt = $this->connection->prepare("SELECT * FROM customs WHERE offer_id=:offer_id AND field=:field");
        $stmt->bindParam(':field',$field);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->execute();
        $row = $stmt->fetch();

        if(count($row)>1)
        {
            $stmt = $this->connection->prepare("UPDATE customs SET value=:value WHERE offer_id=:offer_id AND field=:field");
            $stmt->bindParam(':value',$value);
            $stmt->bindParam(':field',$field);
            $stmt->bindParam(':offer_id',$offer_id);
            $stmt->execute();
            return $this->connection->lastInsertId();
        }
        else
        {

            $this->insert_custom($field,$value,$offer_id);
        }
    }
    function update_campaign($data)
    {
        $stmt = $this->connection->prepare("UPDATE campaigns SET name=:name, country_code=:country_code,vertical=:vertical WHERE id=:id");
        $stmt->bindParam(':country_code', $data['country_code']);
        $stmt->bindParam(':vertical', $data['vertical']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':id', $data['id']);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    function get_campaign($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM campaigns WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
        return $campaign;
    }
    function delete_campaign($id){
        $stmt = $this->connection->prepare("DELETE FROM campaigns WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM caof WHERE campaign_id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM rotation_weights WHERE campaign_id=:id");
        $stmt->bindParam('id',$id);
        $stmt->execute();
    }

    function insert_custom($field,$value,$offer_id)
    {
        $stmt = $this->connection->prepare("INSERT INTO customs(id,field,value,offer_id,date_changed) VALUES (:id,:field,:value,:offer_id,:date_changed)");
        $stmt->bindParam(':field', $field);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindValue(':date_changed', null, PDO::PARAM_INT);
        $stmt->execute();
    }
    private function get_network_id($network_name)
    {
        $stmt = $this->connection->prepare("SELECT * FROM networks WHERE name = :name");
        $stmt->bindParam(':name', $network_name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }
    function delete_network($id)
    {
        $stmt=$this->connection->prepare("DELETE FROM networks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    private function get_network_name($network_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM networks WHERE id = :id");
        $stmt->bindParam(':id', $network_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['name'];
    }
    function get_all_networks()
    {
        $stmt = $this->connection->prepare("SELECT * FROM networks");
        $stmt->execute();
        $networks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $networks;
    }
    function insert_network($network_name)
    {
        $stmt = $this->connection->prepare("INSERT INTO networks(id,name) VALUES (:id,:name)");
        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindParam(':name', $network_name);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    //inserts network and returns the network ID
    function get_else_create_network($network_name)
    {

        $network_id = $this->get_network_id($network_name);
        if($network_id!=null)
        {
            return $network_id;
        }
        else {
            return $this->insert_network($network_name);
        }
    }

    function get_all_enabled_offers()
    {
        $stmt = $this->connection->prepare("SELECT * FROM offers WHERE disabled = 0");
        $stmt->execute();
        $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($offers as &$item)
        {

            $item['network'] = $this->get_network_name($item['network_id']);
            $item = $this->get_customs($item['id'],$item);
            $item = $this->get_images($item['id'],$item);
            unset($item['network_id']);
        }
        return $offers;
    }
    function delete_offer($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM offers WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM customs WHERE offer_id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $stmt = $this->connection->prepare("DELETE FROM caof WHERE offer_id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    }
    //queries for rotation weights
    function get_rotation_weight($campaign_id, $offer_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM rotation_weights WHERE campaign_id=:campaign_id AND offer_id=:offer_id");
        $stmt->bindParam(':campaign_id', $campaign_id);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function update_rotation_weight($campaign_id, $offer_id, $weight)
    {
        $stmt = $this->connection->prepare("UPDATE rotation_weights SET weight=:weight WHERE campaign_id=:campaign_id AND offer_id=:offer_id");
        $stmt->bindParam(':weight',$weight);
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->execute();
    }
    function update_set_weight($campaign_id, $set_id, $weight,$offer_id){
        $stmt = $this->connection->prepare("SELECT * FROM sets WHERE campaign_id=:campaign_id AND set_id=:set_id");
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->bindParam(':set_id',$set_id);
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt = $this->connection->prepare("SELECT * FROM rotation_weights WHERE offer_id=:offer_id AND campaign_id=:campaign_id");
            $stmt->bindParam(':campaign_id',$campaign_id);
            $stmt->bindParam(':offer_id',$row['offer_id']);
            $stmt->execute();

            if(count($stmt->fetch(PDO::FETCH_ASSOC))>1){ //update if exists, else insert
                echo 'updating';
                $this->update_rotation_weight($row['campaign_id'],$row['offer_id'],$weight);
            }
            else{
                $this->insert_rotation_weight($row['campaign_id'],$row['offer_id'],$weight);
            }
        }
        if($set_id==0)
        {
            $stmt = $this->connection->prepare("SELECT * FROM rotation_weights WHERE offer_id=:offer_id AND campaign_id=:campaign_id");
            $stmt->bindParam(':campaign_id',$campaign_id);
            $stmt->bindParam(':offer_id',$offer_id);
            $stmt->execute();
            if(count($stmt->fetch(PDO::FETCH_ASSOC))>1){ //update if exists, else insert
                echo 'update';
                $this->update_rotation_weight($campaign_id,$offer_id,$weight);
            }
            else{
                echo 'insert';
                $this->insert_rotation_weight($campaign_id,$offer_id,$weight);
            }
        }

    }
    function insert_rotation_weight($campaign_id,$offer_id,$weight)
    {
        $stmt = $this->connection->prepare("INSERT INTO rotation_weights(campaign_id,offer_id,weight) VALUES (:campaign_id,:offer_id,:weight)");
        $stmt->bindParam(':campaign_id', $campaign_id);
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindParam(':weight',$weight);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    function insert_image($field,$hash,$offer_id)
    {
        $stmt = $this->connection->prepare("INSERT INTO images(id,field,hash,offer_id,date_changed) VALUES (:id,:field,:hash,:offer_id,:date_changed)");
        $stmt->bindParam(':field', $field);
        $stmt->bindParam(':hash', $hash);
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindValue(':date_changed', null, PDO::PARAM_INT);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    private function get_images($offer_id,$offer_array)
    {
        $stmt = $this->connection->prepare("SELECT * FROM images WHERE offer_id = :id");
        $stmt->bindParam(':id', $offer_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $offer_array[$row['field']] = $row['hash'];
        }
        return $offer_array;
    }
    function update_image($offer_id,$field, $hash)
    {
        $stmt = $this->connection->prepare("UPDATE images SET hash=:hash, date_changed=:date_changed WHERE offer_id=:offer_id AND field=:field");
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->bindParam(':field',$field);
        $stmt->bindParam(':hash',$hash);
        $stmt->bindValue(':date_changed',null, PDO::PARAM_INT);
        $stmt->execute();
    }
    function update_image_else_create($offer_id,$field, $hash)
    {
        //check if the row already exists and just needs to be updated
        $stmt = $this->connection->prepare("SELECT * FROM images WHERE offer_id=:offer_id AND field=:field");
        $stmt->bindParam(':field',$field);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->execute();
        $row = $stmt->fetch();

        if(count($row)>1)
        {
            $this->update_image($offer_id,$field,$hash);
        }
        else
        {

            $this->insert_image($field,$hash,$offer_id);
        }
    }
    function insert_set($campaign_id,$offer_id,$set,$part_number)
    {
        $stmt = $this->connection->prepare("INSERT INTO sets (campaign_id,offer_id,set_id,part_number) VALUES (:campaign_id,:offer_id,:set,:part_number)");
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->bindParam(':set',$set);
        $stmt->bindParam(':part_number',$part_number);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    function get_set($campaign_id,$offer_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM sets WHERE campaign_id =:campaign_id AND offer_id = :offer_id");
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function get_all_sets($campaign_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM sets WHERE campaign_id =:campaign_id ");
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function delete_set($campaign_id,$offer_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM sets WHERE offer_id = :offer_id AND campaign_id=:campaign_id");
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
    }
    function delete_custom($offer_id,$field)
    {
        $stmt = $this->connection->prepare("DELETE FROM customs WHERE offer_id=:offer_id AND field=:field");
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindParam(':field',$field);
        $stmt->execute();
    }
    function delete_image($offer_id,$field)
    {
        $stmt = $this->connection->prepare("DELETE FROM images WHERE offer_id=:offer_id AND field=:field");
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindParam(':field',$field);
        $stmt->execute();
    }
    function get_highest_set($campaign_id){
        $stmt = $this->connection->prepare("SELECT * FROM sets WHERE campaign_id=:campaign_id");
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
        $highest = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['set_id']>$highest){
                $highest=$row['set_id'];
            }
        }
        return $highest;
    }
    function update_set($campaign_id,$offer_id,$part_number)
    {
        $stmt = $this->connection->prepare("UPDATE sets SET part_number = :part_number WHERE campaign_id=:campaign_id AND offer_id=:offer_id");
        $stmt->bindParam(':part_number',$part_number);
        $stmt->bindParam(':offer_id',$offer_id);
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
    }
    function delete_caof($campaign_id,$offer_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM caof WHERE offer_id=:offer_id AND campaign_id=:campaign_id");
        $stmt->bindParam(':offer_id', $offer_id);
        $stmt->bindParam(':campaign_id',$campaign_id);
        $stmt->execute();
    }
    function get_user_with_username($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function get_user_with_id($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function create_user($password,$email,$salt,$level)
    {
        $stmt = $this->connection->prepare("INSERT INTO users (id,password,salt,email,user_level) VALUES (:id,:password,:salt,:email,:user_level)");
        $stmt->bindValue(':id', null, PDO::PARAM_INT);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':salt',$salt);
        $stmt->bindParam(':user_level',$level);
        $stmt->execute();
    }
    function get_all_users(){
        $stmt = $this->connection->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function update_user($id,$password,$salt){
        $stmt = $this->connection->prepare("UPDATE users SET password=:password,salt=:salt WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':salt',$salt);
        $stmt->execute();
    }
    function update_user_level($id,$level){
        $stmt = $this->connection->prepare("UPDATE users SET user_level=:level WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':level',$level);
        $stmt->execute();

    }
    function insert_template($name){
        $stmt = $this->connection->prepare("INSERT INTO templates (id,name) VALUES (:id,:name)");
        $stmt->bindValue(':id',null,PDO::PARAM_INT);
        $stmt->bindParam(':name',$name);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    function insert_template_field($template_id,$field,$type){
        $stmt = $this->connection->prepare("INSERT INTO template_fields (template_id,field,type) VALUES (:template_id,:field,:type)");
        $stmt->bindParam(':template_id',$template_id);
        $stmt->bindParam(':field',$field);
        $stmt->bindParam(':type',$type);
        $stmt->execute();
    }
    function get_all_templates()
    {
        $templates = array();
        $stmt = $this->connection->prepare("SELECT * FROM templates");
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $field_array = array();
            foreach($this->get_all_template_fields($row['id']) as $item)
            {
                array_push($field_array, $item);
            }
            $templates[$row['name']] = $field_array;
        }
        return $templates;
    }
    function get_all_template_fields($template_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM template_fields WHERE template_id=:id");
        $stmt->bindParam(':id',$template_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function delete_campaign_associated($id){
        $campaign_all = $this->campaign_everything($id);
        foreach($campaign_all['sets'] as $set){
            echo 'got here';
            foreach($set as $offer){
                echo 'Deleting Item ';
                print_r($offer);
                echo '<br/>';
                $this->delete_offer($offer['id']);
            }
        }
        $stmt = $this->connection->prepare("DELETE FROM sets WHERE campaign_id=:campaign_id");
        $stmt->bindParam(':campaign_id',$id);
        $stmt->execute();
    }
    function get_template($id){
        $stmt = $this->connection->prepare("SELECT * FROM templates WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $row= $stmt->fetch(PDO::FETCH_ASSOC);
        $field_array = array();
        foreach($this->get_all_template_fields($id) as $item)
        {
           $field_array[$item['field']]=$item['type'];
        }
        $field_array['template_name']=$row['name'];
        return $field_array;
    }
    function delete_template_fields($id){
        $stmt = $this->connection->prepare("DELETE FROM template_fields WHERE template_id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    function get_campaign_fields($id){
        $stmt = $this->connection->prepare("SELECT * FROM campaign_fields WHERE campaign_id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result[$row['field']] = $row['type'];
        }
        return $result;
    }
    function insert_campaign_field($campaign_id,$field,$type){
        $stmt = $this->connection->prepare("SELECT * FROM campaign_fields WHERE campaign_id=:id AND field=:field AND type=:type");
        $stmt->bindParam(':id',$campaign_id);
        $stmt->bindParam(':field',$field);
        $stmt->bindParam(':type',$type);
        $stmt->execute();
        if(count($stmt->fetchAll())<1){ //checks if the field exists already, excess queries because lazy today
            print_r($field);
            $stmt = $this->connection->prepare("INSERT INTO campaign_fields (campaign_id, field,type) VALUES (:id,:field,:type)");
            $stmt->bindParam(':id',$campaign_id);
            $stmt->bindParam(':field',$field);
            $stmt->bindParam(':type',$type);
            $stmt->execute();
        }
    }

}