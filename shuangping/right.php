

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
	<link rel="stylesheet" type="text/css" href="css/right.css"/>
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<title>right</title>
</head>
<body>
	<div class="container">
		<!-- <div class="content"> -->
		<img class="car_right" src="img/car.png">
		<!-- </div> -->
	</div>
<?php
include 'conn.php';
$num=$_GET['time'];
$user = $mysqli->query("UPDATE test_1024 SET status=123 WHERE num=$num");
?>
<script type="text/javascript">
  var num=<?php echo $num;?>;
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
                $('.car_right').show();
              	$('.car_right').addClass("moveleft");
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
