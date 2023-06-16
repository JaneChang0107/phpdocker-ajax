<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Example PHP+PDO+POO+MVC</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
    <style>
        input {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .right {
            float: right;
        }
    </style>
</head>

<body>
    <div class="col-lg-5 mr-auto">
        <form action="index.php?controller=employees&action=actualizar" method="post" id="contact-form">
            <h3>User detail</h3>
            <hr />
            <input type="hidden" name="id" id="id" value="<?php echo $datos["employee"]->id ?>" />
            Name: <input type="text" name="Name" id="Name" value="<?php echo $datos["employee"]->Name ?>" class="form-control" />
            Gender:
            <input type="radio" name="Surname" id="Surname" <?php echo ($datos["employee"]->Surname == 'boy') ? 'checked' : '' ?> value="boy" /> boy
            <input type="radio" name="Surname" id="Surname" <?php echo ($datos["employee"]->Surname == 'girl') ? 'checked' : '' ?> value="girl" /> girl
            <br />
            Email: <input type="text" name="email" id="email" value="<?php echo $datos['employee']->email ?>" class="form-control" />
            phone: <input type="text" name="phone" id="phone" value="<?php echo $datos['employee']->phone ?>" class="form-control" />
            <input type="submit" value="Send" id="send" class="btn btn-success" />
            <div id="retrieve"></div>
        </form>
        <a href="index.php" class="btn btn-info">Return</a>
    </div>
</body>
<script>
    $(document).ready(function() {
        var form = $("#contact-form");
        //transform form content to json object
        var before = convertFormToJSON(form);

        function convertFormToJSON(form) {
            // Encodes the set of form elements as an array of names and values.
            var array = $(form).serializeArray();
            var json = {};
            $.each(array, function() {
                json[this.name] = this.value || "";
            });
            return json;
        }

        //detect change
        $("#contact-form").change(function() {
            //set json object to local storage
            setChangedDataToLocalStorage();
        });

        //set json object to local storage function
        function setChangedDataToLocalStorage() {
            $this = $("#contact-form");
            var after = convertFormToJSON($this);
            if (before === after) {
                return;
            } else {
                setWithExpiry('testObject', after, 5000)
            }
        };

        //create object with expiry function
        function setWithExpiry(key, value, ttl) {
            const now = new Date()
            // `testObject` is an object which contains the original value
            // as well as the time when it's supposed to expire
            var expirytime = (now.getTime() + ttl).toString();
            var content = JSON.stringify(value);
            localStorage.setItem(key, content);
            localStorage.setItem("expirytime", expirytime);
        }

        //if localStorage is not null then create the retrieve button
        if (localStorage.getItem('testObject') != null) {
            var html = `<input type="button" value="retrieve" class="btn btn-danger"/>`
            $("#retrieve").html(html);
        };

        //click retrieve button to get data at local storage
        $("#retrieve").click(function() {
            var dataFromLocalstorage = localStorage.getItem('testObject');
            var obj = JSON.parse(dataFromLocalstorage);
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    // console.log(`${key}: ${obj[key]}`);
                    //set retrieved velue to form
                    if ($(`input[name=` + key + `]`).attr('type') == 'radio') {
                        $("input[name=" + key + "][value=" + obj[key] + "]").prop('checked', true);
                    } else {
                        $(`input[name=` + key + `]`).val(obj[key]);
                    }
                }
            }
        });

        getWithExpiry("testObject");

        function getWithExpiry(key) {
            const expirytime = localStorage.getItem("expirytime")
            // if the item doesn't exist, return null
            if (!expirytime) {
                return null;
            }
            const now = new Date();
            alert(now.getTime());
            // compare the expiry time of the item with the current time          
            if (now.getTime() > expirytime) {
                alert("time's up");
                // If the item is expired, delete the item from storage and return null
                localStorage.removeItem(key);
                localStorage.removeItem("expirytime");
                // clear retrieve button
                $("#retrieve").html("");
                return null;
            }
            return null;
        }

        $("#send").click(function() {
            localStorage.removeItem('testObject');
            localStorage.removeItem('expirytime');
        });
    });
</script>

</html>