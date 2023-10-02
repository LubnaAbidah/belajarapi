<?php
//Contoller products
class products
{   
    public $method;
    public $response;
    public $database;

    function __construct($database, $params) {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->database = $database->connection;

    switch ($this->method) {
            case 'GET':
                if(!empty($params))
                {
                    $id=intval($params);
                    $this->response = $this->get_product($id);
                }
                else
                {
                    $this->response = $this->get_products();
                }
                break;

            case 'POST':
                if(!empty($params))
                {
                    $id=intval($params);
                    $this->response = $this->update_products($id);
                }
                else
                {
                    $this->response = $this->insert_products();
                } 
                break;
             
            case 'DELETE':
                $id=intval($params);
                $this->response = $this->delete_product($id);
                break;
            
            default:
                $this->response = $this->get();
                break;
        }
    }
    //get all data
    function get_products($id=0){
        $query="SELECT * FROM products";
        $data=array();
        $message = 'Success get all data products';
        $result=$this->database->query($query);
        while($row= $result->fetchAll())
        {
            $data[]=$row;
        }
        return [
            'data' => $data,
            'message' => $message
        ];
        
    }
    //get all data by id
    function get_product($id){
        
        $query="SELECT * FROM products WHERE id=".$id;
        $data=array();
        $message = 'Success get data products by id';
        $result=$this->database->query($query);
        while($row= $result->fetchAll())
        {
            $data[]=$row;
        }
        return [
            'data' => $data,
            'message' => $message
        ];
    }
    //insert data
    function insert_products(){
        
        $post = array('id' => '', 'category_id' => '', 'name' => '');
        $hitung = count(array_intersect_key($_POST, $post));
        if($hitung == count($post)){

              $query_insert = "INSERT INTO products SET id = '$_POST[id]', category_id = '$_POST[category_id]', name = '$_POST[name]'";
              $result=$this->database->query($query_insert);

              if($result)
              {
                $message = 'Products Added Successfully.';
                return [
                    'data' => null,
                    'message' => $message
                ];
              }
              else
              {
                $message = 'Products Added Failed.';
                return [
                    'data' => null,
                    'message' => $message
                ];
              }
            }else{
                $message = 'Parameter Do Not Match.';
                return [
                    'data' => null,
                    'message' => $message
                ];
        }
        //return $_POST;
        
    }
    //update data
    function update_products($id){
        
        
        $checkpost = array('id' => '', 'category_id' => '', 'name' => '');
        $hitung = count(array_intersect_key($_POST, $checkpost));
        if($hitung == count($checkpost)){
            $query_update =  "UPDATE products SET id = '$_POST[id]', category_id = '$_POST[category_id]', name = '$_POST[name]' WHERE id='$id'";
            $result=$this->database->query($query_update);
           if($result)
           {
              $message = 'Products Updated Successfully.';
              return [
                  'data' => null,
                  'message' => $message
              ];
           }
           else
           {
            $message = 'Products Updation Failed.';
            return [
                'data' => null,
                'message' => $message
            ];
           }
        }else{
            $message = 'Parameter Do Not Match.';
            return [
                'data' => null,
                'message' => $message
            ];
        }

    }
    //delete data
    function delete_product($id){
        $query="DELETE FROM products WHERE id=".$id;
        $result=$this->database->query($query);
        
        if($result)
        {
        $message = 'Success delete data by id = '.$id;
        return [
            'data' => null,
            'message' => $message
        ];
        }else {
        $message = 'Error delete data';
        return [
            'data' => null,
            'message' => $message
        ];
        return $message;   
        }   
    }
}