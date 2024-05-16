<?php require_once './partials/site/header.php'; ?>
<main>
    <div class="container">
        <form class="auth-form surface-white padding-40 border-radius-12 d-flex flex-column gap-24"
            action="/login" method="post">
            <h4 class="text-center">Log in to TeamUpStart</h4>

            <div class="auth-form__fields d-flex flex-column gap-12">
                <div class="auth-form__field d-flex flex-column gap-4">
                    <p class="body-m-regular">E-mail</p>
                    <input class="border-grey navigation-label" type="email" placeholder="example@gmail.com"
                        name="email" required>
                </div>
                <div class="auth-form__field auth-field d-flex flex-column gap-4">
                    <p class="body-m-regular">Password</p>
                    <div class="auth-field__wrapper-input d-flex">
                        <input class="border-grey navigation-label" type="password" placeholder="Create your password"
                            name="password" required>
                        <img src="./assets/img/icon/visibility_on.png" alt="visibility_on">
                    </div>

                </div>
            </div>
            <button class="btn-form btn-large surface-action text-on-action">Log in</button>
            <p class="body-m-regular text-primary text-center">If you do not have an account - <a class="text-action" href="/register">register.</a></p>
        </form>
    </div>
</main>
</div>
<?php require_once './partials/site/footer.php'; ?>