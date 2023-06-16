<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Example PHP+PDO+POO+MVC</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script
        src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
        integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE="
        crossorigin="anonymous"></script>
        <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
        </style>
    </head>
    <body>
        <div class="col-lg-5 mr-auto">
            <form action="index.php?controller=employees&action=actualizar" method="post">
                <h3>User detail</h3>
                <hr/>
                <input type="hidden" name="id" id="id" value="<?php echo $datos["employee"]->id ?>"/>
                Name: <input type="text" name="Name" id="name" value="<?php echo $datos["employee"]->Name ?>" class="form-control"/>
                Surname: <input type="text" name="Surname" id="surname" value="<?php echo $datos['employee']->Surname ?>" class="form-control"/>
                Email: <input type="text" name="email" id="email" value="<?php echo $datos['employee']->email ?>" class="form-control"/>
                phone: <input type="text" name="phone"  id="phone" value="<?php echo$datos['employee']->phone ?>" class="form-control"/>
                <input type="submit" value="Send" id="send" class="btn btn-success"/>
                <div id="retrieve"></div>
            </form>
            <a href="index.php" class="btn btn-info">Return</a>
        </div>
    </body>
    <script>

        // var val = $("#name").val();
        // console.log(val);


        // var phone = $("#phone").val();
        // $("#phone").change(function() {
        //     phone =  $(this).val();
        //     localStorage.setItem('phone',phone);
        // });

        // if(localStorage.getItem('phone') != null){
        //     var html=`<input type="button" value="retrieve" class="btn btn-danger"/>`
        //     $("#retrieve").html(html);
        // }
        // $("#retrieve").click(function(){           
        //     var dataFromLocalstorage = localStorage.getItem('phone');
        //     console.log(dataFromLocalstorage);
        //     $("#phone").val(dataFromLocalstorage);
        // });

    $(document).ready(function(){

		var phone = $("#phone").val();
		
        $("#phone").change(function() {
            phone =  $(this).val();
            setWithExpiry("phone", phone, 30000);
        });

		if(localStorage.getItem('phone') != null){
            var html=`<input type="button" value="retrieve" class="btn btn-danger"/>`
            $("#retrieve").html(html);
        }

        $("#retrieve").click(function(){           
            var dataFromLocalstorage = localStorage.getItem('phone');
            console.log(dataFromLocalstorage);
            $("#phone").val(dataFromLocalstorage);
        });
		
        getWithExpiry("phone");

        function setWithExpiry(key, value, ttl) {
            const now = new Date()
            // `item` is an object which contains the original value
            // as well as the time when it's supposed to expire
            var expirytime=(now.getTime() + ttl).toString();
            const item = {
                value: value,
                expiry: expirytime
            }
            //  let dd = new Date(now.getTime() + ttl);
            //  console.log(dd.toString() + "<br />");            
            localStorage.setItem(key, JSON.stringify(item))
        }

        function getWithExpiry(key) {
			const itemStr = localStorage.getItem(key)

			// if the item doesn't exist, return null
			if (!itemStr) {
				return null;
			}

			const item = JSON.parse(itemStr)
			const now = new Date()

			// compare the expiry time of the item with the current time
            alert (now.getTime());
			if (now.getTime() > item.expiry) {
                
				// If the item is expired, delete the item from storage
				// and return null
				localStorage.removeItem(key);
                $("#retrieve").html("");
				return null;
			}
			return item.value;
		} 

    });
        $("#send").click(function(){
            localStorage.removeItem('name');
        });
    </script>
</html>
