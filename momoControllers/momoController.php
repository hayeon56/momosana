<?php

class Momo{

   private $shop_id;
   private $open_key;
   private $manager_key;

  public function __construct(){
    $this->shop_id = "eat584.ev";
    $this->open_key = "56967090a3ccdd49e066c5b6c92d491edb7df42c";
    $this->manager_key = "9f091d99c504e977f780f777910c1ef5b9aa748f";
  }

  //GET
  public function get($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//문자열로 바꾸기
    $result = curl_exec($curl);//결과 result 변수에 저장
    curl_errno($curl);
    curl_close($curl);
    $data_json =  json_decode($result, true);//배열로 바꾸기
    print_r($data_json);
  }

  //POST
  public function post($url,$data){

        if(gettype($data) == 'array'){
            $data = json_encode($data); // array -> json
        }

        //$data = json_encode($data); // array -> json
    $curl = curl_init(); // RESET
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: json'));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);     // 원격서버의 인증서가 유효한지 검사 안함
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result  = curl_exec($curl);
    curl_errno($curl);
    curl_close($curl);
    $return_data =  json_decode($result, true);//배열로 바꾸기

    return $return_data;
  }

  //PUT
  public function put($url,$item_data){

    $data_json = json_encode($item_data,JSON_UNESCAPED_UNICODE);
    echo "<br>";
    echo print_r($data_json);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $this->shop_id.":".$this->manager_key);
    $result  = curl_exec($curl);
    curl_errno($curl);
    curl_close($curl);

    // print_r($data_json);

  }

  //商品基本情報
  public function itemInformation(){
    $item_code = $_POST['item_code'];
    $url = "https://management.api.shopserve.jp/v2/items/$item_code/basic";
    $this->get($url);

  }

  //商品登録
  public function itemRegistration(){
    //商品登録(code,name)
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];

    echo "<br>".$item_code."<br>";
      echo "<br>".$item_name."<br>";

    //예외처리


    $item_data = array('item_code'=>$item_code,
                       'item_name'=>$item_name);

    $url = "https://management.api.shopserve.jp/v2/items";

    $this->put($url,$item_data);

    //商品登録(ect.)
    $consumption_tax_setting = $_POST['consumption_tax_setting'];
    $item_price = $_POST['item_price'];
    $regular_price_type = $_POST['regular_price_type'];
    $regular_price_name = $_POST['regular_price_name'];
    $regular_price = $_POST['regular_price'];
    $item_unit = $_POST['item_unit'];
    $memo = $_POST['memo'];

      echo "<br>".$consumption_tax_setting."<br>";
        echo "<br>".$item_price."<br>";
          echo "<br>".$regular_price_type."<br>";
            echo "<br>".$regular_price_name."<br>";
              echo "<br>".$regular_price."<br>";
                echo "<br>".$item_unit."<br>";
                  echo "<br>".$item_code."<br>";
                    echo "<br>".$memo."<br>";




    $item_ect_data = array(
                            'item_name'=>$item_name,
                            'consumption_tax_setting'=>$consumption_tax_setting,
                            'item_price'=>(int)$item_price,
                            'regular_price_type'=>$regular_price_type,
                            'regular_price_name'=>$regular_price_name,
                            'item_unit'=>$item_unit,
                            'memo'=>$memo);
     $url = "https://management.api.shopserve.jp/v2/items/$item_code/basic";
     $this->put($url,$item_ect_data);
     //商品登録(カテゴリ)
     $item_category = $_POST['item_category'];

     $item_category_words = array();
     $item_category_words = explode('>',$item_category);

     echo  print_r($item_category_words);

     $num = (int)sizeof($item_category_words);
     echo "<br>num".$num;

     for($i = 0; $i < count($item_category_words); $i++){
       $array["category"][$i] = $item_category_words[$i];
     }
     $array = array(
       "categories" => [$array]
     );
     $url = "https://management.api.shopserve.jp/v2/items/$item_code/categories";
     $this->put($url,$array);

  }

}
$Momo = new Momo;
$Momo->itemInformation();
$Momo->itemRegistration();





?>
