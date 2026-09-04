<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';
?>

<div class="auth-main v2">
    <div class="bg-overlay bg-dark"></div>
    <div class="auth-wrapper">

        <div class="auth-sidecontent">
            <div class="auth-sidefooter">
                <img src="<?= Url::base(true) ?>/lightapp/assets/images/bappeda.png" width="32px;" alt="images" />
                <hr class="mb-3 mt-4" />
                <div class="row">
                    <div class="col my-1">
                        <p class="m-0">Bappedalitbang Deli Serdang &copy; 2024 <a href="https://bappedalitbang.deliserdangkab.go.id" target="_blank">
                                Bappedalitbang</a></p>
                    </div>
                    <div class="col-auto my-1">
                        <!-- <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="../index.html">Home</a></li>
                            <li class="list-inline-item"><a href="https://pcoded.gitbook.io/light-able/" target="_blank">Documentation</a></li>
                            <li class="list-inline-item"><a href="https://phoenixcoded.support-hub.io/" target="_blank">Support</a>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>

        </div>
        <form class="auth-form" method="post" action="<?= Url::to(['/site/login']) ?>">
            <div class="card my-5 mx-3">

                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div class="card-body">
                    <?php if (Yii::$app->session->hasFlash('success')) : ?>
                        <div class="alert alert-success">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('error')) : ?>
                        <div class="alert alert-danger">
                            <?= Yii::$app->session->getFlash('error') ?>
                        </div>
                    <?php endif; ?>
                    <h4 class="f-w-500 mb-1">Aplikasi Infrastruktur</h4>
                    <p class="mb-3">Input Username and Password to Login <a href="../pages/register-v2.html" class="link-primary ms-1"></a></p>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="LoginForm[username]" placeholder="Username"">
                    </div>
                    <div class=" form-group mb-3">
                        <div class="form-input position-relative">
                            <input type="password" class="form-control" id="password-input" placeholder="Password" name="LoginForm[password]">
                            <div class="show-hide position-absolute end-0 top-50 translate-middle-y pe-3" id="toggle-password" style="cursor: pointer;">
                                <span class="eye-icon">👁️ <small class="text-muted">Show Password</small></span>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="show-password" onclick="togglePassword()">
                        <label class="form-check-label" for="show-password">Show Password</label>
                    </div> -->
                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                            <label class="form-check-label text-muted" for="customCheckc1">Remember me</label>
                        </div>
                        <!-- <a href="../pages/forgot-password-v2.html">
                            <h6 class="text-secondary f-w-400 mb-0">Forgot Password?</h6>
                        </a> -->
                    </div>

                    <div class="d-grid mt-4">
                        <input type="submit" class="btn btn-primary"></input>
                    </div>

                    <div class="saprator my-3">
                        <span><small><a href="https://esakipsimonalisa.deliserdangkab.go.id" target="_blank">Go to eSakip Simonalisa</a></small></span>
                        <!-- <span>Or continue with</span> -->
                    </div>
                    <div class="text-center">
                        <ul class="list-inline mx-auto mt-3 mb-0">
                            <!-- <li class="list-inline-item">
                                <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                                    <i class="fab fa-facebook-f text-white"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                                    <i class="fab fa-twitter text-white"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                                    <i class="fab fa-google text-white"></i>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal Notifikasi -->
        <!-- Modal Notifikasi -->
        <div id="modalNotif" class="modal">
            <div class="modal-content">
                <div id="modalIcon" class="modal-icon"></div>
                <div class="modal-header" id="modalHeader"></div>
                <p id="modalMessage"></p>
                <p id="redirectMessage" style="display: none;">Redirecting in <span id="countdown">5</span> seconds...</p>
                <button onclick="closeModal()">OK</button>
            </div>
        </div>


        <!-- CSS Modal -->
        <style>
            /* MODAL STYLING */
            .modal {
                display: none;
                position: fixed;
                z-index: 10000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
                animation: fadeIn 0.3s ease-in-out;
            }

            .modal-content {
                background-color: white;
                padding: 25px;
                width: 350px;
                text-align: center;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                animation: slideIn 0.3s ease-in-out;
                position: relative;
            }

            .modal-header {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .modal-icon {
                font-size: 40px;
                margin-bottom: 10px;
            }

            .success-icon {
                color: #28a745;
            }

            .error-icon {
                color: #dc3545;
            }

            #redirectMessage {
                font-size: 14px;
                color: #555;
                margin-top: 10px;
            }

            .modal button {
                margin-top: 15px;
                padding: 10px 20px;
                border: none;
                background-color: #007bff;
                color: white;
                font-size: 16px;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .modal button:hover {
                background-color: #0056b3;
            }

            /* ANIMATIONS */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-30px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
        <!--  -->
    </div>
</div>
<!-- [ Main Content ] end -->