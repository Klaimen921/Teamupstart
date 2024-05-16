<?php require_once './partials/site/header.php'; ?>
<main>
    <div class="container">
        <form class="auth-form surface-white padding-40 border-radius-12 d-flex flex-column gap-24"
            action="/register" method="post">
            <h4 class="text-center">Register to TeamUpStart</h4>
            <p class="auth-form__sub-title navigation-label text-center">
                Here you can find people for <br> your project completely free of charge.
            </p>
            <div class="auth-form__fields d-flex flex-column gap-12">
                <div class="auth-form__field d-flex flex-column gap-4">
                    <p class="body-m-regular">Name</p>
                    <input class="border-grey navigation-label" type="text" placeholder="John Doe" name="name" required>
                </div>
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
                <div class="form__skills d-flex gap-8 flex-no-wrap">
                    <div class="project-type__item flex-1">
                        <input type="radio" name="type_user" value="job_seeker" checked>
                        <div class="project-type__btn surface-neutral">
                            <p class="body-m-regular text-on-action text-center">Job seeker</p>
                        </div>
                    </div>

                    <div class="project-type__item flex-1">
                        <input type="radio" name="type_user" value="employer">
                        <div class="project-type__btn surface-neutral">
                            <p class="body-m-regular text-on-action text-center">Employer</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn-form btn-large surface-action text-on-action">Register</button>
            <p class="body-m-regular text-primary text-center">If you have an account - <a class="text-action" href="/login">log in.</a></p>
        </form>
    </div>
</main>
</div>
<?php require_once './partials/site/footer.php'; ?>