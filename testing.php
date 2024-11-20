<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<form action="actions/action_login.php" method="POST">
    <input type="hidden" value="<?= $token ?>" name="token">
    <label for="">Email</label>
    <input type="text" name="email" placeholder="Masukan Email Anda" id="name" value="" required>
    <label for="">Password</label>
    <input type="password" placeholder="Masukan Password" name="password" required>
    <div class="button-login">
        <button type="submit">Masuk</button>
    </div>
    <div class="link-regist">
        <p>Belum punya akun?</p>
        <a href="registrasi">Daftar disini</a>
    </div>
</form>

</html>