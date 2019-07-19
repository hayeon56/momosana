<?php
  include("../momoControllers/momoCategoryController.php");
  $category = $Momo->category();
?>

<script type="text/javascript">
    function fnRadioName(){
        var radioId = $('input[name="consumption_tax_setting"]:checked').val();
        var rasioNm = $("label[for='"+radioId+"']").text(); // 라벨값을 불러온다.
        alert(rasioNm);
    }

</script>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <center>
    <div>
    <h1>商品登録</h1>
    <form name="momoform" action="/momoControllers/momoController.php/itemRegistration" method="post">
    <strong>商品番号</strong><br><br><input type="text" name="item_code" placeholder="商品番号" >
    <p>※半角英数字「-（ハイフン）」、「_（アンダーバー）」64文字以内</p>
    <hr>
    <strong>商品名</strong><br><br><input type="text" name="item_name" placeholder="商品名" >
    <p>※全角127文字以内</p>
    <hr>
    <strong>消費税設定</strong><br><br>
    <input type="radio" name="consumption_tax_setting" id="consumption_tax_setting" value="Standard" onclick="fnRadioName();" />標準
    <input type="radio" name="consumption_tax_setting" id="consumption_tax_setting" value="TaxExempt" onclick="fnRadioName();" />非課税
    <label for="Standard">※　価格欄には「税込価格」を入力</label>
    <label for="TaxExempt">※　価格欄には「非課税価格」を入力</label>
    <hr>
    <strong>販売価格</strong><br><br>
    <input type="text" name="item_price" placeholder="商品価格（税込）" >
    <p>※半角8文字以内／半角カンマ（,）半角ピリオド（.）不要</p>
    <p>※定期購入・頒布会用として登録する場合は350円以上</p>
    <p>※バリエーションごとに価格を設定する場合は最低価格を入力</p>
    <hr>
    <strong>単位</strong><br><br><input type="text" name="item_unit" placeholder="商品単位" >
    <br><p>例：「個」「枚」「本」「セット」など</p>
    <hr>
    <strong>メモ</strong><br><br><textarea rows="4" cols="40" name="memo" placeholder="メモ" ></textarea>
    <hr>
    <strong>カテゴリ</strong><br><br>
    <select multiple="multiple" name="item_category">
      <?php for($i = 0; $i < sizeof($category); $i++){ ?>
        <option value="<?=$category[$i]?>"><?php echo $category[$i] ?></option>
      <?php } ?>
    </select>
    <br><br>
    </div>
    <hr>
    <div>
    <br><br>
    <button type="submit">Submit</button>
    <br><br><br><br><br><br>
    </div>
    </form>
  </center>
  </body>
</html>
