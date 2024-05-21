<section id="login">

    <div class="login__container container">

        <form action="index.php?ctrl=security&action=login" method="POST">

            <div class="form__group">
                <label for="email">Enter your email</label>
                <input type="email" name="email" id="email" aria-label="Email">
            </div>

            <div class="form__group">
                <label for="password">Enter your password</label>
                <input type="password" name="password" id="password" aria-label="Password">
            </div class="form__group">

            <div>
                <input class="showPassword" type="checkbox" onclick="showPassword()">
                <span>Show Password</span>
            </div>

            <button type="submit" name="submit" value="Sign In" aria-label="Sign In Button">
                <span>Sign In</span>
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