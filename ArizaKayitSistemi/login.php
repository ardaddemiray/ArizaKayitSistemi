<!DOCTYPE html>
<html>
<head>
	<title>AKS | Giriş</title>
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
			<form method="POST" id="login-form">
				<img src="images/avatar.svg">
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
                <p>Sisteme üye değil misin? <a href="sign-up	.php">Üye Ol!</a></p>    
            	<button type="submit">GİRİŞ</button>
                <p id="error-message"></p>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="validation.js"></script>
</body>
</html>