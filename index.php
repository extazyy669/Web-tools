<?php
// error_reporting(0);
session_start();

include('koneksi.php');




function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// $ipaddr = [];

// $sip = mysqli_query($conn, "SELECT * FROM `whitelist`");


// while($d = mysqli_fetch_assoc($sip))
// {
//     array_unshift($ipaddr, $d['ipaddress']);
// }

// if (!in_array(get_client_ip(), $ipaddr)) {
//     exit('Unauthorized Ip Address : '.get_client_ip());
// }









if(!isset($_SESSION['user']))
{
    die("<script>window.location = 'login.php'; </script>");
}

$user = $_SESSION['user'];

$f = mysqli_query($conn, "SELECT * FROM user WHERE username = '${user}'");
$role = "";

while($x = mysqli_fetch_assoc($f))
{
    $role = $x['role'];
}



if(isset($_POST['add']))
{
    if($role != "admin")
    {
        die("Hengker Kah??? aowkoakw");
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    $tes = mysqli_query($conn, "INSERT INTO `user` (`username`, `password`, `role`) VALUES ('${username}', '${password}', 'user')");

    if($tes) {
        $addAlert = '<span class="error success" style="display: block;" id="limit"><i class="fa fa-check-circle" aria-hidden="true"></i> Success, Adding User</span>';
    } else {
        $addAlert = '<span class="error toomany" style="display: block;" id="limit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Failed, Error occured</span>';
    }

    $displayAdd = "block";
    $display = "flex";
}
if(isset($_POST['delete']))
{
    if($role != "admin")
    {
        die("Hengker Kah??? aowkoakw");
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    $tes = mysqli_query($conn, "DELETE FROM user WHERE username = '${username}'");

    if($tes) {
        $deleteAlert = '<span class="error success" style="display: block;" id="limit"><i class="fa fa-check-circle" aria-hidden="true"></i> Success, Deleting User</span>';
    } else {
        $deleteAlert = '<span class="error toomany" style="display: block;" id="limit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Failed, Error occured</span>';
    }

    $displayDelete = "block";
    $display = "flex";
}

if(isset($_GET['add']))
{
    if($role != "admin")
    {
        die("Hengker Kah??? aowkoakw");
    }
    $ip = $_POST['ip'];
    $tes = mysqli_query($conn, "INSERT INTO `whitelist` (`ipaddress`) VALUES ('${ip}')");

    if($tes) {
        $ipAlert = '<span class="error success" style="display: block;" id="limit"><i class="fa fa-check-circle" aria-hidden="true"></i> Success, Adding Ip</span>';
    } else {
        $ipAlert = '<span class="error toomany" style="display: block;" id="limit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Failed, Error occured</span>';
    }

    $displayIp = "block";
    $display = "flex";
    
}

if(isset($_GET['delete']))
{
    if($role != "admin")
    {
        die("Hengker Kah??? aowkoakw");
    }
    $ip = $_POST['ip'];
    $tes = mysqli_query($conn, "DELETE FROM whitelist WHERE ipaddress = '${ip}'");

    if($tes) {
        $ipAlert = '<span class="error success" style="display: block;" id="limit"><i class="fa fa-check-circle" aria-hidden="true"></i> Success, Deleting Ip</span>';
    } else {
        $ipAlert = '<span class="error toomany" style="display: block;" id="limit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Failed, Error occured</span>';
    }

    $displayIp = "block";
    $display = "flex";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>M O O N T O O N</title>
    <style>
        @font-face {
            font-family: 'ibm';
            src: url('https://saweria.co/ibm-plex-mono-latin-400.woff');
        }
        *
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'ibm';
            touch-action: pan-x pan-y;
        }

        body
        {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 60px 20px;
            background: #f2f7f5;
            overflow: auto;
        }

        .gateway
        {
            position: relative;
            width: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
        }
/* 
        .gateway span 
        {
            margin-bottom: 40px;
            text-align: center;
        } */

        span img 
        {
            position: relative;
            top: 4px;
        }

        .gateway .form
        {
            margin-top: 45px;;
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            border: 1px solid #000;
            background: #E2E8F0;
            box-shadow: 0.2rem 0.2rem 0 #222;
            border-radius: 3px;
            gap: 20px;
        }

        .gateway h1
        {
            text-align: center;
            font-size: 1.6em;
        }

        
        .gateway .response
        {
            position: relative;
            width: 100%;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 0 20px;
            margin-top: 30px;
            gap: 10px;
        }

        .gateway .progress
        {
            position: relative;
            width: 100%;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 0 40px;
        }

        .progress progress
        {
            width: 100%;
            border: 1px solid #000;
            border-radius: 5px;
            height: 15px;
            background: #8bd3dd;
            box-shadow: 0.2rem 0.2rem 0 #222;
            color: #fff;
        }

        .progress i 
        {
            font-size: 12px;
        }

        progress::-moz-progress-bar
        {
            background: #8bd3dd;
        }
        progress::-webkit-progress-value 
        {
            background: #8bd3dd;
            border-radius: 5px;
        }

        .response textarea
        {
            width: 100%;
            padding-left: 5px;
            background: #A0AEC0;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
        }

        .form  label
        {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        label input
        {
            width: 100%;
            border: 1px solid #000;
            border-radius: 5px;
            height: 40px;
            padding-left: 5px;
            background: #A0AEC0;
            box-shadow: 0.4rem 0.4rem 0 #222;
        }
        label .ip
        {
            width: 100%;
            border: 1px solid #000;
            border-radius: 5px;
            height: 20px;
            padding-left: 5px;
            background: #A0AEC0;
            box-shadow: 0.2rem 0.2rem 0 #222;
            margin-bottom: -10px;
        }

        label input::placeholder
        {
            color: #000;
        }

        label textarea
        {
            padding-left: 5px;
            border-radius: 5px;
            background: #A0AEC0;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
        }

        label select
        {
            width: 100%;
            border: 1px solid #000;
            border-radius: 5px;
            height: 40px;
            padding-left: 5px;
            background: #A0AEC0;
            box-shadow: 0.4rem 0.4rem 0 #222; 
        }

        *:focus
        {
            outline: none;
        }

        .form button
        {
            padding: 5px 10px;
            margin-top: 10px;
            background: #faae2b;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
            border-radius: 3px;
        }

        .gateway .source
        {
            position: fixed;
            top: 5px;
            right: 10px;
            padding: 5px 10px;
            margin-top: 10px;
            background: #faae2b;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
            border-radius: 3px;
            z-index: 99999999999;
        }

        .gateway .imgBox
        {
            position: relative;
            width: 250px;
        }

        .imgBox img
        {
            max-width: 100%;
        }
        .gateway .save
        {
            position: fixed;
            top: 5px;
            left: 10px;
            padding: 5px 10px;
            margin-top: 10px;
            background: #9DBC98;
            box-shadow: -0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
            border-radius: 3px;
        }

        footer
        {
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scode
        {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #fff;
            height: 100%;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 30px;
        }

        .scode .form
        {
            margin-top: 45px;;
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            border: 1px solid #000;
            background: #E2E8F0;
            box-shadow: 0.2rem 0.2rem 0 #222;
            border-radius: 3px;
            gap: 20px;
        }

        .scode i
        {
            position: fixed;
            top: 5px;
            right: 10px;
            padding: 5px 10px;
            margin-top: 10px;
            background: #faae2b;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
            border-radius: 3px;
        }

        .scode button
        {
            padding: 5px 10px;
            margin-top: 10px;
            background: #faae2b;
            box-shadow: 0.4rem 0.4rem 0 #222;
            border: 1px solid #000;
            border-radius: 3px;
        }

        .error
        {
            color: #fff;
            padding: 6px 10px;
            border:1px solid #222;
            border-radius: 3px;
            display: none;
        }

        .toomany
        {
            background: #EA5B60;
        }

        .success
        {
            background: #90EE90;
        }

        .form ol
        {
            margin-top: 20px;
            width: 100%;
            padding:0 30px;
            display: none;
            word-wrap: break-word;
        }

        .form ol li
        {
            font-size: 13px;
            line-height: 24px;
        }
        .form ol li strong
        {
            background: #EA5B60;
            padding: 0 5px;
            border-radius: 3px;
            
        }
        .form ol li img
        {
            max-width: 100%;
            border: 1px solid #222;
            border-radius: 3px;
        }

        .form ol li code
        {
            background: #8bd3dd;
            padding: 3px;
            border-radius: 3px;
        }

        a
        {
            text-decoration: none;
            color: #222;
        }

        form 
        {
            width: 100%;
        }
        

        @media(max-width: 560px)
        {
            .error
            {
                font-size: 12px;
            }
        }

        @media(max-width: 600px)
        {
            .gateway 
            {
                max-width: 100%;
            }

        }

    </style>
</head>
<body>
    <input type="text" value="misalnya" id="urlcopy" style="display: none">
    <div class="gateway">
        <?php if($role == "admin") { ?>
            <div onclick="toggleSource()" class="source"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <?php } else { ?>
            <div class="source"><a href="logout.php">Logout</a></div>
        <?php } ?>
        <div class="imgBox">
            <img src="https://images.glints.com/unsafe/glints-dashboard.s3.amazonaws.com/company-logo/ce281285d642ee8c12db84c666aa0a34.png">
        </div>
        <h1>C H A N G E B I N D<br>TOOLS</h1>
        <span><?= $_SESSION['user']; ?> - <?= get_client_ip(); ?></span>


        <div class="form">
            <div class="alert">
                <span class="error toomany" id="limit"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Too many request, plz try again later</span>
                <span class="error toomany" id="wrong"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Wrong email, plz enter valid email</span>
                <span class="error toomany" id="invalid"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Invalid account, plz enter valid account</span>
                <span class="error success" id="success"><i class="fa fa-check-circle" aria-hidden="true"></i> Success, plz check your Email</span>
            </div>
            <label>
                Email
                <input class="aq" id="email" placeholder="eg: moonton@email.com">
            </label>
            
            <label>
                Language
                <select id="lang">
                    <option selected diabled value="id">Default Indonesia!</option>
                    <option value="ja">Japan</option>
                    <option value="en">English</option>
                    <option value="vi">Vietnam</option>
                    <option value="ru">Russia</option>
                    <option value="ar">Arab</option>
                    <option value="id">Indonesia</option>
                    <option value="cn">China</option>
                    <option value="tw">Taiwan</option>
                    <option value="kh">Kamboja</option>
                    <option value="ko">Korea</option>
                    <option value="ro">Romania</option>
                    <option value="hu">Hungaria</option>
                    <option value="ce">Czech</option>
                </select>
            </label>

            <button id="send">Submit</button>
        </div>

        <div class="form">
            <label>
                Code
                <input class="aq" id="code" placeholder="eg: 123456">
            </label>

            <button id="generate">Generate</button>
                <ol id="tutor">
                    <li>Silahkan salin link berikut <code onclick="copyUrl()" id="iniurl">-</code> <strong>Dilarang membuka link di Chrome atau Browser lain</strong></li>
                    <li>Login ke aplikasi MLBB</li>
                    <li>Tekan pusat akun <img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/9a8dfa88f5bf12ac1de8c12acf749085.png"></li>
                    <li>Tekan ubah alamat Email, <strong>Wajib menggunakan akun yang tidak Kontak GM</strong><img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/626f0d4fb958858658dbea3d20734639.png"></li>
                    <li>Setelah muncul popup ubah Email, Tekan kembali untuk melanjutkan CE<img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/7a49c1e89eea6679da40b25230dd5d2d.png"></li>
                    <li>Kemudian kembali ke halaman awal Mobile Legends, lalu tekan Customer Service<img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/0d846d5d0fe2184c204c7bc2e0ff5990.png"></li>
                    <li>Kemudian tempel link yang sudah di salin di atas lalu klik kirim<img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/23af1e7b2cd670d8f3c608b93e30a55c.png"></li>
                    <li>Kemudian klik link yang sudah dikirim dan lakukan penggantian Email<img src="https://akmweb.youngjoygame.com/web/account_retrieval/image/4a53eef4ce98d1f7faf958c84171ddc6.png"></li>
                    <li><code>Enjoyyyyyyy!!!!!!!</code></li>
                </ol>
        </div>
    </div>

    <div class="scode" style="display: <?= (isset($display) ? $display : "none"); ?>">
        <i onclick="toggleSource()"><i class="fa fa-times" aria-hidden="true"></i></i>
        <h1>ADMIN MENU</h1>
        <span>- WELCOME - </span>
        <div class="ipaddress">
        <button onclick="showAdd()">ADD USER</button>
        <button onclick="showDelete()">DELETE USER</button>
        <button onclick="showIp()">IP MENU</button>
        <button><a href="logout.php">LOGOUT</a></button>
        </div>




        <form action="index.php" method="POST" id="adduser" style="display: <?= (isset($displayAdd) ? $displayAdd : "none"); ?>">
        <div class="form">
            <h2>ADD USER</h2>
        <div class="alert">
            <?php
            if(isset($addAlert)) {
                echo $addAlert;
            }
            ?>
        </div>
        <label>
            Username
            <input class="aq" name="username" placeholder="Username">
        </label>
        
        <label>
            Password
            <input class="aq" name="password" type="password" placeholder="Kata Sandi">
        </label>

        <button type="submit" name="add">ADD USER</button>
        </div>
        </form>


        <form action="index.php" method="POST" id="deleteuser" style="display: <?= (isset($displayDelete) ? $displayDelete : "none"); ?>">
        <div class="form">
            <h2>DELETE USER</h2>
        <div class="alert">
            <?php
            if(isset($deleteAlert)) {
                echo $deleteAlert;
            }
            ?>
        </div>
        <label>
            Username
            <input class="aq" name="username" placeholder="Username">
        </label>

        <button type="submit" name="delete">DELETE USER</button>
        </div>
        </form>

        
        <form action="index.php" method="POST" id="whitelist" style="display: <?= (isset($displayIp) ? $displayIp : "none"); ?>">
        <div class="form">
            <h2>WHITELIST</h2>
        <div class="alert">
            <?php
            if(isset($ipAlert)) {
                echo $ipAlert;
            }
            ?>
        </div>
        <?php

            $S = mysqli_query($conn, "SELECT * FROM whitelist");

            $count = mysqli_num_rows($S);


            if($count == "0") 
            {
        ?>  
        No Ip Found
        <?php  } else { 


            while($d = mysqli_fetch_assoc($S)) { ?>
            
            <label><input type="text" class="ip" value="<?= $d['ipaddress']; ?>" readonly></label>
            
            
        
        
        <?php } } ?>



        <label>
            Ip Address
            <input class="aq" name="ip" placeholder="Ip Address">
        </label>

        <div class="ipaddress">
        <button type="submit" formaction="index.php?add=1">ADD IP</button>
        <button type="submit" formaction="index.php?delete=1">DELETE IP</button>
        </div>
        </div>
        </form>




    </div>

    <footer>
        Mau sewa tools? sok ath wa <a href="https://wa.me/6282130744247" style="text-decoration: none;margin: 0 10px"> 6282130744247 </a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // let email = document.querySelector("#email").value;
        // let lang = document.querySelector("#lang").value;
        // let code = document.querySelector("#code").value;
        let status = "<?= (isset($display) ? "show" : "hide"); ?>";
        let btn = document.querySelector('#send');
        let gen = document.querySelector("#generate");
        btn.addEventListener('click', e => {

            let email = $('#email').val();
            let lang = $('#lang').val();



            $('#wrong').hide();
            $('#success').hide();
            $('#limit').hide();
            $('#invalid').hide();
            e.target.innerHTML = '<i class="fa fa-circle-o-notch fa-spin"></i>';
            $.ajax({
                url: 'sendCode.php',
                method: 'POST',
                data: new URLSearchParams(Object.entries({
                    email: email,
                    lang: lang
                })).toString(),
                dataType: 'json',
                success: function(ex) {
                    console.log(ex.message)
                    switch(ex.message) {
                        case 'Error_EmailEmpty': {
                            $('#wrong').show();
                        }
                        break;

                        case 'Error_FailedTooMuch': {
                            $('#limit').show();
                        }
                        break;
                        case 'Error_Success': {
                            $('#success').show();
                        }
                        break;
                        case 'Error_InvalidAccount': {
                            $('#invalid').show();
                        }
                    }


                    e.target.innerHTML = 'Submit';
                }
            })
            
            
        })


        function toggleSource()
        {
            let element = document.querySelector(".scode");

            if(status == "hide")
            {
                element.style.display = "flex";
                status = "show";
            } else {
                element.style.display = "none";
                status = "hide";
            }

        }

        gen.addEventListener('click', e => {
            let code = document.querySelector("#code").value;
            let email = document.querySelector("#email").value; 
            document.querySelector("#tutor").style.display = 'block';
            let paste = 'https://mtacc.mobilelegends.com/v2.1/inapp/changebind-page?code=' + code + '&email=' + email + '&guid=&type=email';
            document.querySelector("#urlcopy").value = paste;
            document.querySelector("#iniurl").innerText = paste;
            
        })

        function copyUrl() {
        var copyText = document.getElementById("urlcopy");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(copyText.value);
        alert("URL Berhasil di salin");
        }


        function showAdd()
        {
            $('#adduser').fadeIn();
            $('#deleteuser').hide();
            $('#whitelist').hide();
        }
        function showDelete()
        {
            $('#adduser').hide();
            $('#deleteuser').fadeIn();
            $('#whitelist').hide();
        }
        function showIp()
        {
            $('#adduser').hide();
            $('#deleteuser').hide();
            $('#whitelist').fadeIn();
        }

    </script>
</body>
</html>
