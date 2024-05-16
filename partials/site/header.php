<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/style/index.css">
</head>

<body>
    <div class="wrapper">
        <div class="wrapper__top">
            <header class="surface-white padding-tb-12">
                <div class="container d-flex justify-content-between align-items-center">
                    <a href="./" class="header__logo">
                        <h5 class="custom-font text-primary">TEAMUPSTART</h5>
                    </a>
                    <div class="header__nav d-flex justify-content-between align-items-center gap-24">
                        <?php if (isset($_SESSION['role'])):?>
                            <?php if ($_SESSION['role'] == 'job_seeker'): ?>
                                <a href="/applications" class="navigation-header text-secondary">Applications</a>
                            <?php elseif ($_SESSION['role'] == 'employer'): ?>
                                <a href="/team" class="navigation-header text-secondary">Team</a>
                            <?php endif;?>
                        <?php endif?>

                        <a href="/search" class="navigation-header text-secondary">Survey</a>

                        <?php if (!isset($_SESSION['role'])): ?>
                            <a href="/register" class="navigation-header text-secondary">Register</a>
                        <?php else: ?>
                            <a href="/chats" class="navigation-header text-secondary">Chats</a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['role'])):?>
                            <a href="/like" class="header__right-link d-flex gap-4 align-items-center">
                                <img src="./assets/img/icon/star-active.svg" alt="star-active">
                                <p class="navigation-header text-secondary">Favorite</p>
                            </a>
                        <?php endif; ?>

                        <a href="
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            /admin
                        <?php else: ?>
                            /profile
                        <?php endif; ?> 
                        " class="header__right-link d-flex">
                            <svg width="24" class="icon-neutral d-flex" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.62317 21.6H4.60843C4.04369 21.5898 3.5919 21.1133 3.60172 20.5303C3.66556 15.7093 7.88885 13.2 12.0483 13.2H12.122C16.1095 13.2304 20.4016 15.5268 20.4016 20.51C20.4016 21.093 19.9449 21.5645 19.3801 21.5645C18.8154 21.5645 5.183 21.6 4.62317 21.6Z"
                                    fill="0" />
                                <path
                                    d="M12.0031 11.995C9.35773 11.995 7.20312 9.8443 7.20312 7.19501C7.20312 4.54573 9.35773 2.3999 12.0031 2.3999C14.6485 2.3999 16.8031 4.55062 16.8031 7.1999C16.8031 9.84919 14.6485 11.9999 12.0031 11.9999V11.995Z"
                                    fill="0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </header>