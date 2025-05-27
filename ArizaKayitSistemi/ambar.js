let currentPage = 1;
let aktifArama = '';

function malzemeleriGetir(sayfa = 1, arama = '') {
    currentPage = sayfa;
    aktifArama = arama;

    const url = `malzeme-getir.php?page=${sayfa}&q=${encodeURIComponent(arama)}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('malzeme-tablosu');
            tbody.innerHTML = '';

            data.malzemeler.forEach(malzeme => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${malzeme.id}</td>
                    <td>${malzeme.tur}</td>
                    <td>${malzeme.marka}</td>
                    <td>${malzeme.model}</td>
                    <td>${malzeme.adet}</td>
                    <td>
                        <button onclick="stokGuncelle(${malzeme.id}, 'artir')"><i class='bx bx-up-arrow'></i></button>
                        <button onclick="stokGuncelle(${malzeme.id}, 'azalt')"><i class='bx bx-down-arrow'></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updatePagination(sayfa, data.toplam_sayfa);
        });
}

function stokGuncelle(id, islem) {
    fetch('stok-guncelle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, islem })
    })
    .then(res => res.json())
    .then(() => malzemeleriGetir(currentPage, aktifArama));
}

function updatePagination(current, total) {
    const paginationDiv = document.querySelector('.pagination');
    paginationDiv.innerHTML = '';

    const prev = document.createElement('div');
    prev.innerHTML = "<i class='bx bxs-chevron-left'></i>";
    if (current > 1) {
        prev.onclick = () => malzemeleriGetir(current - 1, aktifArama);
    }
    paginationDiv.appendChild(prev);

    for (let i = 1; i <= total; i++) {
        const sayfa = document.createElement('div');
        sayfa.textContent = i;
        sayfa.classList.toggle('active', i === current);
        sayfa.onclick = () => malzemeleriGetir(i, aktifArama);
        paginationDiv.appendChild(sayfa);
    }

    const next = document.createElement('div');
    next.innerHTML = "<i class='bx bxs-chevron-right'></i>";
    if (current < total) {
        next.onclick = () => malzemeleriGetir(current + 1, aktifArama);
    }
    paginationDiv.appendChild(next);
}

document.addEventListener('DOMContentLoaded', () => {
    malzemeleriGetir();

    // Arama kutusu
    const aramaInput = document.querySelector('.urun-ara');
    aramaInput.addEventListener('input', () => {
        const arama = aramaInput.value.trim();
        malzemeleriGetir(1, arama);
    });

    // Ürün ekle butonuna tıklama
    document.querySelector('.add_new').addEventListener('click', () => {
        document.getElementById('urunEkleModal').style.display = 'flex';
    });

    // Modal kapatma
    document.getElementById('modalKapat').addEventListener('click', () => {
        document.getElementById('urunEkleModal').style.display = 'none';
    });

    // Form gönderme
    document.getElementById('urunEkleForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('urun-ekle.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(cevap => {
            if (cevap.success) {
                alert("Ürün eklendi!");
                this.reset();
                document.getElementById('urunEkleModal').style.display = 'none';
                malzemeleriGetir(currentPage, aktifArama);
            } else {
                alert("Ürün eklenirken bir hata oluştu.");
            }
        });
    });
});
