<section id="register">

    <div class="register__container container">

        <form action="index.php?ctrl=register" method="POST">

            <div class="form__group">
                <label for="nickName">nickName</label>
                <input type="text" name="nickName" id="nickName" aria-label="nickName">
            </div>

            <div class="form__group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" aria-label="Email">
            </div>

            <div class="form__group">
                <label for="pass1">Password</label>
                <input type="password" name="pass1" id="password" aria-label="Password">
            </div>

            <div class="form__group">
                <label for="pass2">Confirm Password</label>
                <input type="password" name="pass2" id="password2" aria-label="Confirm Password">
            </div>

            <div>
                <input class="showPassword" type="checkbox" onclick="showPassword()"><span>Show Password</span>
            </div>


            <button type="submit" name="submit" value="Register" aria-label="Register Button">
                <span>Sign Up</span>
            </button>

        </form>

    </div>

</section>

<script>
    function showPassword() {
        let x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>