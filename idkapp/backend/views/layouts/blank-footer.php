<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>

<script>
    document.getElementById("toggle-password").addEventListener("click", function() {
        var passwordInput = document.getElementById("password-input");
        var icon = this.querySelector(".eye-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.innerHTML = '🙈 <small class="text-muted">Hide Password</small>'; // Menggunakan innerHTML
        } else {
            passwordInput.type = "password";
            icon.innerHTML = '👁️ <small class="text-muted">Show Password</small>';
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".theme-form");
        const overlay = document.getElementById("overlaySpinner");

        form.addEventListener("submit", function(e) {
            overlay.style.display = "flex"; // Tampilkan spinner saat submit
        });
    });

    let redirectUrl = "";

    function showModal(message, isSuccess = false, url = '') {
        document.getElementById("overlaySpinner").style.display = "none"; // Sembunyikan spinner
        document.getElementById("modalMessage").innerText = message;
        document.getElementById("modalNotif").style.display = "flex";

        const modalIcon = document.getElementById("modalIcon");
        const modalHeader = document.getElementById("modalHeader");

        if (isSuccess) {
            modalIcon.innerHTML = "✅";
            modalIcon.classList.add("success-icon");
            modalHeader.innerText = "Berhasil!";
            redirectUrl = url;
            document.getElementById("redirectMessage").style.display = "block";

            let countdown = 5;
            const interval = setInterval(() => {
                countdown--;
                document.getElementById("countdown").innerText = countdown;
                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = redirectUrl;
                }
            }, 1000);
        } else {
            modalIcon.innerHTML = "❌";
            modalIcon.classList.add("error-icon");
            modalHeader.innerText = "Gagal!";
        }
    }

    function closeModal() {
        document.getElementById("modalNotif").style.display = "none";
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    }

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        showModal("<?= Yii::$app->session->getFlash('error') ?>");
    <?php elseif (Yii::$app->session->hasFlash('success')): ?>
        showModal("<?= Yii::$app->session->getFlash('success') ?>", true, "<?= Url::to(['/site/index-main']) ?>");
    <?php endif; ?>
</script>