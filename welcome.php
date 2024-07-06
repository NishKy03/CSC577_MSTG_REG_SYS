<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arial:wght@700&display=swap" />
    <title>Welcome Page</title>
</head>
<style>
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    width: 100%;
    background-color: #E2E0E0;
    background-size: cover;
    display: flex; 
    align-items: center; 
    flex-direction: column;
}
h1{
    font-family: 'Ibarra Real Nova';
    font-size: 60px;
    margin-top: 20px;
    line-height: 1.5;
    font-weight: 200;
}
.line-border{
    width: 55%;
    border: 1px solid;
}
p{
    margin-top: 30px;
    font-family: 'Inter';
    font-size: 20px;
}
.wrapper{
    margin-top: 40px;
    border: 2px solid;
    height: 467px;
    width: 662px;
    background-color: white;
    border: none;
    border-radius: 30px;
}
.wrapper p{
    text-align: center;
    font-size: 60px;
    font-family: 'Ibarra Real Nova';
    margin-top: 70px;
}
.wrapper a{
    width: 379px;
    border: 2px solid;
    height: 66px;
    align-items: center;
    justify-content: center;
    display: flex;
    margin-left: 135px;
    color: black;
    font-family: 'Inter';
    font-size: 25px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 100;
}
.wrapper .button1{
    margin-top: 25px;
    background-color: #D09B35;
    border: none;
}
.wrapper .button2{
    margin-top: 20px;
    border: 1px solid;
}
.img-class img{
    width: 150px;
    height: 150px;
    margin-top: 50px;
}
</style>
<body>
    <div class="img-class">
        <img src="logo.png" alt="">
    </div>
    
    <h1>WELCOME TO MAAHAD SAINS TOK GURU</h1>
    <div class="line-border"></div>
    <p>Melahirkan pelajar yang berprestasi tinggi dan mampu memimpin ummah berdasarkan al-Quran dan as-Sunnah</p>
    <div class="wrapper">
        <p>Hello!</p><br>
        <a href="login.php" class="button1">LOGIN</a>
        <a href="signup.php" class="button2">SIGN UP</a>
    </div>
</body>
</html>