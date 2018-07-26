<?php
include "conn.php";
$time=time();
// echo $time;
$sql = $mysqli->query("INSERT INTO `test_1024`(id,num,status) VALUES ('','$time','1');");
$result = $mysqli->query("SELECT * FROM test_1024 WHERE num=$time;");
$ti=$result->fetch_assoc();
// echo json_encode($ti);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="renderer" content="webkit" />
  <meta http-equiv="X-UA-Compatible" content="IE=EDGE, chrome=1">  
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="format-detection" content="telephone=yes" />
  <meta name="msapplication-tap-highlight" content="no" />
  <meta name="format-detection" content="telephone=no" /> 
  <link rel="stylesheet" type="text/css" href="css/left.css"/>
  <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
  <script type="text/javascript" src="js/qrcode.js"></script>

 <title>left</title>
</head>

<body>
  <div class="container">
    <div id="qrcode" ></div>
    <div class="content">
    <img class="car_left moveleft" src="img/car.png">
    <img class="erweima" id="erweima">
    </div>
  </div>
  <script>
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width :  200,//设置宽高
        height : 200
    });
    qrcode.makeCode("http://wx.issmart.com.cn/poster/fan/fan/condemo/shuangping/right.php?time=<?php echo $ti["num"] ?>");

</script>
<script type="text/javascript">
  var num=<?php echo $ti["num"] ?>;
  console.log(num);
  var ti=setInterval(function(){
    $.ajax({                      
            type:"POST",
            url:"data.php",                        
            data:{"num":num},
            dataType:"json",
            success:function(data){ 
            console.log(data);                       
              if(data.status==123)
              {
                $('#qrcode').hide();
                $('.car_left').show();
                $('.car_left').addClass("moveleft");
                clearInterval(ti); 

              }
              
            },                        
            error:function(jqXHR) {
                console.log(0); 
            }                    
          });
  },1000)
</script>
</body>
</html>