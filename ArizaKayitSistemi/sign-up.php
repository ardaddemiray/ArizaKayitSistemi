<!DOCTYPE html>
<html>
<head>
	<title>AKS | Kayıt</title>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="images/wave.png">
	<div class="container">
		<div class="img">
			<img src="images/phone.svg">
		</div>
		<div class="login-content">
			<form method="POST" id="form">
				<img src="images/avatar.svg">
				<h3 class="title">Sağlık e-postası ile kaydınızı oluşturunuz.</h3>
           		<div>
                    <label for="ad-input">
                    <i class='bx  bx-user'></i> 
                    </label>
                    <input type="text" name="ad" id="ad-input" placeholder="Adınız">
                </div>
                <div>   
                    <label for="soyad-input">
                    <i class='bx  bx-user'></i>
                    </label>
                    <input type="text" name="soyad" id="soyad-input" placeholder="Soyadınız">
                </div>
                <div>
                    <label for="eposta-input">
                    <i class='bx  bx-envelope'></i> 
                    </label>
                    <input type="email" name="eposta" id="eposta-input" placeholder="Sağlık e-posta adresiniz">
                </div>
            	<div>
                    <label for="sifre-input">
                    <i class='bx  bx-lock'></i> 
                    </label>
                    <input type="password" name="sifre" id="sifre-input" placeholder="Şifreniz">
                </div>
                <p>Hesabın var mı? <a href="login.php">Giriş Yap</a></p>    
            	<button type="submit">KAYIT OL</button>
                <p id="error-message"></p>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="validation.js"></script>
</body>
</html>