const form = document.getElementById('form');
const loginForm = document.getElementById('login-form');

const ad_input = document.getElementById('ad-input');
const soyad_input = document.getElementById('soyad-input');
const eposta_input = document.getElementById('eposta-input');
const sifre_input = document.getElementById('sifre-input');

const error_message = document.getElementById('error-message');

// KAYIT FORMU
if (form) {
    form.addEventListener('submit', (e) => {
        let errors = [];
        const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        errors = getSignupFormErrors(ad_input.value, soyad_input.value, eposta_input.value, sifre_input.value);

        if (errors.length > 0) {
            e.preventDefault();
            error_message.innerHTML = "<ul><li>" + errors.join("</li><li>") + "</li></ul>";
        }

        if (errors.length === 0) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch("kayit-isle.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    window.location.href = "login.php";
                }
            })
            .catch(err => {
                console.error("Hata:", err);
                alert("Bir hata oluştu. Lütfen tekrar deneyin.");
            });
        }
    });
}

// GİRİŞ FORMU
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        let errors = getLoginFormErrors(eposta_input.value, sifre_input.value);
        if (errors.length > 0) {
            error_message.innerHTML = "<ul><li>" + errors.join("</li><li>") + "</li></ul>";
            return;
        }

        const formData = new FormData(loginForm);
        fetch('giris-isle.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error("Hata:", err);
            alert("Bir hata oluştu.");
        });
    });
}

// VALIDASYON FONKSIYONLARI
function getSignupFormErrors(ad, soyad, eposta, sifre) {
    let errors = [];
    const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!ad.trim()) {
        errors.push("Ad alanını boş bırakamazsınız.");
        ad_input.parentElement.classList.add("incorrect");
    }

    if (!soyad.trim()) {
        errors.push("Soyad alanını boş bırakamazsınız.");
        soyad_input.parentElement.classList.add("incorrect");
    }

    if (!eposta.trim()) {
        errors.push("E-posta alanını boş bırakamazsınız.");
        eposta_input.parentElement.classList.add("incorrect");
    } else if (!emailReg.test(eposta)) {
        errors.push("Geçerli bir e-posta adresi giriniz.");
        eposta_input.parentElement.classList.add("incorrect");
    } else if (!eposta.endsWith("@saglik.gov.tr")) {
        errors.push("Sadece @saglik.gov.tr uzantılı e-posta ile kayıt olabilirsiniz.");
        eposta_input.parentElement.classList.add("incorrect");
    }

    if (!sifre.trim()) {
        errors.push("Şifre alanı boş bırakılamaz.");
        sifre_input.parentElement.classList.add("incorrect");
    } else if (sifre.length < 8) {
        errors.push("Şifreniz en az 8 karakter olmalıdır.");
        sifre_input.parentElement.classList.add("incorrect");
    }

    return errors;
}

function getLoginFormErrors(eposta, sifre) {
    let errors = [];
    const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!eposta.trim()) {
        errors.push("E-posta alanı boş bırakılamaz.");
        eposta_input.parentElement.classList.add("incorrect");
    } else if (!emailReg.test(eposta)) {
        errors.push("Geçerli bir e-posta adresi giriniz.");
        eposta_input.parentElement.classList.add("incorrect");
    }

    if (!sifre.trim()) {
        errors.push("Şifre alanı boş bırakılamaz.");
        sifre_input.parentElement.classList.add("incorrect");
    }

    return errors;
}

// HATA STİLİNİ TEMİZLE
const allInputs = [ad_input, soyad_input, eposta_input, sifre_input];
allInputs.forEach(input => {
    if (input) {
        input.addEventListener("input", () => {
            if (input.parentElement.classList.contains("incorrect")) {
                input.parentElement.classList.remove("incorrect");
                error_message.innerHTML = '';
            }
        });
    }
});
